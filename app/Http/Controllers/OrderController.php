<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateOrderRequest;
use App\Model\Product;
use App\Model\Order;
use App\Model\Project;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Account;
use Illuminate\Contracts\Pagination;
use App\Coupon;
use App\Components\OrderComponent;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function addFormOrder()
    {
        $coupon = Coupon::where('id', 1)->first();
//        dd($coupon);
        $product = Product::first();
        $project_price = Config::get('project_price.project_price');

        return view('order.addOrderForm',
            [
                'action' => route('addOrder'),
                'product' => $product,
                'coupon' => $coupon,
                'project_price' => $project_price
            ]
        );
    }

    public function addOrder(CreateOrderRequest $request)
    {

        $data = $request->all();
//        dd($data);

        $account = new Account();
        $account->email = $data['email'];
        $account->save();


//        $user = User::where(['email' => $data['email']])->first();
//        if (!$user){
        $user = new User();
        $user->email = $data['email'];
//        $user->name = $data['email'];
        $user->photo = 'user_anonim.png';
        $user->bgc = serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))]);
        $user->save();
        $user->assignRole(['client']);
        $user->accounts()->save($account);
//        }

        $products = $data['product_id'];
        $quantity = $data['quantity'];
        $coupons[] = $data['coupon_id'];

        $projects = [];
        for ($i = 0; $i < count($data['url']); $i++) {
//            dump($i, count($data['url']));
            $project = new Project();
            $project->url = $data['url'][$i];
            $project->account_id = $account->id;
            $project->save();
            $projects[] = $project->id;

            $project->products()->attach($data['product_id'][$i], ['quantity' => $data['quantity'][$i]]);
            $project->users()->attach($user);

//            $order->projects()->attach($project);
        }

        $order = OrderComponent::new_order($projects, $products, $quantity, $user->id, $coupons);
