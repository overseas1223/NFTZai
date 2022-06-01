<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if (!empty(Auth::user())) {
            if( !empty(Auth::user()->is_verified)) {
                if(Auth::user()->status == STATUS_ACTIVE) {
                    if(Auth::user()->role == USER_ROLE_ADMIN) {
                        return $next($request);
                    } else {
                        Auth::logout();
                        return redirect('login')->with('dismiss',__('You are not eligible for login in this panel'));
                    }
                } else {
                    Auth::logout();
                    return redirect('login')->with('dismiss',__('Your account is currently deactivate, Please contact to admin'));
                }
            } else {
                Auth::logout();
                return redirect('login')->with('dismiss',__('Please verify your email'));
            }
        }
        else {
            Auth::logout();
            return redirect('login');
        }
    }
}
