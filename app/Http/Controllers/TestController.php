<?php

namespace App\Http\Controllers;

use App\Model\Order;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testChecout()
    {
        $order = Order::first();
        dd($order);
        return view('order.paymentOrderForm',[
//                'action' => route('addPay'),
                'action' => route('addPay', [$order]),
                'order' => $order,
                'user' => $user,
                'subTotal' => $subTotal,
                'total_order' => $total_order,
            ]
        );
    }
}
