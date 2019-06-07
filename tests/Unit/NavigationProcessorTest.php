<?php

namespace AwesIO\Navigator\Tests\Unit;

use AwesIO\Navigator\Contracts\Menu;
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
        $this->assertInstanceOf(Menu::class, $this->processor->build());
    }
}
