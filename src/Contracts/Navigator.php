<?php

namespace AwesIO\Navigator\Contracts;

use Closure;

interface Navigator
{
    public function buildMenu(array $menu, Closure $closure = null);
}
