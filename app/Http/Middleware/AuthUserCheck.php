<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthUserCheck
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
                    if(Auth::user()->role == USER_ROLE_USER) {
                        if ((Auth::user()->g2f_enabled) && (session()->has('g2f_checked'))) {
                            return $next($request);
                        } elseif((Auth::user()->g2f_enabled) && !(session()->has('g2f_checked'))) {
                            return redirect()->route('g2fChecked');
                        } else {
                            return $next($request);
                        }
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
