<?php

use Furnace\Entities\Models\Tracker;
use League\FactoryMuffin\Facade;

Facade::define(Tracker::class, [
    'name'  => 'word',
    'score' => 'randomNumber|2',
]);
