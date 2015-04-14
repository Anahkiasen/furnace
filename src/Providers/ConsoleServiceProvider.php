<?php
namespace Notetracker\Providers;

use League\Container\ServiceProvider;
use Notetracker\Console\Console;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        'console',
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
        $this->container->singleton('console', function () {
            $console = new Console();
            $console->useContainer($this->container);

            return $console;
        });
    }
}
