<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'type', 'title'
    ];

    public function feeds()
    {
        return $this->hasMany('App\Feed');
    }
}
