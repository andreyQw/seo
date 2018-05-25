<?php

namespace App\Http\Controllers;

use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

//use PayPal\Api\Amount;
//use PayPal\Api\Item;
//use PayPal\Api\ItemList;
//use PayPal\Api\Payer;
//use PayPal\Api\RedirectUrls;
//use PayPal\Api\Transaction;
//use PayPal\Auth\OAuthTokenCredential;
//use PayPal\Rest\ApiContext;
//use PayPal\Api\PaymentExecution;

use PHPUnit\Runner\Exception;
use Stripe\Stripe;
use App\User;
use App\Model\Payment;
use Validator;
use Illuminate\Support\Facades\Config;
use Mail;
use App\Mail\UserMail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

//-------------------------
//All Paypal Details class
//-------------------------
//use PayPal;

//pay Stripe
class PayController extends Controller
{
    public function getPayForm(Request $request)
    {
        $order = Order::where('id', $request->order)->first();
//        dd($order);
        return view('order.paymentOrderForm',[
//                'action' => route('addPay', [$order]),
                'order' => $order,
            ]
        );
    }
    

    public function addPayStripe(Request $request, Order $order)
    {
        $data = $request->all();
//        dd($request);


//        $this->validate($request, [
//            'first_name' => 'required',
//        ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|regex:/[a-zа-яё]/iu',
            'last_name' => 'required|string|regex:/[a-zа-яё]/iu',
            'company' => 'required|string',
            'phone' => 'required|string|regex:/\d{6,18}/',
            'email' => 'required|string|email',
            'card_number' => 'required|numeric',
            'cvc' => 'required|numeric',
            'expiry_month' => 'required|numeric',
            'expiry_year' => 'required|numeric',
        ]);

        if($validator->fails()){

//            dd($this->getParameters($order));
            return view('order.paymentOrderForm',
                $this->getParameters($order)
            )->withErrors($validator);
        };

//        dd($order->id);
//        if ($data['payment_method'] == 'payPal'){
////            dd('payPal');
//            return $this->payPalPayment($order);
//        }
//        else{
//            dd('stripe');
//        }

//        dd($data);
        $user = User::where('email', $data['email'])->first();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->phone = $data['phone'];
        $user->country = $data['country'];
        $user->save();
//        dd($user);


        //getParameters return arr with parameters

        Stripe::setApiKey(env('STRIPE_SECRET'));
        try{
            $token = \Stripe\Token::create(array(
                "card" => array(
                    "number" => $data['card_number'],
                    "exp_month" => $data['expiry_month'],
                    "exp_year" => $data['expiry_year'],
                    "cvc" => $data['cvc']
                )
            ));
//            dd($token);
        }catch (\Stripe\Error\Card $e){
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err_stripe  = $body['error'];
//            dd('Since it\'s a decline, \Stripe\Error\Card will be caught');
//            dd($body);

            return view('order.paymentOrderForm',
                $this->getParameters($order)
            )->withErrors($err_stripe);

        }catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $body = $e->getJsonBody();
            $err_stripe  = $body['error'];

//            dd('Too many requests made to the API too quickly');
//            dd($body);
            return view('order.paymentOrderForm',
                $this->getParameters($order)
            )->withErrors($err_stripe);
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $body = $e->getJsonBody();
            $err_stripe  = $body['error'];
//            dd('Invalid parameters were supplied to Stripe\'s API');
//            dd($body);

            return view('order.paymentOrderForm',
                $this->getParameters($order)
            )->withErrors($err_stripe);
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $body = $e->getJsonBody();
            $err_stripe  = $body['error'];
//            dd(' Authentication with Stripe\'s API failed (maybe you changed API keys recently)');
//            dd($body);

            return view('order.paymentOrderForm',
                $this->getParameters($order)
            )->withErrors($err_stripe);
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $body = $e->getJsonBody();
            $err_stripe  = $body['error'];
//            $err_stripe  = 'Network communication with Stripe failed'; happened
//            dd('Network communication with Stripe failed');
//            dd($err_stripe);

            return view('order.paymentOrderForm',
                $this->getParameters($order)
            )->withErrors($err_stripe);

        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $body = $e->getJsonBody();
            $err_stripe  = $body['error'];
//            dd('Display a very generic error to the user, and maybe send yourself an email');
//            dd($body);

            return view('order.paymentOrderForm',
                $this->getParameters($order)
            )->withErrors($err_stripe);

        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $body = $e->getJsonBody();
            $err_stripe  = $body['error'];
//            dd('Something else happened, completely unrelated to Stripe');
//            dd($body);

            return view('order.paymentOrderForm',
                $this->getParameters($order)
            )->withErrors($err_stripe);
        }


