<?php
use League\Container\Container;
use Notetracker\Application;
use Notetracker\Controllers\HomeController;

require __DIR__.'/../vendor/autoload.php';

$container = new Container();
$app       = new Application($container);

// Routes
//////////////////////////////////////////////////////////////////////

$app->routes->get('/', HomeController::class.'::index');

// Runtime
//////////////////////////////////////////////////////////////////////

$app->run();
