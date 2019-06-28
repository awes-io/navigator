<?php

namespace AwesIO\Navigator\Services;

use AwesIO\Navigator\Models\Item;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use AwesIO\Navigator\Services\Traits\ValidatesRoutes;

class NavigationProcessor
{
    use ValidatesRoutes;

    private $menu;

    private $closure;

    public function __construct(Collection $menu)
    {
        $this->menu = $menu;
    }

    public function setPostProcessor($closure): self
    {
        $this->closure = $closure;

        return $this;
    }

    public function build(array $config = []): Item
    {
        $key = config('navigator.keys.children');

        $menu = collect([
             $key => $this->process($this->menu, 10, $config)
        ]);

        return new Item($menu);
    }

    private function process($menu, $depth, $config = []): Collection
    {
        return $this->sortByOrder($menu)->map(function ($item) use ($depth, $config) {

            $depth = $config['depth'] ?? ($item->get(config('navigator.keys.depth')) ?? $depth);

            if ($depth >= 0) {

                if (! $this->processRoute($item)) return null;

                $this->processChildren($item, $depth - 1);

                $this->applyPostProcessing($item);

                return $this->wrapItem($item);
            } else {
                return null;
            }
        })->filter();
    }

    private function sortByOrder(Collection $menu)
    {
        return $menu->sortBy(config('navigator.keys.order'))->values();
    }

    private function getRouteName(Collection $item)
    {
        return optional($item)->get(config('navigator.keys.route'));
    }

    private function processRoute($item)
    {
        $routeName = $this->getRouteName($item);

        if (! $this->isAllowedRoute($routeName)) {
            return false;
        }

        if (Route::has($routeName)) {

            $item->put(config('navigator.keys.link'), route($routeName));

            return true;
        }
        return optional($item)->get(config('navigator.keys.link'), false);
    }

    private function processChildren($item, $depth)
    {
        $key = config('navigator.keys.children');

        $children = optional($item)->get($key);

        if ($children) {
            $item[$key] = $this->process($children, $depth);
        }
    }

    private function applyPostProcessing($item)
    {
        if (! is_null($closure = $this->closure)) $closure($item);
    }

    private function wrapItem($item)
    {
        $key = config('navigator.keys.title');

        return optional($item)->has($key) ? new Item($item) : $item;
    }
}
