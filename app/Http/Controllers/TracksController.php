<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Resource;
use Furnace\Entities\Models\Track;
use Furnace\Services\Ignition;
use View;

/**
 * @Resource("tracks", only={"index", "show"})
 * @Middleware("csrf")
 */
class TracksController extends AbstractController
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
     * @Get("/", as="home")
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tracks = Track::with('tracker', 'ratings')->get();
        $tracks = $tracks->sortByDesc('score');

        return View::make('tracks/index', [
            'tracks' => $tracks,
        ]);
    }

    /**
     * @param Track $track
     *
     * @return \Illuminate\View\View
     */
    public function show(Track $track)
    {
        return View::make('tracks/show', [
            'track' => $track,
        ]);
    }
}
