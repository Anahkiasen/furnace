<?php
namespace Furnace\Providers\Kernel;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     * In addition, it is set as the URL generator's root namespace.
     *
     * @type string
     */
    protected $namespace = 'Furnace\Http\Controllers';

    public function map()
    {

    }
}
