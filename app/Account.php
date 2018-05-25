<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class Account extends Model
{
    protected $fillable = [
        'name', 'email', 'owner_id', 'phone', 'type', 'stage', 'no_staff', 'no_websites', 'logo', 'last_activity'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function orders()
    {
        return $this->hasMany('App\Model\Order');
    }

    public function projects()
    {
        return $this->hasMany('App\Model\Project');
    }

    public function save_user(User $user){

        $this->users()->save($user);
        foreach ($this->projects as $project) {
            $project->users()->save($user);
        }

    }
    public function delete_user(User $user){

        $this->users()->detach($user->id);
        foreach ($this->projects as $project) {
            $project->users()->detach($user->id);
        }

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
