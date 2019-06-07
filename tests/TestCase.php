<?php

namespace AwesIO\Navigator\Tests;

use Illuminate\Database\Schema\Blueprint;
use AwesIO\Navigator\NavigatorServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // $this->withFactories(__DIR__ . '/../database/factories');
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // $app['config']->set('app.debug', env('APP_DEBUG', true));

        // $this->setUpDatabase($app);
    }

    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            NavigatorServiceProvider::class
        ];
    }
}