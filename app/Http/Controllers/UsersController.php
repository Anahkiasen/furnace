<?php
namespace Furnace\Http\Controllers;

use Auth;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Resource;
use Furnace\Commands\CreateUserCommand;
use Furnace\Entities\Models\User;
use Furnace\Http\Requests\CreateUserRequest;
use Redirect;
use View;

/**
 * @Resource("users")
 * @Middleware("csrf")
 */
class UsersController extends AbstractController
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('ratings')->get();
        $users->sortByDesc(function (User $user) {
            return $user->ratings->count();
        });

        return View::make('users/index', [
            'users' => $users,
        ]);
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

        return Redirect::home();
    }
}
