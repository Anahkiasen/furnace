<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Resource;
use Furnace\Commands\UpsertRatingCommand;
use Furnace\Entities\Models\Rating;
use Furnace\Http\Requests\UpsertRating;
use Illuminate\Contracts\Auth\Authenticatable;
use Redirect;
use View;

/**
 * @Resource("ratings")
 * @Middleware("auth")
 */
class RatingsController extends AbstractController
{
    /**
     * @param Authenticatable $user
     *
     * @return \Illuminate\View\View
     */
    public function index(Authenticatable $user)
    {
        $ratings = $user->ratings->load('track.tracker');

        return View::make('ratings/index', [
            'ratings' => $ratings,
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return View::make('ratings/edit');
    }

    /**
     * @param UpsertRating    $request
     * @param Authenticatable $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UpsertRating $request, Authenticatable $user)
    {
        $this->dispatchFromArray(UpsertRatingCommand::class, [
            'user'       => $user,
            'attributes' => $request->only([
                'track_id',
                'ignition_id',
                'presilence',
                'normalized_volume',
                'playable',
                'tone',
                'audio',
                'tab',
                'comments',
            ]),
        ]);

        return Redirect::route('ratings.index');
    }

    /**
     * @param Rating $rating
     *
     * @return \Illuminate\View\View
     */
    public function edit(Rating $rating)
    {
        return View::make('ratings/edit', [
            'rating' => $rating,
        ]);
    }

    /**
     * @param Rating          $rating
     * @param UpsertRating    $request
     * @param Authenticatable $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Rating $rating, UpsertRating $request, Authenticatable $user)
    {
        $this->dispatchFromArray(UpsertRatingCommand::class, [
            'user'       => $user,
            'rating'     => $rating,
            'attributes' => $request->only([
                'track_id',
                'ignition_id',
                'presilence',
                'normalized_volume',
                'playable',
                'tone',
                'audio',
                'tab',
                'comments',
            ]),
        ]);

        return Redirect::route('ratings.index');
    }
}
