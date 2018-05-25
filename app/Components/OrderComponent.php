<?php

namespace App\Components;

use App\Components\InvoiceComponent;
use App\Components\EventComponent;

use App\Model\Order;
use App\Model\Product;
use App\Coupon;
use App\Model\Project;
use App\Account;
use App\User;

use DB;

use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;

class OrderComponent extends InvoiceComponent {
	
	public static function new_order(array $projects, array $products, array $quantity, $user_id, array $coupons = [], $invoice = true)
	{

		if(count($projects) != count($products) && count($projects) != count($quantity)){
			return null;
		}

		$dataset = self::set_amounts([
				'projects' => $projects,
				'products' => $products,
				'q' => $quantity
		]);

		$dataset['company_id'] = Project::find($dataset['projects'][0])->account->id;

		if(!empty($coupons)){
			$dataset = self::to_coupon($dataset, $coupons);
		}

		$order = self::create_order($dataset, $user_id);

		if($invoice){
		    parent::set($order);
        }

		return $order;

	}

	protected static function set_amounts(array $dataset)
	{
		$dataset['without_discount'] = 0;
		$dataset['total'] = 0;
		for ($i = 0; $i < count($dataset['projects']); $i++) {
			$dataset['amount'][] = Product::find($dataset['products'][$i])->price * $dataset['q'][$i];
			$dataset['without_discount'] += $dataset['amount'][$i];
			$dataset['total'] += $dataset['amount'][$i];
		}

		return $dataset;
	}

	protected static function create_order($dataset, $uid)
	{
		
		$order = new Order([
			'amount' => $dataset['total'],
			'without_discount' => $dataset['without_discount']
		]);
		$order->account()->associate(Account::find($dataset['company_id']));
		$order->user()->associate(User::find($uid));
		$order->save();
		if(!empty($dataset['coupons'])){
			$order->coupons()->attach($dataset['coupons']);
		}
		$order->projects()->attach($dataset['projects']);

		$to_email = [
			'subject' => 'New Order',
			'total' => $dataset['total'],
			'subtotal' => $dataset['without_discount'],
			'items' => array()
		];

		for ($i = 0; $i < count($dataset['products']); $i++) {
			$order->products()->attach($dataset['products'][$i], [
				'quantity' => $dataset['q'][$i],
				'price' => $dataset['amount'][$i],
				'project_id' => $dataset['projects'][$i],
			]);

			$to_email['items'][] = array('title' => Product::find($dataset['products'][$i])->title, 'q' => $dataset['q'][$i], 'total' => $dataset['amount'][$i]);
		}

		foreach (array_unique($dataset['projects']) as $p) {
			EventComponent::new_event(Project::find($p), 'order', $order->id);
		}

		foreach ($order->account->users as $user) {
            if($user->hasRole('client') && $user->pivot->enable_notifi){
                Mail::to($user)->queue(new UserMail($to_email, 'mails.new_order'));
            }
		}

		return $order;

	}

	protected static function to_coupon($dataset, $coupons)
	{

		$count_coupon = count($coupons);
		
		foreach ($coupons as $coupon) {
			$coupon = Coupon::find($coupon);
			if(!self::check_coupon($coupon, $count_coupon, $dataset)){
				continue;
			}

			if($coupon->discount->as == '%'){
				$dataset['total'] = $dataset['total'] / 100 * (100 - $coupon->amount);
			}elseif($coupon->discount->as == '$'){
				$dataset['total'] = $dataset['total'] - $coupon->amount;
			}
			$dataset['coupons'][] = $coupon->id;
		}

		return $dataset;

	}

	public static function check_coupon(Coupon $coupon, $count, $dataset)
	{
//		dd($coupon);
		if($coupon->expiry_date){
			if(strtotime($coupon->expiry_date) < strtotime('now')) return false;
		}

		if($coupon->usage_coupon > 0){
			if($coupon->orders()->count() >= $coupon->usage_coupon) return false;
		}

		if(!empty($dataset['company_id'])){
			if($coupon->usage_user > 0){
				if($coupon->orders()->where('account_id', $dataset['company_id'])->count() >= $coupon->usage_user) return false;
			}
		}

		if($coupon->max_spend > 0){
			if($dataset['without_discount'] >= $coupon->max_spend) return false;
		}

		if($coupon->min_spend > 0){
			if($dataset['without_discount'] <= $coupon->min_spend) return false;
		}

		if($coupon->use_only){
			if($count > 1) return false;
		}

		if($coupon->products->count()){
			if($coupon->products()->whereIn('id', array_unique($dataset['products']))->count() < count($dataset['products'])){
				return false;
			}
		}

		if(!$coupon->status) return false;

		return true;
	}

