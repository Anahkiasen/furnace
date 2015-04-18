<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Resource;
use View;

/**
 * @Resource("favorites")
 * @Middleware("csrf")
 * @Middleware("auth")
 */
class FavoritesController extends AbstractController
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return View::make('favorites/index');
    }
}
