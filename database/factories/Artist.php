<?php

use Furnace\Entities\Models\Artist;
use League\FactoryMuffin\Facade;

Facade::define(Artist::class, [
    'name' => 'word',
]);
