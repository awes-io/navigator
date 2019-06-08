<?php

if (!function_exists('buildMenu')) {
    function buildMenu(array $menu, \Closure $closure)
    {
        return \AwesIO\Navigator\Facades\Navigator::buildMenu($menu, $closure);
    }
}