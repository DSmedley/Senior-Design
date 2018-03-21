<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Analyses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyses', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('twitter_id');
            $table->string('name');
            $table->string('screen_name');
            $table->string('location')->nullable();
            $table->string('profile_image');
            $table->boolean('verified');
            $table->string('joined');
            $table->string('time_zone')->nullable();
            $table->string('url')->nullable();
            $table->mediumText('description')->nullable();
            $table->bigInteger('tweets');
            $table->bigInteger('following');
            $table->bigInteger('followers');
            $table->bigInteger('likes');
            $table->integer('total');
            $table->integer('replies');
            $table->integer('mentions');
            $table->integer('hashtags');
            $table->integer('retweets');
            $table->integer('links');
            $table->integer('media');
            $table->integer('retweet_count');
            $table->integer('retweet_total');
            $table->integer('favorite_count');
            $table->integer('favorite_total');
            $table->integer('positive');
            $table->integer('negative');
            $table->integer('neutral');
            $table->integer('anger');
            $table->integer('anticipation');
            $table->integer('disgust');
            $table->integer('fear');
            $table->integer('joy');
            $table->integer('sadness');
            $table->integer('surprise');
            $table->integer('trust');
            $table->integer('none');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analyses');
    }
}
