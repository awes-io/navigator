<?php

namespace AwesIO\Navigator\Models;

use ArrayIterator;
use IteratorAggregate;
use Illuminate\Support\Collection;
use AwesIO\Navigator\Contracts\Item as ItemContract;

class Item implements ItemContract, IteratorAggregate
{
    public function __construct(Collection $item)
    {
        $item->each(function($prop, $key) {
            $this->$key = $prop;
        });
    }

    public function getIterator() 
    {
        return new ArrayIterator(optional($this->{config('navigator.keys.children')})->toArray());
    }

    public function __get($prop)
    {
        return $this->$prop ?? null;
    }

    public function hasChildren(): bool
    {
        return (bool) optional($this->{config('navigator.keys.children')})->isNotEmpty();
    }

    public function children(): Collection
    {
        return $this->{config('navigator.keys.children')};
    }

    public function link(): string
    {
        return $this->link;
    }
}
