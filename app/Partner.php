<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email',
        'company_name', 'paypal_id', 'domain', 'cost', 'niche_id',
        'bsi_id', 'month_placements', 'dr', 'tf', 'cf', 'da',
        'traffic',   'ref_domains', 'description', 'photo'];

    public function niche()
    {
        return $this->belongsTo('App\Niche');
    }

    public function bsi()
    {
        return $this->belongsTo('App\Bsi');
    }

    public function anchors()
    {
        return $this->hasMany('App\Anchor');
    }
    public function projects()
    {
        return $this->hasMany('App\Model\Project');
    }
    public function productions()
    {
        return $this->hasMany('App\Production');
    }
}
