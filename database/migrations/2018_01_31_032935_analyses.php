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
            $table->string('location');
            $table->string('profile_image');
            $table->mediumText('description');
            $table->bigInteger('tweets');
            $table->bigInteger('following');
            $table->bigInteger('followers');
            $table->bigInteger('likes');
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
