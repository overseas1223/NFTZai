<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;

class WalletNotify
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
        if (true || $request->header('secret_key') == env('WALLET_NOTIFY_SECRET_KEY') || env('APP_ENV') != 'production')
        {
            Log::info(json_encode($request->all()));
            Log::info(json_encode($request->header('secret_key')));
            return $next($request);
        }

        return response()->json([
            'status' => false,
            'message' => 'You are unauthorized'
        ]);
    }
}
