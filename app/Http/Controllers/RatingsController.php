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
     * @param UpsertRating $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UpsertRating $request)
    {
        $this->dispatchFromArray(UpsertRatingCommand::class, [
            'attributes' => $request->only([
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
     * @param Rating       $rating
     * @param UpsertRating $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Rating $rating, UpsertRating $request)
    {
        $this->dispatchFromArray(UpsertRatingCommand::class, [
            'rating'     => $rating,
            'attributes' => $request->only([
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
