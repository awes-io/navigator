<?php

namespace AwesIO\Navigator;

use Closure;
use AwesIO\Navigator\Models\Menu;
use AwesIO\Navigator\Services\NavigationProcessor;
use AwesIO\Navigator\Contracts\Navigator as NavigatorContract;

class Navigator implements NavigatorContract
{
    public function buildMenu(array $menu, Closure $closure = null) :Menu
    {
        $processor = new NavigationProcessor(collect($menu)->recursive());

        return $processor->build($closure);
    }
}
