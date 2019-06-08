<?php

namespace AwesIO\Navigator\Tests\Unit;

use AwesIO\Navigator\Navigator;
use AwesIO\Navigator\Contracts\Item;
use AwesIO\Navigator\Tests\TestCase;

class NavigatorTest extends TestCase
{
    public function testReturnsMenuInstance()
    {
        $menu = (new Navigator())->buildMenu(config('navigator.tests.menu'));

        $this->assertInstanceOf(Item::class, $menu);
    }

    public function testAcceptsAndAppliesClosure()
    {
        $value = uniqid();

        $menu = (new Navigator())->buildMenu([[], []], function($item) use ($value) {
            $item['a'] = $value;
        });

        foreach ($menu as $item) {
            $this->assertTrue($item['a'] == $value);
        }
    }
}
