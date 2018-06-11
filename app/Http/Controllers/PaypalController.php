<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Model\Order;
use App\Model\Payment;
use App\User;
use Validator;

use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\PaymentExecution;
use Mail;
use App\Mail\UserMail;

class PaypalController extends Controller
{
    private $_api_context;
    public function __construct()
    {
        //------------------------
        //setup PayPal api context
        //------------------------
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function addPayTransaction(Request $request, Order $order)
    {
        $data = $request->all();
//        $data['amount'] = '30000';

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|regex:/[a-zа-яё]/iu',
            'last_name' => 'required|string|regex:/[a-zа-яё]/iu',
            'company' => 'required|string',
            'phone' => 'required|string|regex:/\d{6,18}/',
            'email' => 'required|string|email',
        ]);

        if($validator->fails()){

//            dd($this->getParameters($order));
            return view('order.paymentOrderForm',
                $this->getParameters($order)
            )->withErrors($validator);
        };
        
        $user = User::where('email', $data['email'])->first();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->phone = $data['phone'];
        $user->country = $data['country'];
        $user->save();
        \Session::put('user', $user);
        \Session::put('company', $data['company']);

//        dd($order);
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();
        $item_1->setName('order_'.$order->id)->setCurrency('USD')->setQuantity(1)->setPrice($request->amount);

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
//        $amount->setCurrency('USD')->setTotal(10000);
        $amount->setCurrency('USD')->setTotal($request->amount);
//        dd($amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setDescription('Your transaction description');
//        $transaction->setAmount($amount)->setItemList($item_list)->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('paypal_status')) //Specify return URL
            ->setCancelUrl(URL::route('paypal_status'));

        $paymentPayPal = new \PayPal\Api\Payment();
        $paymentPayPal->setIntent('Sale')->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $paymentPayPal->create($this->_api_context);
        }
        catch (\PayPal\Exception\PPConnectionException $ex)
        {
            if (\Config::get('app.debug')) {
                \Session::put('error','Connection timeout');
                return redirect()->route('getPayForm', ['order' => $order]);
//                return Redirect::route('paywithpaypal');
            }
            else {
                \Session::put('error','Some error occur, sorry for inconvenient');
                return redirect()->route('getPayForm', ['order' => $order]);
            }
        }

        foreach($paymentPayPal->getLinks() as $link) {
            if($link->getRel() == 'approval_url')
            {
                $redirect_url = $link->getHref();
                break;
            }
        }

        //--------------------------
        // add payment ID to session
        //--------------------------
        \Session::put('paypal_payment_id', $paymentPayPal->getId());
        \Session::put('order', $order);

        if(isset($redirect_url)) {
            //-------------------
            // redirect to paypal

            return Redirect::away($redirect_url);
        }

        \Session::put('error','Unknown error occurred (1)');
        return redirect()->route('getPayForm', ['order' => $order]);

        return $this->payPalPayment($order);
    }

    public function getPaymentStatus(Request $request)
    {
//        dd($request->all()); // PAY-8GY20870MC6302647LLBZEII
        //----------------------------------------
        // Get the payment ID before session clear

        $payment_id = $request->paymentId; //from get parameters

        $user = \Session::get('user');

        $order = \Session::get('order');
//        \Session::forget('order');
//        $order = Order::where('id', $order_id)->first();
//        dd($order);


        if (empty($request->PayerID) || empty($request->token))
        {
            \Session::put('error','PayPal payment failed (2)');
            return redirect()->route('getPayForm', ['order' => $order]);
        }
        $payment = \PayPal\Api\Payment::get($payment_id, $this->_api_context);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
//        dd($execution);
        //---Execute the payment ---//
        $result = $payment->execute($execution, $this->_api_context);
//        dd($result);
        if ($result->getState() == 'approved') {
            if($this->authenticate($order)){
                // Here Write your database logic like that insert record or value in database if you want

                $order->account()->update(
                    [
                        'name'=> \Session::get('company'),
                        'owner_id' => $order->user->id,
                        'email'=> $order->user->email,
                    ]
                );
                \Session::forget('company');

                $payMent = new Payment();
                $payMent->transaction_charge_id = $result->getId();
                $payMent->order_id = $order->id;
                $payMent->type_payment = 'payPal';
                $payMent->amount = $order->amount;
                $payMent->currency = 'usd';
                $payMent->save();
                $order->update(['approve_status'=> 'completed']);

                \Session::put('success','Payment success');
                return redirect()->route('setAccountForm');
            }
        }
        \Session::put('error','Payment failed (3)');

        return Redirect::route('getPayForm', [$order]);
    }

    public function getSubscriptionCancel(Request $request)
    {
        $order = \Session::get('order');
        \Session::flash('success', 'Subscription Error!');

        return redirect()->route('getPayForm', ['order' => $order]);
    }


    public function authenticate($order)
    {
        $random_password = str_random(10);
        $order->user()->update(['password'=> bcrypt($random_password)]);

        $credentials = array('email' => $order->user->email, 'password' => $random_password);
        if (Auth::attempt($credentials)) {
            // 'Auth was success'

            $data = array(
                'link' => URL::to('/') . '/account/setAccountForm',
                'login' => $order->user->email,
                'first_name' => $order->user->first_name,
                'random_password' => $random_password,
            );
            Mail::to($order->user->email)->send(new UserMail($data, 'mails.account_password'));

            return true;
//            return redirect()->route('setAccountForm');
        }else{
//            dd('Auth was not success');
            return false;
        }
    }

    private function getParameters($order){
        return [
            'action' => route('addPay', [$order]),
            'order' => $order,
            'projects' => $order->projects,
        ];
    }
    
}
