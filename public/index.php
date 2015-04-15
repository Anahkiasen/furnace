<?php
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use League\Container\Container;
use Notetracker\Application;
use Notetracker\Controllers\TrackersController;
use Notetracker\Controllers\TracksController;

require __DIR__.'/../vendor/autoload.php';

$container = new Container();
$app       = new Application($container);

// Routes
//////////////////////////////////////////////////////////////////////

$app->routes->get('/', TracksController::class.'::index');
$app->routes->get('/trackers', TrackersController::class.'::index');

// Runtime
//////////////////////////////////////////////////////////////////////

$app->run();
