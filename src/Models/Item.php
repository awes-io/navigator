<?php

namespace AwesIO\Navigator\Models;

use ArrayIterator;
use IteratorAggregate;
use Illuminate\Support\Collection;

class Item implements IteratorAggregate
{
    private $item;

    private $link;

    private $title;

    private $children;

    private $attr;

    public function __construct(Collection $item)
    {
        $this->item = $item;

        $this->process($item);
    }

    public function __get($prop)
    {
        return $this->$prop;
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
        $this->link = $item->get(config('navigator.keys.link'));

        $this->title = $item->get(config('navigator.keys.title'));

        $this->children = $item->get(config('navigator.keys.children'));

        $this->attr = $item->get(config('navigator.keys.attr'));
    }
}
