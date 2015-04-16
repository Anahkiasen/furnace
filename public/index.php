<?php
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use League\Container\Container;
use League\Csv\Reader;
use Notetracker\Application;
use Notetracker\Controllers\TrackersController;
use Notetracker\Controllers\TracksController;
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../vendor/autoload.php';

$container = new Container();
$app       = new Application($container);

// Routes
//////////////////////////////////////////////////////////////////////

$app->routes->get('/', TracksController::class.'::index');
$app->routes->post('/tracks', TracksController::class.'::store');

$app->routes->get('/trackers', TrackersController::class.'::index');

// Runtime
//////////////////////////////////////////////////////////////////////

$app->run();
