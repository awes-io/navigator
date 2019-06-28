<?php

namespace AwesIO\Navigator;

use Closure;
use AwesIO\Navigator\Contracts\Item;
use AwesIO\Navigator\Services\NavigationProcessor;
use AwesIO\Navigator\Contracts\Navigator as NavigatorContract;

class Navigator implements NavigatorContract
{
    public function buildMenu(
        array $menu, array $config = [], array $mappings = [], Closure $closure = null) :Item
    {
        config(['navigator.keys' => array_merge(config('navigator.keys'), $mappings)]);

        $processor = new NavigationProcessor(collect($menu)->recursive());

        return $processor->setPostProcessor($closure)->build($config);
    }
}
