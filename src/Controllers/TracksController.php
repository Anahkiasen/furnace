<?php
namespace Notetracker\Controllers;

use Notetracker\Entities\Models\Track;
use Notetracker\Services\Ignition;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Twig_Environment;

class TracksController
{
    /**
     * @type Twig_Environment
     */
    protected $view;

    /**
     * @type Request
     */
    private $request;
    /**
     * @type Ignition
     */
    private $ignition;

    /**
     * @param Twig_Environment $view
     * @param Request          $request
     */
    public function __construct(Twig_Environment $view, Ignition $ignition, Request $request)
    {
        $this->view    = $view;
        $this->request = $request;
        $this->ignition = $ignition;
    }

    /**
     * @return string
     */
    public function index()
    {
        $tracks             = Track::with('tracker')->get();
        $tracks             = $tracks->sortByDesc('rating');
        Track::$ratingScale = $tracks->max('rating');

        return $this->view->render('tracks/index.twig', [
            'tracks'       => $tracks,
            'rating_scale' => Track::$ratingScale,
        ]);
    }

    /**
     * Store a track
     */
    public function store()
    {
        $attributes = $this->request->request->all();
        $attributes = $this->ignition->complete($attributes);
        $track      = Track::create($attributes);

        return new RedirectResponse('/');
    }
}
