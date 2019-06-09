<?php

namespace AwesIO\Navigator\Tests\Unit;

use AwesIO\Navigator\Models\Item;
use Illuminate\Support\Collection;
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

    public function testReturnsChildren()
    {
        $item = new Item(collect(['children' => collect([$value = uniqid()])]));

        $this->assertInstanceOf(Collection::class, $item->children());

        $this->assertEquals($value, $item->children()->first());
    }

    public function testReturnsLink()
    {
        $item = new Item(collect(['link' => $link = uniqid()]));

        $this->assertEquals($link, $item->link());
    }

    public function testReturnsIfIsActive()
    {
        $item = new Item(collect([]));

        $this->assertFalse($item->isActive());

        $item = new Item(collect(['active' => false]));

        $this->assertFalse($item->isActive());

        $item = new Item(collect(['active' => true]));

        $this->assertTrue($item->isActive());
    }

    public function testReturnsActiveItem()
    {
        $item = new Item(collect([ 
            'children' => collect([
                new Item(collect(['active' => false])),
                new Item(collect(['active' => true, 'title' => $title = uniqid(), 
                    'children' => collect([
                        new Item(collect(['active' => false]))
                    ])
                ]))
            ])
        ]));

        $this->assertEquals($title, $item->getActive()->title);

        $item = new Item(collect([ 
            'children' => collect([
                new Item(collect(['active' => false])),
                new Item(collect(['children' => collect([
                    new Item(collect(['active' => true, 'title' => $title = uniqid()]))
                ])]))
            ])
        ]));

        $this->assertEquals($title, $item->getActive()->title);

        $item = new Item(collect([ 
            'children' => collect([
                new Item(collect(['active' => true, 'title' => $title = uniqid()])),
                new Item(collect(['children' => collect([
                    new Item(collect(['active' => false]))
                ])]))
            ])
        ]));

        $this->assertEquals($title, $item->getActive()->title);
    }

    public function testReturnsActiveItemId()
    {
        $item = new Item(collect([ 
            'children' => collect([
                new Item(collect(['active' => false])),
                new Item(collect(['active' => true, 'id' => $id = uniqid(), 
                    'children' => collect([
                        new Item(collect(['active' => false]))
                    ])
                ]))
            ])
        ]));

        $this->assertEquals($id, $item->getActiveId());

        $item = new Item(collect([ 
            'children' => collect([
                new Item(collect(['active' => false])),
                new Item(collect(['children' => collect([
                    new Item(collect(['active' => true, 'id' => $id = uniqid()]))
                ])]))
            ])
        ]));

        $this->assertEquals($id, $item->getActiveId());

        $item = new Item(collect([ 
            'children' => collect([
                new Item(collect(['active' => true, 'id' => $id = uniqid()])),
                new Item(collect(['children' => collect([
                    new Item(collect(['active' => false]))
                ])]))
            ])
        ]));

        $this->assertEquals($id, $item->getActiveId());
    }

    public function testFindsItemById()
    {
        $item = new Item(collect([ 
            'children' => collect([
                new Item(collect(['active' => false])),
                new Item(collect(['active' => true, 'title' => $title = uniqid(), 'id' => $id = uniqid(), 
                    'children' => collect([
                        new Item(collect(['active' => false]))
                    ])
                ]))
            ])
        ]));

        $this->assertEquals($title, $item->findById($id)->title);

        $item = new Item(collect([ 
            'children' => collect([
                new Item(collect(['active' => false])),
                new Item(collect(['children' => collect([
                    new Item(collect(['active' => true, 'title' => $title = uniqid(), 'id' => $id = uniqid()]))
                ])]))
            ])
        ]));

        $this->assertEquals($title, $item->findById($id)->title);

        $item = new Item(collect([ 
            'children' => collect([
                new Item(collect(['active' => true, 'title' => $title = uniqid(), 'id' => $id = uniqid()])),
                new Item(collect(['children' => collect([
                    new Item(collect(['active' => false]))
                ])]))
            ])
        ]));

        $this->assertEquals($title, $item->findById($id)->title);
    }
}
