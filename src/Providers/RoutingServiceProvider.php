<?php
namespace Notetracker\Providers;

use League\Container\ServiceProvider;
use League\Route\RouteCollection;
use League\Route\Strategy\UriStrategy;

class RoutingServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
      'routes',
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->container->singleton('routes', function () {
            $routes = new RouteCollection($this->container);
            $routes->setStrategy(new UriStrategy());

            return $routes;
        });
    }
}
