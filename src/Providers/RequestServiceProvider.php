<?php
namespace Notetracker\Providers;

use League\Container\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
      'request',
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
        $this->container->singleton('request', function () {
           return Request::createFromGlobals();
        });
    }
}
