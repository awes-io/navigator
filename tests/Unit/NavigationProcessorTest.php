<?php

namespace AwesIO\Navigator\Tests\Unit;

use AwesIO\Navigator\Contracts\Item;
use AwesIO\Navigator\Tests\TestCase;
use AwesIO\Navigator\Services\NavigationProcessor;

class NavigationProcessorTest extends TestCase
{
    protected $processor;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->processor = new NavigationProcessor(collect(config('navigator.tests.menu'))->recursive());
    }

    public function testReturnsMenuInstance()
    {
        $this->assertInstanceOf(Item::class, $this->processor->build());
    }

    public function testAcceptsAndAppliesClosure()
    {
        $value = uniqid();

        $menu = $this->processor->setPostProcessor(function($item) use ($value) {
            $item['b'] = $value;
        })->build();

        foreach ($menu as $item) {
            $this->assertTrue($item->b == $value);
        }
    }

    public function testSortsByOrder()
    {
        $order = config('navigator.keys.order');
        $link = config('navigator.keys.link');

        $menu = (
            new NavigationProcessor(
                collect([
                    [$link => 'link', $order => 2],
                    [$link => 'link', $order => 0],
                    [$link => 'link', $order => 1],
                    [$link => 'link', $order => 3]
                ])->recursive()
            )
        )->build();

        foreach ($menu as $key => $item) {
            $this->assertTrue($key === $item[$order]);
        }
    }

    public function testProcessesChildren()
    {
        $children = config('navigator.keys.children');

        $menu = $this->processor->build();

        foreach ($menu as $item) {
            $this->assertInstanceOf(Item::class, $item->$children->first());
        }
    }

    public function testProcessesRoutes()
    {
        $route = config('navigator.keys.route');

        $link = config('navigator.keys.link');

        $menu = (
            new NavigationProcessor(
                collect([[$route => $name = 'test', $link => 1]])->recursive()
            )
        )->build();

        foreach ($menu as $item) {
            $this->assertEquals($name, $item[$route]);
            $this->assertEquals(route($name), $item[$link]);
        }
    }

    public function testExcludeProtectedRoutes()
    {
        $route = config('navigator.keys.route');

        $link = config('navigator.keys.link');

        $menu = (
            new NavigationProcessor(
                collect([
                    [$route => 'test', $link => 1],
                    [$route => 'protected', $link => 1]
                ])->recursive()
            )
        )->build();

        $this->assertCount(1, $menu);
    }
}
