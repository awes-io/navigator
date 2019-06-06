<?php

namespace AwesIO\Navigator\Models;

use ArrayIterator;
use IteratorAggregate;
use Illuminate\Support\Collection;
use AwesIO\Navigator\Contracts\Menu as MenuContract;

class Menu implements MenuContract, IteratorAggregate
{
    private $menu;

    public function __construct(Collection $menu)
    {
        $this->menu = $this->process($menu);
    }

    public function getIterator() 
    {
        return new ArrayIterator($this->menu->toArray());
    }

    private function process($menu)
    {
        if (! $menu instanceOf Collection) return $menu;

        return $menu->map(function($item) {
            
            if (optional($item)->has(config('navigator.keys.title'))) {
                return new Item($this->process($item));
            }
            return $this->process($item);
        });
    }
}
