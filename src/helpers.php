<?php

if (!function_exists('buildMenu')) {
    function buildMenu(array $menu, array $mappings = [], \Closure $closure = null)
    {
        return \AwesIO\Navigator\Facades\Navigator::buildMenu($menu, $mappings, $closure);
    }
}