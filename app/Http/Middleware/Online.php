<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;
use Cache;

class Online
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $user = Auth::user();

            $expiry = Carbon::now()->addMinutes(5);
            Cache::put('online_' . $user->id, true, $expiry);

            $user->last_activity = Carbon::now()->format('Y-m-d H:i:s');
            $user->save();
        }

        return $next($request);
    }
}
