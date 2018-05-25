<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = [
        'event_id', 'project_id', 'table_id', 'user_id'
    ];

    public function project()
    {
        return $this->belongsTo('App\Model\Project');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function update_nobses() {
        return $this->hasMany('App\UpdateNobs');
    }

    public function update_clients() {
        return $this->hasMany('App\UpdateClient');
    }
}
