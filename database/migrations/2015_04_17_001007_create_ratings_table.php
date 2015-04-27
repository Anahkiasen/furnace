<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');

            // Experience
            $table->boolean('presilence')->default(false);
            $table->boolean('normalized_volume')->default(false);
            $table->boolean('playable')->default(false);

            // Audio
            $table->integer('tone')->default(0);
            $table->integer('audio')->default(0);

            // Gameplay
            $table->boolean('sync')->default(false);
            $table->boolean('techniques')->default(false);
            $table->integer('tab')->default(0);

            // Feedback
            $table->integer('difficulty')->default(0);
            $table->text('comments')->nullable();

            $table->float('total')->default(0);

            $table->string('version')->nullable();
            $table->integer('track_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->enum('platform', Config::get('furnace.platforms'))->default('pc');
            $table->timestamps();

            $table->foreign('track_id')->references('id')->on('tracks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('ratings');
    }
}
