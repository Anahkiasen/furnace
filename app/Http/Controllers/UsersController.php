<?php
namespace Furnace\Http\Controllers;

use Auth;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Collective\Annotations\Routing\Annotations\Annotations\Resource;
use Furnace\Commands\CreateUserCommand;
use Furnace\Http\Requests\CreateUserRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Redirect;
use URL;
use View;

/**
 * @Resource("users")
 */
class UsersController extends AbstractController
{
    /**
     * @Get("users/login", as="users.login")
     * @Middleware("guest")
     */
    public function login()
    {
        return View::make('users/login');
    }

    /**
     * @Post("users/login")
     * @param Request $request
     * @param Guard   $auth
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request, Guard $auth)
    {
        $credentials = $request->only('name', 'password');
        if (!$auth->attempt($credentials)) {
            return Redirect::back()->with('error', true);
        }

        return Redirect::intended(URL::route('home'));
    }

    /**
     * @Middleware("guest")
     *
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
