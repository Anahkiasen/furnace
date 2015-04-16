<?php
namespace Furnace\Http\Controllers;

use Furnace\Entities\Models\Tracker;
use Twig_Environment;

class TrackersController extends Controller
{
    /**
     * @type Twig_Environment
     */
    protected $view;

    /**
     * TrackersController constructor.
     *
     * @param Twig_Environment $view
     */
    public function __construct(Twig_Environment $view)
    {
        $this->view = $view;
    }

    /**
     * @return string
     */
    public function index()
    {
        $trackers = Tracker::with('tracks')->get();
        $trackers = $trackers->sortByDesc('rating');

        return $this->view->render('trackers/index.twig', [
            'trackers' => $trackers,
        ]);
    }
}
