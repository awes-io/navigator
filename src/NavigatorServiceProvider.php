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
        Collection::macro('navigationWalk', function (callable $closure, $inside = false) {

            $sorted = $this->sortBy('order')->values();

            return $sorted->map(function ($item, $key) use ($closure) {

                if (is_array($item) && $child = collect($item)->get('children')) {
                    $item['children'] = collect($child)->navigationWalk($closure, true);
                }

                return $item;
            });
        });


        $this->mergeConfigFrom(__DIR__.'/../config/navigator.php', 'navigator');

        $this->app->bind(NavigatorContract::class, Navigator::class);

        $this->app->singleton('navigator', NavigatorContract::class);
    }
}
