<?php

namespace Akincand\LaraSocket;

use Illuminate\Support\ServiceProvider;

class LaraSocketServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('larasocket', 'AkincanD\LaraSocket\LaraSocket');

        $config = __DIR__ . '/../config/larasocket.php';
        $this->mergeConfigFrom($config, 'larasocket');

        $this->publishes([__DIR__ . '/../config/larasocket.php' => config_path('larasocket.php')], 'config');
    }
}