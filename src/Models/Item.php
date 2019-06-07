<?php

namespace AwesIO\Navigator\Models;

use Illuminate\Support\Collection;
use AwesIO\Navigator\Contracts\Item as ItemContract;

class Item implements ItemContract
{
    public function __construct(Collection $item)
    {
        $item->each(function($prop, $key) {
            $this->$key = $prop;
        });
    }

    public function __get($prop)
    {
        return $this->$prop ?? null;
    }
}
