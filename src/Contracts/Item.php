<?php

namespace AwesIO\Navigator\Contracts;

use Illuminate\Support\Collection;

interface Item
{
    public function __construct(Collection $item);

    public function hasChildren(): bool;

    public function children(): Collection;

    public function link(): string;

    public function isActive(): bool;
}
