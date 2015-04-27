<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Resource;
use Debugbar;
use Furnace\Commands\Ratings\ExportRatingsCommand;
use Furnace\Commands\UpsertRatingCommand;
use Furnace\Entities\Models\Rating;
use Furnace\Http\Requests\UpsertRating;
use Illuminate\Contracts\Auth\Authenticatable;
use Redirect;
use Response;
use View;

/**
 * @Resource("ratings")
 * @Middleware("auth")
 * @Middleware("csrf")
 */
class RatingsController extends AbstractController
{
    /**
     * @type array
     */
    protected $keys = [
        'ignition_id',
        'presilence',
        'normalized_volume',
        'playable',
        'sync',
        'techniques',
        'difficulty',
        'tone',
        'audio',
        'tab',
        'platform',
        'comments',
    ];

    /**
     * @param Authenticatable $user
     *
     * @return \Illuminate\View\View
     */
    public function index(Authenticatable $user)
    {
        $ratings = $user->ratings->load('track.tracker', 'track.artist');

        return View::make('ratings/index', [
            'ratings' => $ratings,
        ]);
    }

    /**
     * Export ratings to a file
     * @Get("ratings/export", as="ratings.export")
     *
     * @param Authenticatable $user
     *
     * @return int
     */
    public function export(Authenticatable $user)
    {
        Debugbar::disable();

        $file = $this->dispatchFromArray(ExportRatingsCommand::class, [
            'ratings' => $user->ratings,
        ]);

        return $file->output('ratings.csv');
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
            'attributes' => $request->only($this->keys),
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
            'attributes' => $request->only($this->keys),
        ]);

        return Redirect::route('ratings.index');
    }

    /**
     * @param Rating $rating
     *
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();

        return Response::make([], 204);
    }
}
