<?php

namespace AwesIO\Navigator;

use AwesIO\Navigator\Contracts\Navigator as NavigatorContract;

class Navigator implements NavigatorContract
{

    public function getMenu(array $menu)
    {
        return collect($menu)->navigationWalk(new ProcessNavigation());
    }

}
