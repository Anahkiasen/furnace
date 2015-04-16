<?php
namespace Furnace\Providers\Kernel;

use Collective\Annotations\AnnotationsServiceProvider as ServiceProvider;

class AnnotationsServiceProvider extends ServiceProvider
{
    /**
     * The classes to scan for event annotations.
     *
     * @type array
     */
    protected $scanEvents = [];

    /**
     * The classes to scan for route annotations.
     *
     * @type array
     */
    protected $scanRoutes = [];

    /**
     * The classes to scan for model annotations.
     *
     * @type array
     */
    protected $scanModels = [];

    /**
     * Determines if we will auto-scan in the local environment.
     *
     * @type bool
     */
    protected $scanWhenLocal = true;

    /**
     * Determines whether or not to automatically scan the controllers
     * directory (App\Http\Controllers) for routes.
     *
     * @type bool
     */
    protected $scanControllers = true;

    /**
     * Determines whether or not to automatically scan all namespaced
     * classes for event, route, and model annotations.
     *
     * @type bool
     */
    protected $scanEverything = false;
}
