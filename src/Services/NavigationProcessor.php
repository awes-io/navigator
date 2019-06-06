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

    public function build($closure): Menu
    {
        return new Menu($this->process($this->menu, $closure));
    }

    private function process($menu, $closure)
    {
        return $this->sortByOrder($menu)->map(function ($item) use ($closure) {

                $item = $this->processChildren($item, $closure);

                $this->processRoute($item);

                if (! is_null($closure)) {
                    $item = $closure($item);
                }
                return $item;
            }
        );
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
