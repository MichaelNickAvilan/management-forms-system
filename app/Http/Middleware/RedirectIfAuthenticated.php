<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            /**
             * ROLES
             * 1: ADMIN
             * 2: WEBMASTER
             * 3: RRHH
             * 4: EMPLOYEE
             */
            $user = Auth::user();
            if($user->type == 2){
                return redirect(RouteServiceProvider::HOME.'/'.$user->id);
            }else{
                return redirect(RouteServiceProvider::HOME.'/all');
            }
        }

        return $next($request);
    }
}
