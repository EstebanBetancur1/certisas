<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next, ...$guards)
    { 
        $routeName = 'auth.user.login.show';
        $guard = null;

        if(in_array("admin", $guards)){
            $routeName = "auth.admin.login.show";
            $guard = "admin";
        }

        // Returns true if the current user is not logged in (a guest).        
        if (Auth::guard($guard)->guest()) {
            return (request()->ajax()) ? response()->json('No Autorizado', 401): redirect(route($routeName));
        }else{
            if(! Auth::guard($guard)->check()){
                return (request()->ajax()) ? response()->json('No Autorizado', 401): redirect(route($routeName));
            }
        }

        return $next($request);
    }
}
