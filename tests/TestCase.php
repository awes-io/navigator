<?php

namespace AwesIO\Navigator\Tests;

use Illuminate\Support\Facades\Route;
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
        $app['config']->set('app.debug', env('APP_DEBUG', true));

        $app['config']->set(
            'navigator.tests', 
            require dirname(dirname(__FILE__)) . '/tests/Stubs/navigation.php'
        );

        $this->setUpRoutes();

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

    protected function setUpRoutes(Type $var = null)
    {
        Route::get('/', function() {})->name('test');

        Route::get('/protected', function() {})->middleware('can:view')->name('protected');
    }
}