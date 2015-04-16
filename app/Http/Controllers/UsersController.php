<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use View;

class UsersController extends AbstractController
{
    /**
     * @Get("users/signup")
     *
     * @return \Illuminate\View\View
     */
    public function signup()
    {
        return View::make('users/create');
    }
}
