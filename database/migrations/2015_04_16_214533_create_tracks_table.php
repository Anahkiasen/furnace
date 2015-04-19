<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('artist')->nullable();
            $table->string('album')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('parts');
            $table->string('tuning');
            $table->string('version');
            $table->boolean('dd')->default(false);
            $table->boolean('riff_repeater')->default(false);
            $table->integer('difficulty_levels');
            $table->string('platforms');
            $table->integer('score')->default(0);
            $table->integer('ignition_id')->unsigned();
            $table->integer('tracker_id')->unsigned()->index()->nullable();
            $table->timestamps();

            $table->foreign('tracker_id')->references('id')->on('trackers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('tracks');
    }
}
