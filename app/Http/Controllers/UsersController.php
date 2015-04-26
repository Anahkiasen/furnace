<?php
namespace Furnace\Http\Controllers;

use Auth;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Resource;
use Furnace\Commands\CreateUserCommand;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\User;
use Furnace\Http\Requests\CreateUserRequest;
use Furnace\Services\Search\Queries\SimilarTracksQuery;
use Illuminate\Contracts\Auth\Authenticatable;
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
     * @Get("users/recommendations", as="users.recommendations")
     * @param Authenticatable $user
     *
     * @return \Illuminate\View\View
     */
    public function recommendations(Authenticatable $user)
    {
        // Get highest rated tracks of user
        $tracks = $user->ratings->lists('track_id');
        $tracks = Track::limit(5)->find($tracks);

        // Get most similar tracks
        $recommendations = [];
        if ($tracks->count()) {
            $recommendations = $this->executeQuery(SimilarTracksQuery::class, [
               'tracks' => $tracks->lists('id'),
            ]);
        }

        return View::make('users/recommendations', [
            'tracks' => $recommendations,
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

    /**
     * @param User $user
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return View::make('users/show', [
           'user' => $user,
        ]);
    }
}
