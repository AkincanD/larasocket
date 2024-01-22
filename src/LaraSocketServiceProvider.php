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
        $this->app->bind('larasocket', LaraSocket::class);
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
        $this->publishes([__DIR__ . '/../config/larasocket.php' => config_path('larasocket.php')], 'config');
    }
}