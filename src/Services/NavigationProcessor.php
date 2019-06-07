<?php

namespace AwesIO\Navigator\Services;

use Illuminate\Support\Str;
use AwesIO\Navigator\Models\Menu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\Access\Gate;

class NavigationProcessor
{
    private $menu;

    public function __construct(Collection $menu)
    {
        $this->menu = $menu;
    }

    public function build($closure = null): Menu
    {
        return new Menu($this->process($this->menu, $closure));
    }

    private function process($menu, $closure)
    {
        return $this->sortByOrder($menu)->map(function ($item) use ($closure) {

            if (! $this->processRoute($item)) {
                return null;
            }

            $this->processChildren($item, $closure);

            if (! is_null($closure)) $closure($item);

            return $item;

        })->filter();
    }

    private function sortByOrder($menu)
    {
        return $menu->sortBy(config('navigator.keys.order'))->values();
    }

    private function processChildren($item, $closure)
    {
        $children = optional($item)->get(config('navigator.keys.children'));

        if ($children) {
            $key = config('navigator.keys.children');
            $item[$key] = $this->process($children, $closure);
        }
    }

    private function processRoute($item)
    {
        $route = optional($item)->get(config('navigator.keys.route'));

        if ($route && Route::has($route)) {
            $item->put(config('navigator.keys.link'), route($route));
            return $this->routeAllowed($route);
        }
        return true;
    }

    private function routeAllowed($route)
    {
        $middlewares = collect(Route::getRoutes()->getByName($route)->gatherMiddleware());

        $middlewares = $middlewares->filter(function ($value) {
            return preg_match('/can:/', $value);
        });

        return $middlewares->map(function($value) {
            $data = Str::after($value, 'can:');
            $abilities = explode(',', $data);
            return app(Gate::class)->allows(head($abilities), last($abilities));
        })->every(function($value) {
            return $value;
        });
    }
}
