<?php

namespace App\Http\Controllers;

use App\Categorie;
use App\Coupon;
use App\Discount;
use App\Model\Order;
use App\Model\Product;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders_coupon = Order::where('amount', '<>', 'without_discount')->get();
        $data['revenue'] = 0;
        $data['discount'] = 0;
        $data['placements'] = 0;
        $data['coupon'] = 0;
        foreach ($orders_coupon as $order){

            if(empty($order->payment)){
                continue;
            }

            $data['coupon'] += $order->coupons()->count();
            $data['revenue'] += $order->amount;
            $data['discount'] += $order->without_discount - $order->amount;

            foreach ($order->projects as $project){
                foreach ($project->products as $product){
                    $data['placements'] += $product->pivot->quantity;
                }
            }

        }

        return view('admin.coupon_manager', [
            'data' => $data,
            'coupons' => Coupon::all(),
            'discount' => Discount::all(),
            'cats' => Categorie::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /*$this->validate();*/

        $coupon = new Coupon();

        $coupon->name = $request->name;
        $coupon->description = $request->description;
        $coupon->discount()->associate(Discount::find($request->discount_id));
        $coupon->amount = $request->amount;
        $coupon->expiry_date = $request->expiry_date;

        if($request->free_shipping) $coupon->free_shipping = true;
        if($request->usage_coupon) $coupon->usage_coupon = $request->usage_coupon;
        if($request->usage_user) $coupon->usage_user = $request->usage_user;
        if($request->max_spend) $coupon->max_spend = $request->max_spend;
        if($request->min_spend) $coupon->min_spend = $request->min_spend;
        if($request->use_only) $coupon->use_only = true;
        if($request->sale_items) $coupon->sale_items = false;

        $coupon->email_restrict = $request->email_restrict;

        $coupon->save();

        /*dd($request);*/

        if($request->categories){
            foreach (Categorie::whereIn('id', $request->categories)->get() as $cat) {
                $coupon->products()->saveMany($cat->products->whereNotIn('id', $coupon->products()->pluck('product_id')));
            }
            if($request->product){
                $coupon->products()->attach(Product::whereIn('id', $request->product)->whereNotIn('id', $coupon->products()->pluck('product_id'))->pluck('id'));
            }
            if($request->exclude_products){
                $coupon->products()->detach($request->exclude_products);
            }
        }elseif($request->exclude_categories){
            foreach (Categorie::whereNotIn('id', $request->exclude_categories)->get() as $cat) {
                $coupon->products()->saveMany($cat->products->whereNotIn('id', $coupon->products()->pluck('product_id')));
            }
            if($request->product){
                $coupon->products()->attach(Product::whereIn('id', $request->product)->whereNotIn('id', $coupon->products()->pluck('product_id'))->pluck('id'));
            }
            if($request->exclude_products){
                $coupon->products()->detach($request->exclude_products);
            }
        }elseif($request->product){
            $coupon->products()->attach(Product::whereIn('id', $request->product)->whereNotIn('id', $coupon->products()->pluck('product_id'))->pluck('id'));
        }elseif($request->exclude_products){
            $coupon->products()->detach($request->exclude_products);
        }

        return redirect()->route('coupon.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {

        $coupon->name = $request->name;
        $coupon->description = $request->description;
        $coupon->discount()->associate(Discount::find($request->discount_id));
        $coupon->amount = $request->amount;
        $coupon->expiry_date = $request->expiry_date;

        if($request->free_shipping) $coupon->free_shipping = true; else $coupon->free_shipping = false;
        if($request->usage_coupon) $coupon->usage_coupon = $request->usage_coupon;
        if($request->usage_user) $coupon->usage_user = $request->usage_user;
        if($request->max_spend) $coupon->max_spend = $request->max_spend;
        if($request->min_spend) $coupon->min_spend = $request->min_spend;
        if($request->use_only) $coupon->use_only = true; else $coupon->use_only = false;
        if($request->sale_items) $coupon->sale_items = false; else $coupon->sale_items = true;

        $coupon->email_restrict = $request->email_restrict;

        $coupon->save();

        $coupon->products()->detach();

        if($request->categories){
            foreach (Categorie::whereIn('id', $request->categories)->get() as $cat) {
                $coupon->products()->saveMany($cat->products->whereNotIn('id', $coupon->products()->pluck('product_id')));
            }
            if($request->product){
                $coupon->products()->attach(Product::whereIn('id', $request->product)->whereNotIn('id', $coupon->products()->pluck('product_id'))->pluck('id'));
            }
            if($request->exclude_products){
                $coupon->products()->detach($request->exclude_products);
            }
        }elseif($request->exclude_categories){
            foreach (Categorie::whereNotIn('id', $request->exclude_categories)->get() as $cat) {
                $coupon->products()->saveMany($cat->products->whereNotIn('id', $coupon->products()->pluck('product_id')));
            }
            if($request->product){
                $coupon->products()->attach(Product::whereIn('id', $request->product)->whereNotIn('id', $coupon->products()->pluck('product_id'))->pluck('id'));
            }
            if($request->exclude_products){
                $coupon->products()->detach($request->exclude_products);
            }
        }elseif($request->product){
            $coupon->products()->attach(Product::whereIn('id', $request->product)->whereNotIn('id', $coupon->products()->pluck('product_id'))->pluck('id'));
        }elseif($request->exclude_products){
            $coupon->products()->detach($request->exclude_products);
        }

        return redirect()->route('coupon.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupon.index');
    }
 
    public function status_change(Request $request, Coupon $coupon)
    {
        $coupon->status = ($request->status == 'true') ? 1 : 0;
        $coupon->save();

        return response()->json($coupon->status);
    }

    public function search(Request $request)
    {

        if(!$request->search && $request->status == -1){
            return redirect()->route('coupon.index');
        }

        if($request->search){
            $coupon = Coupon::where('name', 'like', '%' . $request->search . '%');
        }else{
            $coupon = Coupon::query();
        }

        if($request->status == 0){
            $coupon->where('status', false);
        }elseif($request->status == 1){
            $coupon->where('status', true);
        }

        $orders_coupon = Order::where('amount', '<>', 'without_discount')->get();
        $data['revenue'] = 0;
        $data['discount'] = 0;
        $data['placements'] = 0;
        $data['coupon'] = 0;
        foreach ($orders_coupon as $order){

            if(empty($order->payment)){
                continue;
            }

            $data['coupon'] += $order->coupons()->count();
            $data['revenue'] += $order->amount;
            $data['discount'] += $order->without_discount - $order->amount;

            foreach ($order->projects as $project){
                foreach ($project->products as $product){
                    $data['placements'] += $product->pivot->quantity;
                }
            }

        }

        return view('admin.coupon_manager', [
            'data' => $data,
            'coupons' => $coupon->get(),
            'discount' => Discount::all(),
            'cats' => Categorie::all()
        ]);
    }
}