//        dd($order);

        $subTotal = 0;
        foreach ($order->projects as $project){
            foreach ($project->products as $product){
                $subTotal = $subTotal + ($product->price * $product->pivot->quantity);
            }
        }

        return redirect()->route('getPayForm', ['order' => $order]);
    }

    public function overviewOrders()
    {
        return view('order.overviewOrders');
    }

    public function allOrdersClient()
    {
        $user = Auth::user();
        $products = Product::all();
//        $products = Product::where('status', 'show')->get();

        $on_holdOrdersCount = Order::where('approve_status', 'on_hold')->count();
        $completedCount = Order::where('approve_status', 'completed')->count();
        $refundedOrdersCount = Order::where('approve_status', 'refunded')->count();

        if ($user->hasRole('client')){
            $orders = Order::where('user_id', $user->id )->paginate(4);
            $allOrdersCount = $orders->total();
        }else{
            $orders = Order::paginate(4);
            $allOrdersCount = $orders->total();
        }

        return view('order.allOrdersClient',[
                'orders' => $orders,
                'products' => $products,
                'allOrdersCount' => $allOrdersCount,
                'on_holdOrdersCount' => $on_holdOrdersCount,
                'completedCount' => $completedCount,
                'refundedOrdersCount' => $refundedOrdersCount,
//                'all' => $all,
            ]
        );
    }

    public function getOrderAjax(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
//        dd($order);
        $data = [];
        $data['order_id'] = $order->id;
        $coupons = $order->coupons;
//        dd($coupons);

        $projectsArr = [];
        foreach ($order->products as $product){
            $projectsArr[] = [
                'project_id'=>$product->pivot->project_id,
                'project_url'=>Project::where('id', $product->pivot->project_id)->first()->url,
                'product_id'=>$product->id,
                'product_title'=>$product->title,
                'product_price'=>$product->price,
                'product_quantity'=>$product->pivot->quantity,
            ];
        }


        $data['projects'] = $projectsArr;
        $data['coupons'] = $coupons;
        $data['email'] = $order->user->email;
//        $data['products'] = $productsArr;
//        dd($data);
//        $project =
        return response()->json($data);
    }

    public function ordersDateFilter(Request $request)
    {
        $data = $request->all();
        $products = Product::all();

//        dd($data);

        if (!isset($data['page'])) {
            \Session::put('start_date', new \DateTime($data['start_date']));
            \Session::put('end_date', new \DateTime($data['end_date']));


            $orders = Order::whereDate('created_at', '>=', (new \DateTime($data['start_date']))->format('Y-m-d'))
                ->whereDate('created_at', '<=', (new \DateTime($data['end_date']))->format('Y-m-d'))->paginate(4);

            $allOrdersCount = $orders->total();
            $on_holdOrdersCount = $orders->total();
            $completedCount = Order::where('approve_status', 'completed')->count();
            $refundedOrdersCount = Order::where('approve_status', 'refunded')->count();
            return view('order.ordersTable', [
                'orders' => $orders,
                'products' => $products,
                'allOrdersCount' => $allOrdersCount,
                'on_holdOrdersCount' => $on_holdOrdersCount,
                'completedCount' => $completedCount,
                'refundedOrdersCount' => $refundedOrdersCount,
            ]);

        } elseif (isset($data['page'])) {
            $start_date = \Session::get('start_date');
            $end_date = \Session::get('end_date');
            $orders = Order::whereDate('created_at', '>=', $start_date->format('Y-m-d'))
                ->whereDate('created_at', '<=', $end_date->format('Y-m-d'))->paginate(4);

            $allOrdersCount = $orders->total();
            $on_holdOrdersCount = Order::where('approve_status', 'on_hold')->count();
            $completedCount = Order::where('approve_status', 'completed')->count();
            $refundedOrdersCount = Order::where('approve_status', 'refunded')->count();
            return view('order.allOrdersClient', [
                'orders' => $orders,
                'products' => $products,
                'allOrdersCount' => $allOrdersCount,
                'on_holdOrdersCount' => $on_holdOrdersCount,
                'completedCount' => $completedCount,
                'refundedOrdersCount' => $refundedOrdersCount,

            ]);
//            dd($end_date->format('Y-m-d'));
        }
    }

    public function ordersNameFilter(Request $request)
    {
        $data = $request->all();
        $products = Product::all();

        $allOrdersCount = Order::all()->count();
        $on_holdOrdersCount = Order::where('approve_status', 'on_hold')->count();
        $completedCount = Order::where('approve_status', 'completed')->count();
        $refundedOrdersCount = Order::where('approve_status', 'refunded')->count();
//        dd($data);
        if (!isset($data['page'])) {
            \Session::put('path_name', $data['path_name']);

            $db_req = '%'.$data['path_name'].'%';
            $orders = Order::whereIn('user_id', User::where('first_name', 'like', $db_req)
                ->orWhere('last_name', 'like', $db_req)
                ->pluck('id'))->paginate(3);
//        dd($orders);
            return view('order.ordersTable', [
                'orders' => $orders,
                'products' => $products,
                'allOrdersCount' => $allOrdersCount,
                'on_holdOrdersCount' => $on_holdOrdersCount,
                'completedCount' => $completedCount,
                'refundedOrdersCount' => $refundedOrdersCount,
            ]);
        } elseif (isset($data['page'])) {
            $path_name = \Session::get('path_name');

            $db_req = '%'.$path_name.'%';
            $orders = Order::whereIn('user_id', User::where('first_name', 'like', $db_req)
                ->orWhere('last_name', 'like', $db_req)
                ->pluck('id'))->paginate(3);
//        dd($orders);
            return view('order.allOrdersClient', [
                'orders' => $orders,
                'products' => $products,
                'allOrdersCount' => $allOrdersCount,
                'on_holdOrdersCount' => $on_holdOrdersCount,
                'completedCount' => $completedCount,
                'refundedOrdersCount' => $refundedOrdersCount,
            ]);
        }
    }

    public function ordersOnHoldFilter(Request $request){

        $products = Product::all();
        $orders = Order::where('approve_status', 'on_hold' )->paginate(4);

        $allOrdersCount = Order::all()->count();
        $on_holdOrdersCount = $orders->total();
        $completedCount = Order::where('approve_status', 'completed')->count();
        $refundedOrdersCount = Order::where('approve_status', 'refunded')->count();
//        dd($onHoldCount);
        return view('order.allOrdersClient',[
                'orders' => $orders,
                'products' => $products,
                'allOrdersCount' => $allOrdersCount,
                'on_holdOrdersCount' => $on_holdOrdersCount,
                'completedCount' => $completedCount,
                'refundedOrdersCount' => $refundedOrdersCount,
            ]
        );
    }
    public function ordersCompletedFilter(Request $request){
        $products = Product::all();
        $orders = Order::where('approve_status', 'completed' )->paginate(4);
        $allOrdersCount = Order::all()->count();
        $on_holdOrdersCount = Order::where('approve_status', 'on_hold')->count();
        $completedCount = $orders->total();
        $refundedOrdersCount = Order::where('approve_status', 'refunded')->count();
//        dd($CompletedCount);
        return view('order.allOrdersClient',[
                'orders' => $orders,
                'products' => $products,
                'allOrdersCount' => $allOrdersCount,
                'on_holdOrdersCount' => $on_holdOrdersCount,
                'completedCount' => $completedCount,
                'refundedOrdersCount' => $refundedOrdersCount,
            ]
        );
    }
    public function ordersRefundedFilter(Request $request){
        $orders = Order::where('approve_status', 'refunded' )->paginate(4);
        $products = Product::all();

        $allOrdersCount = Order::all()->count();
        $on_holdOrdersCount = Order::where('approve_status', 'on_hold')->count();
        $completedCount = Order::where('approve_status', 'completed')->count();
        $refundedOrdersCount = $orders->total();
        return view('order.allOrdersClient',[
                'products' => $products,
                'orders' => $orders,
                'allOrdersCount' => $allOrdersCount,
                'on_holdOrdersCount' => $on_holdOrdersCount,
                'completedCount' => $completedCount,
                'refundedOrdersCount' => $refundedOrdersCount,
            ]
        );
    }

    public function onHoldOrder(Request $request)
    {
        foreach ($request->orders_id as $orderId){
            Order::where('id', $orderId)->update(['approve_status' => 'on_hold']);
//            dd($orderId);
        }
        return 'success';
    }

    public function approveOrder(Request $request)
    {
        foreach ($request->orders_id as $orderId){
            Order::where('id', $orderId)->update(['approve_status' => 'completed']);
//            dd($orderId);
        }
        return 'success';
    }

    public function refundedOrder(Request $request)
    {
        foreach ($request->orders_id as $orderId){
            Order::where('id', $orderId)->update(['approve_status' => 'refunded']);
//            dd($orderId);
        }
        return 'success';
    }

    public function deleteOrder(Request $request)
    {
        foreach ($request->orders_id as $orderId){
            Order::where('id', $orderId)->delete();
        }
        return 'success';
    }

    public function getCoupon(Request $request)
    {

        $coupon = Coupon::where('name', ltrim($request->coupon_name))->first();
//        dd($coupon);
        if ($coupon){
            return $coupon;
        }else{
            return 'coupon_not_found';
        }
    }

    public function applyCoupon($total_order, $coupon)
    {
        if ($coupon->discount_id == 1){
//            discount_id 1->%
            $with_discount = $total_order * (100 - $coupon->amount)/100;
            return $with_discount;
        }elseif ($coupon->discount_id == 2){
//            discount_id 2->$
            $with_discount = $total_order - $coupon->amount;
            return $with_discount;
        }
    }

    public function showOrder(Order $id)
    {
        $order = $id;
        dd($order);
    }

    public function editOrder(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $data = $request->all();

        $order = OrderComponent::editOrder(
            $order, 
            $data['projects_id'], 
            $data['url'],
            $data['products_id'],
            $data['quantity']
        );
//        dd($order);
        return redirect()->route('allOrdersClient');
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
            $data['subject'] = 'Welcome to NO-BS Platform!';
            Mail::to($order->user->email)->send(new UserMail($data, 'mails.account_password'));

            return true;
//            return redirect()->route('setAccountForm');
        }else{
//            dd('Auth was not success');
            return false;
        }
    }
}