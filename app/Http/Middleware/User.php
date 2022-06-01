<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if (!empty(Auth::user())) {
            if( !empty(Auth::user()->is_verified)) {
                if(Auth::user()->status == STATUS_ACTIVE) {
                    if(Auth::user()->role == USER_ROLE_USER) {
                        return $next($request);
                    } else {
                        Auth::logout();
                        return redirect()->route('login')->with('dismiss',__('You are not eligible for login in this panel'));
                    }
                } else {
                    Auth::logout();
                    return redirect()->route('login')->with('dismiss',__('Your account is currently deactivate, Please contact to admin'));
                }
            } else {
                Auth::logout();
                return redirect()->route('login')->with('dismiss',__('Please verify your email'));
            }
        }
        else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
