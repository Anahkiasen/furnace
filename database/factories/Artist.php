<?php

use Furnace\Entities\Models\Artist;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;
use League\FactoryMuffin\Facade;

Facade::define(Artist::class, [
    'name' => 'word',
]);
