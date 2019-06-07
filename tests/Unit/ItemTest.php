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

    public function testDoesntHaveChildren()
    {
        $item = new Item(collect([]));

        $this->assertFalse($item->hasChildren());

        $item = new Item(collect(['children' => collect([])]));

        $this->assertFalse($item->hasChildren());
    }

    public function testHasChildren()
    {
        $item = new Item(collect(['children' => collect([1])]));

        $this->assertTrue($item->hasChildren());
    }
}
