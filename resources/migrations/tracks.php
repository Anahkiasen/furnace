<?php

use Illuminate\Database\Schema\Blueprint;

/** @type Illuminate\Database\Schema\Builder $schema */
$schema->create('tracks', function (Blueprint $table) {
    $table->increments('id');
    $table->string('artist')->nullable();
    $table->string('name')->nullable();
    $table->string('file');
    $table->integer('tone')->default(0);
    $table->integer('track')->default(0);
    $table->integer('tab')->default(0);
    $table->integer('tracker_id')->unsigned()->index()->nullable();
    $table->timestamps();

    $table->foreign('tracker_id')->references('id')->on('trackers');
});
