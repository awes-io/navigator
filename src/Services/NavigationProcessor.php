<?php

namespace AwesIO\Navigator\Services;

use AwesIO\Navigator\Models\Menu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class NavigationProcessor
{
    /**
     * @var Collection
     */
    private $menu;

    public function __construct(Collection $menu)
    {
        $this->menu = $menu;
    }

    public function build($closure)
    {
        $menu = $this->process($this->menu, $closure);

        return new Menu($menu);
    }

    private function process($menu, $closure)
    {
        $menu = $menu->sortBy(config('navigator.keys.order'))->values();

        return $menu->map(function ($item) use ($closure) {

            $item = $this->processChildren($item, $closure);

            $this->processRoute($item);

            if (! is_null($closure)) {
                $item = $closure($item);
            }
            return $item;
        });
    }

    private function processChildren($item, $closure)
    {
        if ($child = optional($item)->get(config('navigator.keys.children'))) {
            $item[config('navigator.keys.children')] = $this->process($child, $closure);
        }
        return $item;
    }

    private function processRoute($item)
    {
        $route = optional($item)->get(config('navigator.keys.route'));

        if ($route && Route::has($route)) {
            $item->put(config('navigator.keys.link'), route($route));
        }
    }
}