//        dd($token);

        $charge = \Stripe\Charge::create(array(
            "amount" => $data['amount']*100,
            "currency" => "usd",
            "description" => "Example charge",
            "source" => $token,
        ));


//        $charge = stripePayment($data, $order);

        $payMent = new Payment();
        $payMent->transaction_charge_id = $charge->id;
        $payMent->order_id = $order->id;
        $payMent->type_payment = 'stripe';
        $payMent->amount = $charge->amount/100;
//        $payMent->balance_transaction = $charge->balance_transaction;
//        $payMent->created = $charge->created;
        $payMent->currency = $charge->currency;
        $payMent->save();


//        $order->account()->where('id',$order->account_id)->update(['name'=> $data['company']]);
//        dd($order->user->id);
        $order->account()->update(
            [
                'name'=> $data['company'],
                'owner_id' => $order->user->id,
                'email'=> $data['email'],
            ]
        );
        $order->update(['approve_status'=> 'completed']);
//        dd($order->account);

        if($this->authenticate($order)){
            return redirect()->route('setAccountForm');
        }else{
            return redirect()->route('home');
        }
//        return redirect(route('registration_success'));
//        return redirect(route('registration_success', ['email' => $user->email]));

//        return view('account.accountSetup',[
//            'action' => route('addNewProduct'),
//            'order' => $order,
//        ]);
    }

    private function getParameters($order){
//        $project_price = Config::get('project_price.project_price');
//        $subTotal = 0;
//        $projects_cost = count($order->projects) * $project_price;
//        foreach ($order->projects as $project){
//            foreach ($project->products as $product){
//                $subTotal = $subTotal + ($product->price * $product->pivot->quantity);
//            }
//        }
//        $total_order = $subTotal + $projects_cost;

        return [
//            'action' => route('addPay', [$order]),
            'order' => $order,
            'projects' => $order->projects,
//            'subTotal' => $subTotal,
//            'total_order' => $total_order,
//            'project_price' => $project_price,
        ];
    }


    private function registration_mails ($order) {
        /*Mail::to('m@m.com')->send(new UserMail(array(), 'mails.new_websites'));*/

        $random_password = str_random(10);
        $order->user()->update(['password'=> bcrypt($random_password)]);
        $login = $order->user->email;
        $first_name = $order->user->first_name;
        $link = URL::to('/') . '/account/setAccountForm';
//        dd($order->user);

        $data = array(
            'link' => $link,
            'login' => $login,
            'first_name' => $first_name,
            'random_password' => $random_password,
        );

        Mail::to($order->user->email)->send(new UserMail(
            $data,
            'mails.account_password'
        ));
    }

    /**
     * Обработка попытки аутентификации
     *
     * @return Response
     */
    public function authenticate($order)
    {
        $random_password = str_random(10);
        $order->user()->update(['password'=> bcrypt($random_password)]);

        $credentials = array('email' => $order->user->email, 'password' => $random_password);
        if (Auth::attempt($credentials)) {
            // 'Auth was success'
            /*dd(Auth::user());*/
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



    public function payPalPayment($order)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
//            dd($payer);

        $item_order = new Item();
//            $item_1->setName($order->id)->setCurrency('USD')->setQuantity(1)->setPrice($order->amount);
        $item_order->setName($order->id)->setCurrency('USD')->setPrice($order->amount);
//
//            $item_list = new ItemList();
//            $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')->setTotal($order->amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('paypal_status')) //Specify return URL
        ->setCancelUrl(URL::route('paypal_status'));

        $paymentPayPal = new \PayPal\Api\Payment();
        $paymentPayPal->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try
        {
            $paymentPayPal->create($this->_api_context);
        }
        catch (\PayPal\Exception\PPConnectionException $ex)
        {
            if (\Config::get('app.debug'))
            {
                \Session::put('order_id', $order->id);
                \Session::put('error','Connection timeout');
                return Redirect::route('paypal_status');
            }
            else
            {
                \Session::put('order_id', $order->id);
                \Session::put('error','Some error occur, sorry for inconvenient');
                return Redirect::route('paypal_status');
            }
        }

        foreach($paymentPayPal->getLinks() as $link)
        {
            if($link->getRel() == 'approval_url')
            {
                $redirect_url = $link->getHref();
                break;
            }
        }

        //--------------------------
        // add payment ID to session

        \Session::put('paypal_payment_id', $paymentPayPal->getId());
        \Session::put('order_id', $order->id);

        if(isset($redirect_url))
        {
            //-------------------
            // redirect to paypal

            return Redirect::away($redirect_url);
        }

        \Session::put('error','Unknown error occurred');
        return Redirect::route('getPayForm');
//            return 'paywithpaypal';
//            dd($item_1);
    }

    public function stripePayment($data)
    {

    }
}
