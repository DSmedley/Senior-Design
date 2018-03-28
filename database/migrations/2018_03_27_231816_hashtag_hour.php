<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HashtagHour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashtag_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hashtag_id')->unsigned();
            $table->foreign('hashtag_id')->references('id')->on('hashtag_reports');
            $table->integer('hour');
            $table->integer('occurs');
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
        Schema::dropIfExists('hashtag_hours');
    }
}
