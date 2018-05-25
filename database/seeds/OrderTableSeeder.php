<?php

use Illuminate\Database\Seeder;
use App\Model\Order;
use App\Model\Product;
use App\Model\Project;
use App\User;
use App\Model\Payment;
use App\Coupon;
use App\Components\OrderComponent;


class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$order = new Order();
        $order->user_id = 4;
        $order->without_discount = 470;
        $order->amount = 470 / 100 * (100 - Coupon::find(1)->amount);
        $order->save();
        $order->coupons()->save(Coupon::find(1));*/

        /*$order2 = new Order();
        $order2->user_id = 5;
        $order2->without_discount = 470;
        $order2->amount = 470 / 100 * (100 - Coupon::find(1)->amount);
        $order2->save();
        $order2->coupons()->save(Coupon::find(1));*/

        /*\App\Account::find(1)->orders()->save($order);

        \App\Account::find(2)->orders()->save($order2);

        $order->projects()->save(Project::find(3));
        $order->projects()->save(Project::find(4));
        $order->projects()->save(Project::find(5));

        $order2->projects()->save(Project::find(1));
        $order2->projects()->save(Project::find(2));*/

        User::find(5)->projects()->save(Project::find(1));
        User::find(5)->projects()->save(Project::find(2));
        User::find(4)->projects()->save(Project::find(3));
        User::find(4)->projects()->save(Project::find(4));
        User::find(4)->projects()->save(Project::find(5));


        Project::find(1)->products()->attach(1, ['quantity' => 1]);
        Project::find(2)->products()->attach(1, ['quantity' => 2]);
        Project::find(3)->products()->attach(1, ['quantity' => 3]);
        Project::find(4)->products()->attach(1, ['quantity' => 4]);
        Project::find(5)->products()->attach(1, ['quantity' => 4]);

//        new_order(array $projects, array $products, array $quantity, $user_id, array $coupons = [], $invoice = true)

        $order1 = OrderComponent::new_order([1, 2, 3], [1, 1, 1], [2, 3, 4], 4, [1]);
        $order1->update(['approve_status'=> 'completed']);

        $order2 = OrderComponent::new_order([1, 2], [1, 1], [2, 1], 5, [1]);
        $order2->update(['approve_status'=> 'completed']);

        $order3 = OrderComponent::new_order([1, 2], [1, 1], [2, 1], 5, [1]);
        $order3->update(['approve_status'=> 'refunded']);

        $order4 = OrderComponent::new_order([3, 4], [1, 1], [3, 5], 4, [1]);
        $order4->update(['approve_status'=> 'on_hold']);

        $order5 = OrderComponent::new_order([3, 4], [1, 1], [3, 5], 4, [1]);
        $order5->update(['approve_status'=> 'refunded']);

        $order6 = OrderComponent::new_order([3, 4, 5], [1, 1, 1], [3, 5, 4], 4, [1]);
        $order6->update(['approve_status'=> 'on_hold']);



        $pay1 = new Payment([
            'transaction_charge_id'=>'p12xw12sa1aaWQ',
            'order_id' => $order1->id,
            'type_payment' => 'payPal',
            'amount' => $order1->amount,
            'currency' => 'usd',
//            'balance_transaction' => 'xssaxasx',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        $pay1->order()->associate($order1);
        $pay1->save();

        $pay2 = new Payment([
            'transaction_charge_id'=>'p12xw12sa1aaWQ',
            'order_id' => $order2->id,
            'type_payment' => 'stripe',
            'amount' => $order2->amount,

            'currency' => 'usd',
//            'balance_transaction' => 'xssaxasx',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        $pay2->order()->associate($order2);
        $pay2->save();

        Project::find(3)->anchors()->create(['text'=>'hello world!', 'url'=>'www.milk.com/']);
        Project::find(3)->anchors()->create(['text'=>'hello world!', 'url'=>'www.milk.com/hello']);
        Project::find(3)->anchors()->create(['text'=>'hello world!', 'url'=>'www.milk.com/world']);

        Project::find(4)->anchors()->create(['text'=>'hello world!', 'url'=>'www.hot.dog/']);
        Project::find(4)->anchors()->create(['text'=>'hello world!', 'url'=>'www.hot.dog/hello']);
        Project::find(4)->anchors()->create(['text'=>'hello world!', 'url'=>'www.hot.dog/world']);
        Project::find(4)->anchors()->create(['text'=>'hello world!', 'url'=>'www.hot.dog/why']);
        Project::find(4)->anchors()->create(['text'=>'hello world!', 'url'=>'www.hot.dog/position']);

        Project::find(5)->anchors()->create(['text'=>'hello world!', 'url'=>'www.why.but/worry']);
        Project::find(5)->anchors()->create(['text'=>'hello world!', 'url'=>'www.why.but/']);
        Project::find(5)->anchors()->create(['text'=>'hello world!', 'url'=>'www.why.but/hello']);
        Project::find(5)->anchors()->create(['text'=>'hello world!', 'url'=>'www.why.but/world']);

        foreach (User::find(4)->projects as $project){

            foreach ($project->anchors as $anchor){

                $id = ($anchor->id % 2) ? 2 : 1;
                \App\Partner::find($id)->anchors()->save($anchor);

            }

        }

        Project::find(1)->niches()->attach(1);
        Project::find(2)->niches()->attach(2);

        Project::find(3)->niches()->attach(3);
        Project::find(3)->niches()->attach(4);

        Project::find(4)->niches()->attach(4);
        Project::find(4)->niches()->attach(5);

        Project::find(5)->niches()->attach(5);
    }
}
