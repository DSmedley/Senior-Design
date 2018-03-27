<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashtagHour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashtag_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cashtag_id')->unsigned();
            $table->foreign('cashtag_id')->references('id')->on('cashtag_reports');
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
        Schema::dropIfExists('cashtag_hours');
    }
}
