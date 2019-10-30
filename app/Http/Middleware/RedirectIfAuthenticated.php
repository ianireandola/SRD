<?php

namespace App\Http\Middleware;

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
        /**
         * If they're an admin if they are an admin but let's say they're trying to access an admin page, then in that case (case 'admin') is going to trigger because the guard
         * is going to be equal to admin. So they are trying to access an admin page, for example logged in as a user but not as an admin.
         * They will enter in the admin case, but when they enter in the if statement, but it's goping to say off guard and it's going to test it against admin. If they're logged in as a
         * user but not as an admin this is going to fail, so it's not going to redirect them. It will brak out of the switch statement and then just continue with the request.
         * If it's only protected against admins and you're not logged in as an admin but you're logged in as a user we still want you to see that page, then we want to make this first part
         * allowed.
         * If you're trying to access as an admin and you're logged in as an admin then this will succedd and it will redirect you to the admin dashboard
         */
        switch($guard)
        {
            case 'admin':
                if(Auth::guard($guard)->check())
                {
                    return redirect()->route('admin.dashboard');
                }
                break;
            
                //For the normal user
                default:
                if(Auth::guard($guard)->check())
                {
                    return redirect()->route('home');
                }
                break;
                
        }

        //Checks if we are logged in and if so, it redirects us home
        /**
         * if (Auth::guard($guard)->check()) {
         * return redirect('/home');
         * }
         */
        //Elsewhere it redirects us to the request
        return $next($request);
    }
}
