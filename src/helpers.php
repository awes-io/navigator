<?php

if (!function_exists('buildMenu')) {
    function buildMenu(array $menu, array $config = [], array $mappings = [], \Closure $closure = null)
    {
        return \AwesIO\Navigator\Facades\Navigator::buildMenu($menu, $config, $mappings, $closure);
    }
}