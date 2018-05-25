<?php

use Illuminate\Database\Seeder;
use App\Coupon;
use App\Discount;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
	 * @property string name
	 * @property string description
	 * @property integer discount_id //1->%, 2->$
	 * @property integer amount
	 *  expiry_date
	 * @property boolean free_shipping // ?
	 * @property integer usage_coupon // if '0' can use many times, else count for usage
	 * @property integer usage_user //  if '0' can use many times, else count usage for one user
	 * @property integer max_spend // max amount for apply discount
	 * @property integer min_spend // min amount for apply discount
	 * @property boolean use_only // can apply with other coupon
	 * @property string email_restrict //
	 * @property boolean status // true->switch on/false->switch off
	 *
     * @return void
     */
    public function run()
    {

    	$discount1 = new Discount([

    		'name' => 'Product % Discount',
    		'as' => '%'

    	]);
    	$discount1->save();

    	$discount2 = new Discount([

    		'name' => 'Product Discount',
    		'as' => '$'

    	]);
        $discount2->save();

    	$coupon1 = new Coupon();
    	$coupon1->name = 'nobs25%';
    	$coupon1->description = '-25%';
    	$coupon1->amount = 25;
    	$coupon1->usage_user = 1;//-25%
    	$coupon1->discount()->associate($discount1);
    	$coupon1->save();

		$coupon2 = new Coupon();
		$coupon2->name = 'nobs5$';
		$coupon2->description = '-5$';
		$coupon2->amount = 5;
		$coupon2->usage_user = 2;//-5$
		$coupon2->discount()->associate($discount2);
		$coupon2->save();

		$coupon3 = new Coupon();
		$coupon3->name = 'nobs10$';
		$coupon3->description = '-10$, expiry_date=now, usage_user=2, use_only=false';
		$coupon3->amount = 10;
		$coupon3->expiry_date = date('Y-m-d H:i:s');
		$coupon3->usage_user = 2;//-5$
		$coupon3->use_only = false;
		$coupon3->discount()->associate($discount2);
		$coupon3->save();

		$coupon4 = new Coupon();
		$coupon4->name = '10$date.max.min';
		$coupon4->description = '-10$, usage_user=2, max_spend=1000, min_spend=500, use_only=true';
		$coupon4->amount = 10;
//		$coupon4->usage_coupon = 2;
		$coupon4->usage_user = 2;
		$coupon4->max_spend = 1000;//-10$
		$coupon4->min_spend = 500;//-10$
		$coupon4->use_only = true;
		$coupon4->discount()->associate($discount2);
		$coupon4->save();
    }
}
