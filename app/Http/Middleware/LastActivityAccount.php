<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;

class LastActivityAccount
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
        if(Auth::check() && Auth::user()->hasRole('client')){
            $user = Auth::user();

            foreach ($user->accounts as $account) {
                $account->last_activity = Carbon::now()->format('Y-m-d H:i:s');
                $account->save();
            }
        }

        return $next($request);
    }
}
