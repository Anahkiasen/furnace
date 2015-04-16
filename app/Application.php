<?php
namespace Furnace;

use Illuminate\Database\Capsule\Manager;
use League\Container\ContainerAwareTrait;
use League\Container\ContainerInterface;
use League\Route\RouteCollection;
use Furnace\Console\Console;
use Furnace\Providers\CacheServiceProvider;
use Furnace\Providers\ConsoleServiceProvider;
use Furnace\Providers\DatabaseServiceProvider;
use Furnace\Providers\ErrorsServiceProvider;
use Furnace\Providers\IgnitionServiceProvider;
use Furnace\Providers\PathsServiceProvider;
use Furnace\Providers\RequestServiceProvider;
use Furnace\Providers\RoutingServiceProvider;
use Furnace\Providers\ViewServiceProvider;
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
    use ContainerAwareTrait;

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
     * Run the application.
     */
    public function run()
    {
        $dispatcher = $this->routes->getDispatcher();
        $response   = $dispatcher->dispatch($this->request->getMethod(), $this->request->getPathInfo());

        return $response->send();
    }
}
