<?php

use Illuminate\Database\Schema\Blueprint;

/** @type Illuminate\Database\Schema\Builder $schema */
$schema->create('trackers', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->timestamps();
});
