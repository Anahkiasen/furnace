<?php

Route::get('/', 'TracksController@index');
Route::post('tracks', 'TracksController@store');

Route::get('trackers', 'TrackersController@index');
