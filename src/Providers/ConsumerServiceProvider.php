<?php

namespace Motwreen\Consumer\Providers;

use Illuminate\Support\ServiceProvider;
use Motwreen\Consumer\Http\Middleware\Authenticate;
use \Illuminate\Routing\Router;
use \Illuminate\Contracts\Http\Kernel;

class ConsumerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Override Auth Middleware
        app(Router::class)->aliasMiddleware('auth', Authenticate::class);

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/consumer.php', 'consumer'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        config(['auth.guards.' . config('consumer.guard') . '.driver' => config('consumer.token_holder')]);

        $this->publishes([
            __DIR__ . '/../consumer.php' => config_path('consumer.php'),
        ]);
    }


}
