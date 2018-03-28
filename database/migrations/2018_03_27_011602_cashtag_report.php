<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashtagReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashtag_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cashtag');
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
            $table->text('top_joy')->nullable();
            $table->text('top_sad')->nullable();
            $table->text('top_ang')->nullable();
            $table->text('top_fear')->nullable();
            $table->text('top_ant')->nullable();
            $table->text('top_surp')->nullable();
            $table->text('top_disg')->nullable();
            $table->text('top_trust')->nullable();
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
        Schema::dropIfExists('cashtag_reports');
    }
}
