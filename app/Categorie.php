<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    public $fillable = [
        "name"
    ];

    public function products()
    {
        return $this->hasMany('App\Model\Product');
    }
}
