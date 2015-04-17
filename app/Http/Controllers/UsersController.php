<?php
namespace Furnace\Http\Controllers;

use Auth;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Resource;
use Furnace\Commands\CreateUserCommand;
use Furnace\Http\Requests\CreateUserRequest;
use Redirect;
use View;

/**
 * @Resource("users")
 */
class UsersController extends AbstractController
{
    /**
     * @Middleware("guest")
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return View::make('users/create');
    }

    /**
     * @param CreateUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->dispatchFrom(CreateUserCommand::class, $request);
        Auth::login($user);

        return Redirect::action('TracksController@index');
    }
}
