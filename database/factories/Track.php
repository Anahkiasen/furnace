<?php

use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;
use League\FactoryMuffin\Facade;

Facade::define(Track::class, [
    'artist'            => 'word',
    'album'             => 'word',
    'name'              => 'word',
    'parts'             => 'lead',
    'platforms'         => 'pc,mac',
    'tuning'            => 'estandard',
    'version'           => '1.0',
    'dd'                => 'boolean',
    'riff_repeater'     => 'boolean',
    'difficulty_levels' => 'numberNumber|1',
    'score'             => 'randomNumber|2',
    'ignition_id'       => 'randomNumber|5',
    'tracker_id'        => 'factory|'.Tracker::class,
]);
