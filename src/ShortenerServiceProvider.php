<?php

declare(strict_types=1);

namespace MuhamedDidovic\Shortener;

use Illuminate\Support\ServiceProvider;
use MuhamedDidovic\Shortener\Console\ChuckNorrisJoke;
use MuhamedDidovic\Shortener\Models\Link;
use Laravel\Lumen\Application as LumenApplication;
use MuhamedDidovic\Shortener\Observers\LinkObserver;
use Illuminate\Foundation\Application as LaravelApplication;
use MuhamedDidovic\Shortener\Console\ShortenerCommand;

class ShortenerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Add observer for Link model
         */
        Link::observe(LinkObserver::class);

        //        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
        /*
         * Optional methods to load your package assets
         */
        $source = realpath($raw = __DIR__.'/../config/shortener.php') ?: $raw;
        $this->loadViewsFrom(__DIR__.'/views', 'shortener');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            $source => config_path('shortener.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/shortener'),
        ], 'views');

        // Publishing assets.
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/test'),
            __DIR__.'/../public/css'       => public_path('css/'),
            __DIR__.'/../public/js'        => public_path('js/'),
        ], 'assets');

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/test'),
        ], 'lang');*/

        // Registering package commands.
         $this->commands([
             ShortenerCommand::class
         ]);

        //        $this->publishes([
        //            __DIR__ . '/views' => resource_path('views/vendor/shortener'),
        //        ], 'shortener::view');
        //            $this->publishes([
        //                __DIR__.'/path/to/config/courier.php' => config_path('courier.php'),
        //            ]);
        //        }
        //        elseif ($this->app instanceof LumenApplication) {
        //            $this->app->configure('shortener');
        //        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $source = realpath($raw = __DIR__.'/../config/shortener.php') ?: $raw;

        // Automatically apply the package configuration
        $this->mergeConfigFrom($source, 'shortener');

        // Register the main class to use with the facade
        $this->app->singleton('shortener', function () {
            return new Shortener();
        });

        $this->app->alias('shortener', Shortener::class);
    }
}
