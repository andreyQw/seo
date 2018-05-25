<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartnerManager extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
