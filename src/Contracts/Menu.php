<?php

namespace AwesIO\Navigator\Contracts;

use Illuminate\Support\Collection;

interface Menu
{
    public function __construct(Collection $menu);

    public function getIterator();
}
