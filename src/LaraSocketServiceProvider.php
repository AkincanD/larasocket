<?php

namespace Akincand\LaraSocket;

use Illuminate\Support\ServiceProvider;

/**
 * Class PackageServiceProvider.
 */
class LaraSocketServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/larasocket.php' => config_path('larasocket.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/config/larasocket.php',
            'larasocket'
        );

    }
}