	public static function editOrder(
		Order $order, array $projects_id, array $projects_url, array $products_id, array $quantity)
	{
//		dd($order->coupons);
		$coupons = $order->coupons->pluck('id');
//		dd($order->coupons);
//		dd($coupons);
//		dd($order->products()->pluck('id'));
		$data = [
			'projects_id' => $projects_id,
			'projects_url'=> $projects_url,
			'products_id' => $products_id,
			'quantity' => $quantity,
			'price' => array()
		];
		
		$old_projs = [
			'pj' => $order->products()->pluck('project_id'),
			'pd' => $order->products()->pluck('id')
		];
//		dd($data);

		foreach ($old_projs['pj'] as $key => &$id){
			if(array_search($id, $data['projects_id'])){
				$id = false;
			}
		}

		$order->products()->detach();

		foreach ($data['projects_id'] as $key => $val){
			if($val != 'new') continue;

			$project = new Project();
			$project->url = $projects_url[$key];
			$project->account_id = $order->account_id;
			$project->save();

			$data['projects_id'][$key] = $project->id;

			$project->products()->attach($data['products_id'][$key], ['quantity' => $data['quantity'][$key]]);
			$project->users()->attach($order->user_id);
		}

		$order->projects()->sync($data['projects_id'], true);

		$ololo = array();

		for($i = 0; $i < count($data['quantity']); $i++){
			$data['price'][] = $data['quantity'][$i] * Product::where('id', $data['products_id'][$i])->first()->price;

			$order->products()->attach($data['products_id'][$i], [
				'quantity' => $data['quantity'][$i],
				'project_id' => $data['projects_id'][$i],
				'price' => $data['price'][$i]
			]);
		}



		for($i = 0; $i < count($data['projects_id']); $i++){
			$prod = Product::find($data['products_id'][$i]);

			if(empty($prod->projects()->find($data['projects_id'][$i]))){
				$prod->projects()->attach($data['projects_id'][$i], ['quantity' => $data['quantity'][$i]]);
			}else{
				$sum_q = 0;
				foreach ($prod->orders()->where('project_id', $data['projects_id'][$i])->get() as $proj){
					$sum_q += $proj->pivot->quantity;
				}

				$prod->projects()->find($data['projects_id'][$i])->pivot->quantity = $sum_q;
			}
		}

		foreach ($old_projs['pj'] as $key => $old_proj){
			if(!$old_proj) continue;

			if(!DB::table('order_product')->where('project_id', $old_proj)->count()){
				Project::find($old_proj)->products()->detach($old_projs['pd'][$key]);
			}else{
				$prod = Product::find($old_projs['pd'][$key]);
				$sum_q = 0;
				foreach ($prod->orders()->where('project_id', $old_proj)->get() as $proj){
					$sum_q += $proj->pivot->quantity;
				}

				$prod->projects()->find($old_proj)->pivot->quantity = $sum_q;
			}
		}
/*
//		dd($order);
//		$qs = [];
//		foreach ($quantity as $q){
//			$qs[] = ['quantity' => $q];
//		}
//		$product_data = array_combine($products_id, $qs);

//		dd($data['projects_id']);

//		$order->projects()->detach();
		foreach ($data['projects_id'] as $index => $proj_id){
//			dd($proj_id);
			if ($proj_id == 'new'){
//				//create new
//					dd('second-'.$proj_id.'<br>');
				$project = new Project();
				$project->url = $projects_url[$index];
				$project->account_id = $order->account_id;
				$project->save();

				$data['projects_id'][$index] = $project->id;

				$project->products()->attach($data['products_id'][$index], ['quantity' => $data['quantity'][$index]]);
				$project->orders()->attach($order->id);
				$project->users()->attach($order->user_id);

//				$order->products()->attach(
//					$products_id[$index],
//					[
//						'quantity' => $quantity[$index],
//						'price' => $quantity[$index] * Product::where('id', $products_id[$index])->first()->price,
//						'project_id' => $project->id
//					]);
//				var_dump($projectId.'_new<br>');
			}else{
				foreach ($order->projects as $project){
					if ($project->id == $proj_id){
//					var_dump($proj_id.'<br>');
//				//do update
//					if ($proj_id !== 'new'){
//						dd($projects_url[$index]);
						$project->url =  $data['projects_url'][$index];
						$project->save();
						$project->products()->sync( [$data['products_id'][$index] =>
							['quantity' => $data['quantity'][$index], 'project_id' => $project->id]] , false);//false = dont delete old entries

//						$order->products()->sync(
//							$products_id[$index],
//							[
//								'quantity' => $quantity[$index],
//								'price' => $quantity[$index] * Product::where('id', $products_id[$index])->first()->price,
//								'project_id' => $project->id
//							]);
						$data['projects_id'][$index] = $project->id;
					}
				}
			}
//			dd($product_data);
		}
//		dd($data);
		$order->products()->detach();
//		$qs = [];
		foreach ($data['products_id'] as $j => $prod_id){
			$order->products()->sync([$data['products_id'][$j] => [
				'quantity' => $data['quantity'][$j],
				'price' => $data['quantity'][$j] * Product::where('id', $data['products_id'][$j])->first()->price,
				'project_id' => $data['projects_id'][$j]]
			], false);

//			$order->projects()->sync();
		}*/
//		dd($qs);
//		$product_data = array_combine($data['products_id'], $qs);
//		dd($order);

//		dd($product_data);

		$dataset = self::set_amounts([
			'projects' => $data['projects_id'],
			'products' => $data['products_id'],
			'q' => $data['quantity']
		]);
//		$qs = [];
//		foreach ($quantity as $index => $q){
//			$qs[] = ['quantity' => $q, 'price' => $q * Product::where('id', $products_id[$index])->first()->price];
//		}
//		$product_data = array_combine($products_id, $qs);
////		dd($projects_id);
////		dd($product_data);
//		$order->products()->detach();
//		foreach ($products_id as $i => $id){
//			$order->products()->attach(
//				$id,
//				[
//					'quantity' => $quantity[$i],
//					'price' => $quantity[$i] * Product::where('id', $products_id[$i])->first()->price,
//					'project_id' => $project_id_with_new_saved[$i]
//				]);
//		}

		if(!empty($coupons)){
			$dataset = self::to_coupon($dataset, $coupons);
		}
		$order->update(['without_discount' => $dataset['without_discount'], 'amount' => $dataset['total']]);
//dd($order);
		return $order;
	}
}