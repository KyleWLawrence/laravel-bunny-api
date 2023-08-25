<?php

namespace KyleWLawrence\Bunny\Providers;

use Illuminate\Support\ServiceProvider;
use KyleWLawrence\Bunny\Services\BunnyService;
use KyleWLawrence\Bunny\Services\NullService;

class BunnyServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider and merge config.
     *
     * @return void
     */
    public function register()
    {
        $packageName = 'bunny-laravel';
        $configPath = __DIR__.'/../../config/bunny-laravel.php';

        $this->mergeConfigFrom(
            $configPath, $packageName
        );

        $this->publishes([
            $configPath => config_path(sprintf('%s.php', $packageName)),
        ]);
    }

    /**
     * Bind service to 'Bunny' for use with Facade.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('Bunny', function () {
            $driver = config('bunny-laravel.driver', 'api');
            if (is_null($driver) || $driver === 'log') {
                return new NullService($driver === 'log');
            }

            return new BunnyService;
        });
    }
}
