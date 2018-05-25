<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Writer extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function productions()
    {
        return $this->hasMany('App\Production');
    }
}
