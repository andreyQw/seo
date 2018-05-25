<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Model
 *
 * @property string $title
 * @property double $price
 * @property string $sku
 * @property string $status show/hide
 * @property string $deleted existing/deleted
 */
class Product extends Model
{
    protected $table = 'products';

    protected $fillable = ['title', 'price', 'sku', 'status', 'deleted', 'quantity', 'categorie_id', 'project_id'];

    public function categorie()
    {
        return $this->belongsTo('App\Categorie');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Model\Project', 'product_project')->withPivot('quantity');
    }

    public function coupons()
    {
    	return $this->belongsToMany('App\Coupon');
    }

    public function orders()
    {
       return $this->belongsToMany('App\Model\Order')->withPivot('quantity', 'price', 'project_id');
    }
}
