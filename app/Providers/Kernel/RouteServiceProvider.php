<?php
namespace Furnace\Providers\Kernel;

use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     * In addition, it is set as the URL generator's root namespace.
     *
     * @type string
     */
    protected $namespace = 'Furnace\Http\Controllers';

    /**
     * Bootstrap any application services.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('tracks', Track::class.'@findBySlug');
        $router->bind('users', User::class.'@findBySlug');
    }

    public function map()
    {
    }
}
