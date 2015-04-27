<?php

use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Version;
use League\FactoryMuffin\Facade;

Facade::define(Version::class, [
    'name'     => 'word',
    'track_id' => 'factory|'.Track::class,
]);
