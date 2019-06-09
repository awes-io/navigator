<?php

namespace AwesIO\Navigator\Contracts;

use Closure;

interface Navigator
{
    public function buildMenu(array $menu, array $mappings = [], Closure $closure = null) :Item;
}
