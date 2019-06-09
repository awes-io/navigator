<?php

namespace AwesIO\Navigator\Models;

use ArrayIterator;
use IteratorAggregate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use AwesIO\Navigator\Contracts\Item as ItemContract;

class Item implements ItemContract, IteratorAggregate
{
    private $active = false;

    public function __construct(Collection $item)
    {
        $this->id = uniqid("", true);
        
        $item->each(function($prop, $key) {
            $this->$key = $prop;
        });

        $this->markAsActive();
    }

    public function getIterator() 
    {
        return new ArrayIterator(
            optional(
                $this->{config('navigator.keys.children')}
            )->toArray()
        );
    }

    public function __get($prop)
    {
        return $this->$prop ?? null;
    }

    public function hasChildren(): bool
    {
        return (bool) optional(
            $this->{config('navigator.keys.children')}
        )->isNotEmpty();
    }

    public function children(): Collection
    {
        return $this->{config('navigator.keys.children')};
    }

    public function link(): string
    {
        return $this->link;
    }

    public function isActive(): bool
    {
        return (bool) $this->active;
    }

    private function markAsActive()
    {
        if (Request::is($this->getPath())) {
            $this->active = true;
        }
    }

    private function getPath()
    {
        $key = config('navigator.keys.link');

        return trim(parse_url($this->{$key}, PHP_URL_PATH), '/') ?:
            ($this->{$key} ? '/' : null);
    }
}
