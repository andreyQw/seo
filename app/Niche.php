<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Niche extends Model
{
    protected $fillable = ['name'];

    public function partners ()
    {
        return $this->hasMany('App\Partner');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Model\Project', 'niche_project');
    }
}
