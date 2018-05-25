<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'country', 'phone', 'bgc',
        'email', 'password', 'photo', 'name', 'enable_notifi', 'last_activity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];



    public function projects()
    {
        return $this->belongsToMany('App\Model\Project')->withPivot('enable_notifi');
    }

    public function accounts()
    {
        return $this->belongsToMany('App\Account');
    }

    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

    public function  update_nobses()
    {
        return $this->hasMany('App\UpdateClient');
    }

    public function  update_clients()
    {
        return $this->hasMany('App\UpdateNobs');
    }

    public function  feeds()
    {
        return $this->hasMany('App\Feed');
    }

    public function client()
    {
        return $this->hasOne('App\Client');
    }

    public function writer()
    {
        return $this->hasOne('App\Writer');
    }

    public function editor()
    {
        return $this->hasOne('App\Editor');
    }

    public function partnerManager()
    {
        return $this->hasOne('App\PartnerManager');
    }

    public function productionManager()
    {
        return $this->hasOne('App\ProductionManager');
    }

    public function is_online ()
    {
        return Cache::has('online_' . $this->id);
    }

    public function last_activity ()
    {
        if(empty($this->last_activity)){
            return 'never';
        }

        $last = strtotime(Carbon::parse($this->last_activity)->format('Y-m-d H:i'));
        $last_date = strtotime(Carbon::parse($this->last_activity)->format('Y-m-d 00:00'));
        $now = strtotime(Carbon::now()->format('Y-m-d H:i'));
        $today = strtotime(Carbon::now()->format('Y-m-d 00:00'));
        $yesterday = strtotime(Carbon::parse('yesterday')->format('Y-m-d 00:00'));

        $result_time = strtotime(Carbon::now()->format('Y-m-d H:i')) - strtotime(Carbon::parse($this->last_activity)->format('Y-m-d H:i'));

        if($result_time <= 60){
            return '1 minute ago';
        }elseif ($result_time <= 3600) {
            return (floor(($now - $last) / 60)) . ' minutes ago';
        }elseif($result_time <= 43200){
            if(floor(($now - $last) / 3600) == 1){
                return '1 hour ago';
            }else{
                return (floor(($now - $last) / 3600)) . ' hours ago';
            }
        }elseif($last >= $today){
            return 'today';
        }elseif($last < $today){
            if($last >= $yesterday){
                return 'yesterday';
            }

            if($today - $last_date <= 86400 * 7){
                return floor(($today - $last_date) / 86400) . ' days ago';
            }

            return Carbon::parse($this->last_activity)->format('F j Y');
        }
    }
}
