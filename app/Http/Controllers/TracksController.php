<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Furnace\Entities\Models\Track;
use Furnace\Services\Ignition;
use Redirect;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Twig_Environment;
use View;

class TracksController extends Controller
{
    /**
     * @type Request
     */
    private $request;
    /**
     * @type Ignition
     */
    private $ignition;

    /**
     * @param Ignition $ignition
     * @param Request  $request
     */
    public function __construct(Ignition $ignition, Request $request)
    {
        $this->request  = $request;
        $this->ignition = $ignition;
    }

    /**
     * @Get("/")
     *
     * @return string
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
     * Store a track.
     */
    public function store()
    {
        $attributes = $this->request->request->all();
        $attributes = $this->ignition->complete($attributes);
        $track      = Track::create($attributes);

        return Redirect::action(static::class.'@index');
    }
}
