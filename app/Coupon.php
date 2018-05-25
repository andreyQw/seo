<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    public $fillable = [

        'name', 'description', 'discount_id', 'amount', 'expiry_date',
        'free_shipping', 'usage_coupon', 'usage_user',
        'max_spend', 'min_spend', 'use_only',
        'sale_items', 'email_restrict', 'status'

    ];

    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->belongsToMany('App\Model\Order');
    }

    public function discount()
    {
    	return $this->belongsTo('App\Discount');
    }

    public function products()
    {
    	return $this->belongsToMany('App\Model\Product');
    }
}
