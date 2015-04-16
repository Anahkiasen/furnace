<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Furnace\Entities\Models\Track;
use Furnace\Services\Ignition;
use Illuminate\Http\Request;
use Redirect;
use View;

class TracksController extends Controller
{
    /**
     * @type Ignition
     */
    private $ignition;

    /**
     * @param Ignition $ignition
     */
    public function __construct(Ignition $ignition)
    {
        $this->ignition = $ignition;
    }

    /**
     * @Get("/")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tracks             = Track::with('tracker')->get();
        $tracks             = $tracks->sortByDesc('rating');
        Track::$ratingScale = $tracks->max('rating');

        return View::make('tracks/index', [
            'tracks'       => $tracks,
            'rating_scale' => Track::$ratingScale,
        ]);
    }

    /**
     * @Post("/")
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $attributes = $request->all();
        $attributes = $this->ignition->complete($attributes);
        $track      = Track::create($attributes);

        return Redirect::action(static::class.'@index');
    }
}
