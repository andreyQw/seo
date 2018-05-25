<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateNobs extends Model
{
    public function feed()
    {
        return $this->belongsTo('App\Feed');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
