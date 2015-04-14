<?php
use League\Container\Container;
use Notetracker\Application;
use Notetracker\Controllers\TracksController;
use Notetracker\Controllers\TrackersController;

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
