<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Order
 * @package App\Model
 *
 * @property string $url
 * @property integer $account_id
 * @property integer $user_id
 * @property float $amount
 * @property float $without_discount
 * @property string $approve_status //on_hold, refunded, completed
 * @property [] $projects
 *
 */
class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';
    protected $dates = ['deleted_at'];
    protected $fillable = ['account_id', 'user_id', 'amount', 'without_discount', 'approve_status', 'project_id'];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function products()
    {
       return $this->belongsToMany('App\Model\Product')->withPivot('quantity', 'price', 'project_id');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Model\Project', 'order_project');
    }

    public function payment()
    {
        return $this->hasOne('App\Model\Payment');
    }

    public function coupons()
    {
        return $this->belongsToMany('App\Coupon');
    }

    public function invoice()
    {
        return $this->hasOne('App\Invoice');
    }

    public function productions()
    {
        return $this->hasMany('App\Production');
    }


}
