<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    protected $fillable = ['project_id', 'text', 'image', 'help'];

    public function project()
    {
    	return $this->belongsTo('App\Model\Project');
    }
}
