<?php

namespace AkincanD\LaraSocket;

use Illuminate\Support\ServiceProvider;

/**
 * Class PackageServiceProvider.
 */
class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('larasocket', LaraSocket::class);
        $this->mergeConfigFrom(__DIR__ . './../config/larasocket.php', 'larasocket');
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
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [__DIR__ . './../config/larasocket.php' => config_path('larasocket.php')],
                'larasocket'
            );
        }
    }
}