<?php

namespace App\Http\Controllers;

use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function testChecout()
    {
        $order = Order::first();
        $user = Auth::user();
        dd($order);
        return view('order.paymentOrderForm',[
//                'action' => route('addPay'),
                'action' => route('addPay', [$order]),
                'order' => $order,
                'user' => $user,
            ]
        );
    }
}
