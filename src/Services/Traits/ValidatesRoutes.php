<?php

namespace AwesIO\Navigator\Services\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\Access\Gate;

trait ValidatesRoutes
{
    private function isAllowedRoute($route)
    {
        if (Route::has($route)) {

            $middlewares = $this->getAuthMiddlewares($route);

            return $this->validateAuthMiddlewares($middlewares)
                ->every(function($value) {
                    return $value;
                });
        }
        return true;
    }

    private function getAuthMiddlewares(string $route)
    {
        $middlewares = collect(
            Route::getRoutes()->getByName($route)->gatherMiddleware()
        );

        return $middlewares->filter(function ($value) {
            return preg_match('/can:/', $value);
        });
    }

    private function validateAuthMiddlewares(Collection $middlewares)
    {
        return $middlewares->map(function($value) {

            $data = Str::after($value, 'can:');

            $abilities = explode(',', $data);
            
            return app(Gate::class)->allows(head($abilities), last($abilities));
        });
    }
}
