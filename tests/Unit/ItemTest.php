<?php

namespace AwesIO\Navigator\Tests\Unit;

use AwesIO\Navigator\Models\Item;
use AwesIO\Navigator\Tests\TestCase;

class ItemTest extends TestCase
{
    public function testReturnsItemProps()
    {
        $item = new Item(collect([
            $key = uniqid() => $value = uniqid()
        ]));

        $this->assertEquals($value, $item->$key);

        $this->assertEquals(null, $item->unknown);
    }
}
