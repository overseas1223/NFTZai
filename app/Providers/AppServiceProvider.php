<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (function_exists('bcscale')) {
            bcscale(8);
        }
        Validator::extend('strong_pass', function($attribute, $value, $parameters, $validator) {
            return is_string($value) && preg_match('/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/', $value);
        });
        $this->app->bind('CoinApiService', function ($app, $parameters) {
            $className = 'App\Http\Services\\' . $parameters[0];
            $coinType = strtoupper($parameters[1]);
            $user = env($coinType . "_USER");
            $pass = env($coinType . "_PASS");
            $host = env($coinType . "_HOST");
            $port = env($coinType . "_PORT");
            if($parameters[0] == 'CoinPaymentsApiService'){
                return new $className($coinType);
            }
            return new $className($user, $pass, $host, $port, $coinType);
        });
    }
}
