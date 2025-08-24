<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventHotelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_hotel', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('hotel_id')->unsigned();


            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');

            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->text('eventHotelNote');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_hotel');
    }
}
