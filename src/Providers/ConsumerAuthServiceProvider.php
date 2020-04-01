<?php

namespace Motwreen\Consumer\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Motwreen\Consumer\Extensions\AuthProviders\TokenToUserProvider;
use Motwreen\Consumer\Extensions\Guards\AccessTokenGuard;

class ConsumerAuthServiceProvider extends ServiceProvider
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

    public function boot()
    {
        /*
         * Extend Auth and
         * Define our custom driver
         * */
        Auth::extend(config('consumer.token_holder'), function ($app, $name, array $config) {

            $request = app('request');
            //get token from header
            $token = $request->bearerToken();

            $userProvider = new TokenToUserProvider($token);

            return new AccessTokenGuard($userProvider, $request, $config);
        });
    }
}
