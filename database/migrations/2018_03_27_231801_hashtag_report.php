<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HashtagReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashtag_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hashtag');
            $table->integer('people');
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
            $table->string('top_joy')->nullable();
            $table->string('top_sad')->nullable();
            $table->string('top_ang')->nullable();
            $table->string('top_fear')->nullable();
            $table->string('top_ant')->nullable();
            $table->string('top_surp')->nullable();
            $table->string('top_disg')->nullable();
            $table->string('top_trust')->nullable();
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
        Schema::dropIfExists('hashtag_reports');
    }
}
