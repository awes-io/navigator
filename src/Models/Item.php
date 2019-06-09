<?php

namespace AwesIO\Navigator\Models;

use ArrayIterator;
use IteratorAggregate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use AwesIO\Navigator\Contracts\Item as ItemContract;

class Item implements ItemContract, IteratorAggregate
{
    private $id;

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
            optional($this->children())->toArray()
        );
    }

    public function __get($prop)
    {
        return $this->$prop ?? null;
    }

    public function hasChildren(): bool
    {
        return (bool) optional($this->children())->isNotEmpty();
    }

    public function children()
    {
        return $this->{config('navigator.keys.children')};
    }

    public function link()
    {
        return $this->{config('navigator.keys.link')};
    }

    public function isActive(): bool
    {
        return (bool) $this->active;
    }

    public function getActiveId()
    {
        return optional($this->getActive())->id;
    }

    public function getActive()
    {
        $this->find($this, $key = 'active', true);

        return $this->{$this->propName($key)};
    }

    public function findById($id)
    {
        $this->find($this, $key = 'id', $id);

        return $this->{$this->propName($key)};
    }

    private function markAsActive()
    {
        if (Request::is($this->getPath())) {
            $this->active = true;
        }
    }

    private function getPath()
    {
        return trim(parse_url($this->link(), PHP_URL_PATH), '/') ?:
            ($this->link() ? '/' : null);
    }

    private function find($item, $key, $value)
    {
        if ($item->$key == $value) {
            $this->{$this->propName($key)} = $item;
        }

        if ($item->hasChildren())
        {
            return $item->children()->each(function($child) use ($key, $value) {
                $this->find($child, $key, $value);
            });
        }
    }

    private function propName($key)
    {
        return '_'.$key.'Item';
    }
}
