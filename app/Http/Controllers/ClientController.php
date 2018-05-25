<?php

namespace App\Http\Controllers;

use App\Client;
use App\Model\Product;
use App\Model\Project;
use App\Partner;
use App\Production;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Model\Order;
use App\Invoice;
use App\Feed;
use Carbon\Carbon;
use App\Components\OrderComponent;
use Stripe\Stripe;
use App\Model\Payment;

use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\UpdateClient;
use App\Anchor;
use Mail;
use App\Mail\UserMail;
use App\User;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function index()
    {
        $anal = array();
        $anal['ordered'] = 0;
        $anal['live'] = 0;
        $anal['qc'] = 0;
        $anal['wc'] = 0;
        $anal['e'] = 0;
        $anal['p'] = 0;
        $anal['waiting'] = 0;
        foreach (Auth::user()->accounts as $account) {
            foreach ($account->projects as $project) {
                $anal['ordered'] += $project->products->sum('pivot.quantity');
                $anal['live'] += $project->productions()->where('live', 'Live')->count();
                $anal['qc'] += $project->productions()->whereNull('client_approved')->count();
                $anal['wc'] += $project->productions()->where('content_written', 'Finished')->count();
                $anal['e'] += $project->productions()->where('content_edited', 'Finished')->count();
                $anal['p'] += $project->productions()->where('content_personalized', 'Finished')->count();
                $anal['waiting'] += $project->productions()->where('payment', 'Paid')->count();
            }
        }

        $pid = Auth::user()->projects()->pluck('id');
        $feed = Feed::whereIn('project_id', $pid)->latest()->take(20)->get();
        $feed_count = Feed::whereIn('project_id', $pid)->count();

        $dates = [];
        $pid = 0;
        $count = 1;

        foreach ($feed as $f){
            if($pid == 0){
                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime())->format('Y-m-d'))){
                    $dates['Today'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime('yesterday'))->format('Y-m-d'))){
                    $dates['Yesterday'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if((new \DateTime($f->created_at))->format('Y') == (new \DateTime())->format('Y')){
                    $dates[(new \DateTime($f->created_at))->format('l, F j')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }else{
                    $dates[(new \DateTime($f->created_at))->format('l, F j Y')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }
            }

            if($pid != $f->project->id){
                $count += 1;
                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime())->format('Y-m-d'))){
                    $dates['Today'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime('yesterday'))->format('Y-m-d'))){
                    $dates['Yesterday'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if((new \DateTime($f->created_at))->format('Y') == (new \DateTime())->format('Y')){
                    $dates[(new \DateTime($f->created_at))->format('l, F j')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }else{
                    $dates[(new \DateTime($f->created_at))->format('l, F j Y')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }
            }else{
                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime())->format('Y-m-d'))){
                    $dates['Today'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if(strtotime((new \DateTime($f->created_at))->format('Y-m-d')) == strtotime((new \DateTime('yesterday'))->format('Y-m-d'))){
                    $dates['Yesterday'][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }

                if((new \DateTime($f->created_at))->format('Y') == (new \DateTime())->format('Y')){
                    $dates[(new \DateTime($f->created_at))->format('l, F j')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }else{
                    $dates[(new \DateTime($f->created_at))->format('l, F j Y')][$count][] = $f;
                    $pid = $f->project->id;
                    continue;
                }
            }

        }

        $orders = Order::whereIn('account_id', Auth::user()->accounts()->pluck('id'))->paginate(3);

        $tz_this = (new \DateTime('now', new \DateTimeZone((new Carbon('2018-04-20 11:00:03'))->tzName)))->format('P');
        $tz_sydnay = (new \DateTime('now', new \DateTimeZone('Australia/Sydney')))->format('P');

        return view('client.client_dashboard', [
            'anal' => $anal,
            'orders' => $orders,
            'dates' => $dates,
            'count_feed' => $feed_count,
            'tz' => (int)$tz_sydnay - (int)$tz_this
        ]);

    }

    public function look_invoice(Request $req)
    {
        if(!Invoice::find($req->id)) return redirect()->back()->with('error');
        return response()->file(Invoice::find($req->id)->path);
    }

    public function download_invoice(Request $req)
    {
        if(!Invoice::find($req->id)) return redirect()->action('ClientController@index');
        return response()->download(Invoice::find($req->id)->path);
    }

    public function web($id)
    {
        $user = Auth::user();
        $accounts = $user->accounts;
        $project = Project::find($id);
        $products = Product::all();
        $productions = Production::where('project_id',$id)
            // ->where('client_approved','!=','Approved')
            ->get();
        $placements = DB::table('product_project')->where('project_id',$id)->where('product_id', 1)->get();
        $quantity =  0;
        foreach ($placements as $placement){
            $quantity = $quantity + $placement->quantity;
        }
        // dd( $productions);
        return view('client.website_dashboard')
            ->withUser($user)
            ->withProducts($products)
            ->withProject($project)
            ->withQuantity($quantity)
            ->withProductions($productions)
            ->withAccounts($accounts);
    }

    public function load_updates (Request $request)
    {
        $production_id = $request->production_id;
        $feeds = Feed::where('table_id',$production_id)
            ->whereIn('event_id',[7,8,9,10,11])->get();
        $production = Production::find($production_id);
        $anchor = Anchor::where('project_id', $production->project_id)
            ->where('partner_id', $production->partner_id)->first();
        $users = User::whereNull('stop_sending')->get();
        return response()->view('client.update',[
            'users' => $users,
            'feeds' => $feeds,
            'anchor' => $anchor
        ]);

    }

    public function store_comment (Request $request)
    {
//        dd($request);
        $comment = new UpdateClient();
        $comment->text = $request->comment;
        $comment->user()->associate(Auth::user());
        if(count($request->recipients)){
            $comment->recipients = serialize($request->recipients);
        }
        $comment->user()->associate(Auth::user());
        $comment->feed()->associate(Feed::find($request->feed));
        $comment->save();
        return redirect()->back();
    }

    public function search(Request $request){

        $users = User::where('first_name','like','%'.$request->search_query.'%')
            ->orWhere('last_name','like','%'.$request->search_query.'%')
//            ->groupBy('id')->distinct()
            ->get();

        return $users;

    }

    public function create()
    {


    }
    private function getParameters($order){
        return [
//            'action' => route('addPay', [$order]),
            'order' => $order,
            'projects' => $order->projects,

        ];
    }

    public function  add_more(Request $request)
    {

        $project = Project::find($request->project_id);
        $prods = Product::whereIn('id', $request->product_id)->get();
        foreach ($prods as $i=>$prod) {
            $project->products()->attach($prod, ['quantity' => $request->quantity_product[$i]]);
        }
        foreach ($prods as $product){
            $products[] = $product->id;
            $projects[] = $request->project_id;
        }

        $quantity = $request->quantity_product;
        $user = Auth::user();
        $coupons = [];
        $order = OrderComponent::new_order($projects, $products, $quantity, $user->id, $coupons);
        $card['card_number'] = $request->card_number;
        $card['cvc'] = $request->cvc;
        $card['expiry_month'] = substr($request->expiry,0,-5);
        $card['expiry_year'] = substr($request->expiry,3);
        $card['currency'] = $request->currency;

        if($request->payment_method == 'payPal'){

            \Session::put('user', $user);
            \Session::put('company', $order->account->name);

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $item_1 = new Item();
            $item_1->setName('order_'.$order->id)->setCurrency('USD')->setQuantity(1)->setPrice($request->amount);

            $item_list = new ItemList();
            $item_list->setItems(array($item_1));

            $amount = new Amount();
            $amount->setCurrency('USD')->setTotal($order->amount);

            $transaction = new Transaction();
            $transaction->setAmount($amount)->setDescription('Your transaction description');

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
                return redirect()->route('client.web',$request->project_id);

                // if (\Config::get('app.debug')) {
                //     \Session::put('error','Connection timeout');
                //     return redirect()->route('getPayForm', ['order' => $order]);
                // }
                // else {
                //     \Session::put('error','Some error occur, sorry for inconvenient');
                //     return redirect()->route('getPayForm', ['order' => $order]);
                // }
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


            return $this->payPalPayment($order);
        }
        else{
            $validator = Validator::make($request->all(), [

                'card_number' => 'required|numeric',
                'cvc' => 'required|numeric',
                'expiry' => 'required',
            ]);
            if($validator->fails()){

                return redirect()->back()
                ->withErrors($validator);
            };
            Stripe::setApiKey(env('STRIPE_SECRET'));
            try{
                $token = \Stripe\Token::create(array(
                    "card" => array(
                        "number" => $card['card_number'],
                        "exp_month" => $card['expiry_month'],
                        "exp_year" => $card['expiry_year'],
                        "cvc" => $card['cvc']
                    )
                ));
            }catch (\Stripe\Error\Card $e){
                return redirect()->route('client.web',$request->project_id);
                // Since it's a decline, \Stripe\Error\Card will be caught
                // $body = $e->getJsonBody();
                // $err_stripe  = $body['error'];


                // return view('order.paymentOrderForm',
                //     $this->getParameters($order)
                // )->withErrors($err_stripe);

            }
            // catch (\Stripe\Error\RateLimit $e) {
            //     // Too many requests made to the API too quickly
            //     $body = $e->getJsonBody();
            //     $err_stripe  = $body['error'];


            //     return view('order.paymentOrderForm',
            //         $this->getParameters($order)
            //     )->withErrors($err_stripe);
            // } catch (\Stripe\Error\InvalidRequest $e) {
            //     // Invalid parameters were supplied to Stripe's API
            //     $body = $e->getJsonBody();
            //     $err_stripe  = $body['error'];


            //     return view('order.paymentOrderForm',
            //         $this->getParameters($order)
            //     )->withErrors($err_stripe);
            // } catch (\Stripe\Error\Authentication $e) {
            //     // Authentication with Stripe's API failed
            //     // (maybe you changed API keys recently)
            //     $body = $e->getJsonBody();
            //     $err_stripe  = $body['error'];


            //     return view('order.paymentOrderForm',
            //         $this->getParameters($order)
            //     )->withErrors($err_stripe);
            // } catch (\Stripe\Error\ApiConnection $e) {
            //     // Network communication with Stripe failed
            //     $body = $e->getJsonBody();
            //     $err_stripe  = $body['error'];


            //     return view('order.paymentOrderForm',
            //         $this->getParameters($order)
            //     )->withErrors($err_stripe);

            // } catch (\Stripe\Error\Base $e) {
            //     // Display a very generic error to the user, and maybe send
            //     // yourself an email
            //     $body = $e->getJsonBody();
            //     $err_stripe  = $body['error'];


            //     return view('order.paymentOrderForm',
            //         $this->getParameters($order)
            //     )->withErrors($err_stripe);

            // } catch (Exception $e) {
            //     // Something else happened, completely unrelated to Stripe
            //     $body = $e->getJsonBody();
            //     $err_stripe  = $body['error'];


            //     return view('order.paymentOrderForm',
            //         $this->getParameters($order)
            //     )->withErrors($err_stripe);
            // }



            $charge = \Stripe\Charge::create(array(
                "amount" => $order->amount*100,
                "currency" => "usd",
                "description" => "Example charge",
                "source" => $token,
            ));



            $payMent = new Payment();
            $payMent->transaction_charge_id = $charge->id;
            $payMent->order_id = $order->id;
            $payMent->type_payment = 'stripe';
            $payMent->amount = $charge->amount/100;
            $payMent->currency = $charge->currency;
            $payMent->save();
            $order->update(['approve_status'=> 'completed']);

            // if($this->authenticate($order)){
            //     // return redirect()->route('setAccountForm');
            //     return redirect()->route('client.web',$request->project_id);
                
            // }else{
            //     return redirect()->route('home');

            // }

            // return redirect()->route('addPayStripe', ['order' => $order]);
        }


        return redirect()->route('client.web',$request->project_id);
    }

    public function store(Request $request)
    {
        // dd($request);  
        $oid = 0;
        foreach(Project::find($request->project_id)->orders as $order){
            $q = $order->products()
                ->where('project_id',$request->project_id)
                ->where('product_id', 1)
                ->first();
            if(empty($q)) continue;
            $q = $q->pivot->quantity;
            $qp = Production::where('order_id',$order->id)->count();
            if($qp < $q){
                $oid = $order->id;
                break;
            }
        }
        if($request->x == 'Rejected PBN'){
            $production = Production::find($request->production_id);
            $production->client_approved = $request->x;
            $production->save(); 
        }
        else {
            if($oid){
            $production = Production::find($request->production_id);
            $production->client_approved = $request->x; 
            $production->order_id = $oid;
            $production->save();
            echo $oid;
            }
            else echo 0;       
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
//        $client = Client::find($client->id);
//
//        return view('dashboard.subscriber.contacts.edit_contact_modal')->with(['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }

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


}
