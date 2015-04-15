<?php
namespace Notetracker;

use Illuminate\Database\Capsule\Manager;
use League\Container\ContainerInterface;
use League\Route\RouteCollection;
use Notetracker\Console\Console;
use Notetracker\Providers\CacheServiceProvider;
use Notetracker\Providers\ConsoleServiceProvider;
use Notetracker\Providers\DatabaseServiceProvider;
use Notetracker\Providers\ErrorsServiceProvider;
use Notetracker\Providers\IgnitionServiceProvider;
use Notetracker\Providers\PathsServiceProvider;
use Notetracker\Providers\RequestServiceProvider;
use Notetracker\Providers\RoutingServiceProvider;
use Notetracker\Providers\ViewServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Whoops\Run;

/**
 * @property RouteCollection routes
 * @property Request         request
 * @property Manager         db
 * @property Console         console
 */
class Application
{
    /**
     * @type ContainerInterface
     */
    protected $container;

    /**
     * @type array
     */
    protected $providers = [
        PathsServiceProvider::class,
        ErrorsServiceProvider::class,
        RequestServiceProvider::class,
        RoutingServiceProvider::class,
        ViewServiceProvider::class,
        DatabaseServiceProvider::class,
        ConsoleServiceProvider::class,
        IgnitionServiceProvider::class,
        CacheServiceProvider::class,
    ];

    /**
     * Application constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        foreach ($this->providers as $provider) {
            $this->container->addServiceProvider($provider);
        }

        $this->container->get(Run::class);
        $this->db;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->container->get($name);
    }

    /**
     * Run the application
     */
    public function run()
    {
        $dispatcher = $this->routes->getDispatcher();
        $response   = $dispatcher->dispatch($this->request->getMethod(), $this->request->getPathInfo());

        return $response->send();
    }
}
