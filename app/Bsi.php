<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bsi extends Model
{
    protected $fillable = ['name'];

    public function partners ()
    {
        return $this->hasMany('App\Partner');
    }
}
