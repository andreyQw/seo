<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['path', 'order_id'];

    public function order ()
    {
        return $this->belongsTo('App\Model\Order');
    }
}
