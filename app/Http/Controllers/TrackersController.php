<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Furnace\Entities\Models\Tracker;
use View;

class TrackersController extends Controller
{
    /**
     * @Get("trackers")
     * @return string
     */
    public function index()
    {
        $trackers = Tracker::with('tracks')->get();
        $trackers = $trackers->sortByDesc('rating');

        return View::make('trackers/index', [
            'trackers' => $trackers,
        ]);
    }
}
