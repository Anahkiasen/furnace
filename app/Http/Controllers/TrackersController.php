<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Resource;
use Furnace\Entities\Models\Tracker;
use View;

/**
 * @Resource("trackers", only={"index"})
 * @Middleware("csrf")
 */
class TrackersController extends AbstractController
{
    /**
     * @return string
     */
    public function index()
    {
        $trackers = Tracker::has('tracks')->with('tracks.ratings')->get();
        $trackers = $trackers->sortByDesc('score');

        return View::make('trackers/index', [
            'trackers' => $trackers,
        ]);
    }
}
