<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{

    public $fillable = ['name', 'as'];

    public function coupons()
    {
    	return $this->hasMany('App\Coupon');
    }

}
