<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CashtagPeople extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashtag_people', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cashtag_id')->unsigned();
            $table->foreign('cashtag_id')->references('id')->on('cashtag_reports');
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
        Schema::dropIfExists('cashtag_people');
    }
}
