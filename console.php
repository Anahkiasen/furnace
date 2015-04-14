<?php
use League\Container\Container;
use Notetracker\Application;

require 'vendor/autoload.php';

$container = new Container();
$app       = new Application($container);

return $app->console->run();
