<?php

use Furnace\Entities\Models\Artist;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;
use League\FactoryMuffin\Facade;

Facade::define(Track::class, [
    'album'             => 'word',
    'name'              => 'word',
    'parts'             => 'lead',
    'platforms'         => 'pc,mac',
    'tuning'            => 'estandard',
    'dd'                => 'boolean',
    'riff_repeater'     => 'boolean',
    'difficulty_levels' => 'randomNumber|1',
    'score'             => 'randomNumber|2',
    'ignition_id'       => 'randomNumber|5',
    'artist_id'         => 'factory|'.Artist::class,
    'tracker_id'        => 'factory|'.Tracker::class,
]);
