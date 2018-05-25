<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Project
 * @package App\Model
 *
 * @property string $url
 * @property string $alias
 * @property string $image
 * @property string $status
 * @property User $user
 * @property integer $user_id
 *
 */

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = ['url', 'alias', 'image', 'status', 'description', 'enable_notifi', 'quantity', 'niche_id'];

    public function products()
    {
        return $this->belongsToMany('App\Model\Product')->withPivot('quantity');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function users()
    {
    	return $this->belongsToMany('App\User')->withPivot('enable_notifi');
    }
    
    public function bio()
    {
        return $this->hasOne('App\Bio');
    }

    public function anchors() {
        return $this->hasMany('App\Anchor');
    }

    public function partners() {
        return $this->hasMany('App\Partner');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Model\Order', 'order_project');
    }

    public function niche()
    {
        return $this->belongsTo('App\Niche');
    }
    
    public function niches()
    {
        return $this->belongsToMany('App\Niche', 'niche_project');
    }
    public function productions()
    {
        return $this->hasMany('App\Production');
    }

    public function feeds()
    {
        return $this->hasMany('App\Feed');
    }
}
