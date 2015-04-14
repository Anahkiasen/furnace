<?php
namespace Notetracker\Controllers;

use GuzzleHttp\Client;
use Notetracker\Models\Track;
use Twig_Environment;

class HomeController
{
    /**
     * @type Twig_Environment
     */
    protected $view;

    /**
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
        $tracks = Track::with('tracker')->get();
        $tracks = $tracks->sortByDesc('rating');

        return $this->view->render('home.twig', [
            'tracks' => $tracks,
        ]);
    }
}
