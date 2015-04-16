<?php
namespace Furnace\Providers;

use League\Container\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        Request::class,
        'request',
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->singleton(Request::class, function () {
            return Request::createFromGlobals();
        });

        $this->container->singleton('request', function () {
            return $this->container->get(Request::class);
        });
    }
}
