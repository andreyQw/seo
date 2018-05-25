<?php

namespace App\Http\Controllers;

use App\Model\Order;
use Illuminate\Http\Request;

class SalesController extends Controller
{

    public function index(Request $req)
    {
        $top_order_all = Order::orderBy('amount', 'desc')->limit(5)->get();

        $date = (new \DateTime())->format('Y-m-01');
        $top_order_month = Order::whereDate('created_at', '>=', $date)->orderBy('amount', 'desc')->limit(5)->get();

        $last_order = Order::orderBy('created_at')->limit(5)->get();

        $date_last_mo = (new \DateTime('last month'))->format('Y-m-01');
        $sales_last_mo = Order::whereDate('created_at', '<', $date)->whereDate('created_at', '>=', $date_last_mo)->sum('amount');
        $sales_this_mo = Order::whereDate('created_at', '>=', $date)->sum('amount');
        if($sales_last_mo <= 0){
            $analyts['sale']['proc'] = '100%';
            $analyts['sale']['trend'] = '+';
        }elseif($sales_this_mo <= 0){
            $analyts['sale']['proc'] = '0%';
            $analyts['sale']['trend'] = '-';
        }else{
            $proc = $sales_this_mo / $sales_last_mo * 100;
            if($proc > 100){
                $analyts['sale']['proc'] = number_format($proc - 100, 1) . '%';
                $analyts['sale']['trend'] = '+';
            }elseif($proc < 100){
                $analyts['sale']['proc'] = number_format(100 - $proc, 1) . '%';
                $analyts['sale']['trend'] = '-';
            }
        }

        $analyts['amount'] = $sales_this_mo;

        $orders_last_mo = Order::whereDate('created_at', '<', $date)->whereDate('created_at', '>=', $date_last_mo)->count('amount');
        $orders_this_mo = Order::whereDate('created_at', '>=', $date)->count('amount');
        if(($orders_last_mo - $orders_this_mo) < 0){
            $analyts['orders']['trend'] = '+';
        }elseif (($orders_last_mo - $orders_this_mo) > 0){
            $analyts['orders']['trend'] = '-';
        }
        $analyts['orders']['count'] = $orders_this_mo;

        $chart = $this->getPoints([
            'start' => (new \DateTime('now - 6 days'))->format('Y-m-d'),
            'end' => (new \DateTime())->format('Y-m-d')
            ]);

        return view('admin.sales_reporting', [
            'top_all' => $top_order_all,
            'top_month' => $top_order_month,
            'last_order' => $last_order,
            'anal' => $analyts,
            'data_chart' =>  $chart
        ]);
    }

    public function get_chart_data(Request $req)
    {

        $data = $this->getPoints($req->date);

        if(!$data){
            return response()->json(['error' => 'Not Found Date']);
        }

        return response()->json($data);

    }

    protected function getPoints($date)
    {
        
        $date = $this->initDate($date);

        if(!$date){
            return false;
        }

        $bool = true;
        $next = $date['start'];
        $chart_data = array('labels' => [], 'data' => []);
        do{

            if(strtotime($date['finish']) < strtotime($next)){
                $bool = false;
            }else{
                $now = $next;
                $next = (new \DateTime($next))->modify('+ 1 ' . $date['period'])->format('Y-m-d H:i:s');
                if($date['period'] == 'hour'){
                    $chart_data['data'][] = Order::whereRaw('TIMESTAMP(created_at) BETWEEN TIMESTAMP(?) AND TIMESTAMP(?)', [$now, $next])->
                                                    count();
                }else{
                    $chart_data['data'][] = Order::whereDate('created_at', '<', $next)->
                                                    whereDate('created_at', '>=', $now)->
                                                    count();
                }

                $chart_data['labels'][] = (new \DateTime($now))->format($date['format']);
            }

        }while($bool);

        return $chart_data;

    }

    protected function initDate($date)
    {
        if($date['start'] == $date['end']){
            $data_arr = [
                'period' => 'hour',
                'start' => (new \DateTime($date['start']))->format('Y-m-d 00:00:00'),
                'format' => 'H:i'
            ];
            if((new \DateTime())->format('Y-m-d') == $date['end']){
                $data_arr['finish'] = (new \DateTime())->format('Y-m-d H:00:00');
            }else{
                $data_arr['finish'] = (new \DateTime($date['end']))->format('Y-m-d 23:00:00');
            }
            return $data_arr;
        }else{
            return [
                'period' => 'day',
                'start' => (new \DateTime($date['start']))->format('Y-m-d 00:00:00'),
                'finish' => (new \DateTime($date['end']))->format('Y-m-d 00:00:00'),
                'format' => 'd.m.Y'
            ];
        };

        /*$dates = [

            't' => [
                'period' => 'hour', 
                'start' => (new \DateTime())->format('Y-m-d 00:00:00'),
                'finish' => (new \DateTime())->format('Y-m-d H:00:00'),
                'format' => 'H:i'
            ],
            'y' => [
                'period' => 'hour', 
                'start' => (new \DateTime('yesterday'))->format('Y-m-d 00:00:00'),
                'finish' => (new \DateTime('yesterday'))->format('Y-m-d 23:00:00'),
                'format' => 'H:i'
            ],
            '7' => [
                'period' => 'day', 
                'start' => (new \DateTime('now - 6 days'))->format('Y-m-d 00:00:00'), 
                'finish' => (new \DateTime())->format('Y-m-d 00:00:00'),
                'format' => 'd.m.Y'
            ],
            'tm' => [
                'period' => 'day', 
                'start' => (new \DateTime())->format('Y-m-01 00:00:00'),
                'finish' => (new \DateTime())->format('Y-m-d 00:00:00'),
                'format' => 'd.m.Y'
            ],
            'lm' => [
                'period' => 'day', 
                'start' => (new \DateTime('last month'))->format('Y-m-01 00:00:00'),
                'finish' => (new \DateTime('first day of this month'))->modify('- 1 day')->format('Y-m-d 00:00:00'),
                'format' => 'd.m.Y'
            ],
            '30' => [
                'period' => 'day', 
                'start' => (new \DateTime('now - 29 days'))->format('Y-m-d 00:00:00'),
                'finish' => (new \DateTime())->format('Y-m-d 00:00:00'),
                'format' => 'd.m.Y'
            ],

        ];

        if(!array_key_exists($date, $dates)){
            return false;
        }else{
            return $dates[$date];
        }*/
    }
}
