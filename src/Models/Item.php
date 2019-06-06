<?php

namespace AwesIO\Navigator\Models;

use ArrayIterator;
use IteratorAggregate;
use Illuminate\Support\Collection;

class Item implements IteratorAggregate
{
    private $item;

    public function __construct(Collection $item)
    {
        $this->item = $item;

        $this->process($item);
    }

    public function __get($prop)
    {
        return $this->$prop ?? null;
    }

    public function getIterator() 
    {
        return new ArrayIterator($this->toArray());
    }

    public function toArray()
    {
        return $this->item->toArray();
    }

    private function process($item)
    {
        $this->item->each(function($prop, $key) {
            $this->$key = $prop;
        });
    }
}
