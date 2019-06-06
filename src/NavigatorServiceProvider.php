<?php

namespace AwesIO\Navigator;

use AwesIO\Navigator\Contracts\Navigator as NavigatorContract;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class NavigatorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/navigator.php' => config_path('navigator.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('recursive', function () {

            return $this->map(function ($value) {

                if (is_array($value) || is_object($value)) {
                    return collect($value)->recursive();
                }
        
                return $value;
            });
        });

        $this->mergeConfigFrom(__DIR__.'/../config/navigator.php', 'navigator');

        $this->app->bind(NavigatorContract::class, Navigator::class);

        $this->app->singleton('navigator', NavigatorContract::class);
    }
}
