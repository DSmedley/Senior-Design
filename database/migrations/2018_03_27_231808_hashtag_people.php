<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HashtagPeople extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashtag_people', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hashtag_id')->unsigned();
            $table->foreign('hashtag_id')->references('id')->on('hashtag_reports');
            $table->string('screen_name');
            $table->integer('occurs');
            $table->string('profile_image');
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
        Schema::dropIfExists('hashtag_people');
    }
}
