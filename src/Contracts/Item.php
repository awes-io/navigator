<?php

namespace AwesIO\Navigator\Contracts;

use Illuminate\Support\Collection;

interface Item
{
    public function __construct(Collection $item);

    public function hasChildren(): bool;

    public function children();

    public function link();

    public function isActive(): bool;

    public function getActiveId();

    public function getActive();
}
