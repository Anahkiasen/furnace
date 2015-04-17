<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Resource;
use View;

/**
 * @Resource("ratings", only={"create"})
 * @Middleware("auth")
 */
class RatingsController extends AbstractController
{
    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return View::make('ratings/create');
    }
}
