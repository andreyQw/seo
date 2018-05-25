<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }
    public function project()
    {
        return $this->belongsTo('App\Model\Project');
    }
    public function writer()
    {
        return $this->belongsTo('App\Writer');
    }

    public function editor()
    {
        return $this->belongsTo('App\Editor');
    }

    public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }
}
