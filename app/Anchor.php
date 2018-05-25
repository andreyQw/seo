<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anchor extends Model
{
    protected $fillable = ['project_id', 'text', 'url'];

    public function project(){
        return $this->belongsTo('App\Model\Project');
    }

    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }
}
