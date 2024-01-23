<?php

namespace Akincand\LaraSocket;

use Illuminate\Support\ServiceProvider;

/**
 * Class PackageServiceProvider.
 */
class LaraSocketServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/larasocket.php', 'larasocket');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePublishing();
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/config/larasocket.php' => config_path('larasocket.php'),
            ], 'config');
        }
    }
}