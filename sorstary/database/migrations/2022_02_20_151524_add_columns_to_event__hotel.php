<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEventHotel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_hotel', function (Blueprint $table) {
            //
            $table->dateTime('eventHotelStartDate')->nullable();
            $table->dateTime('eventHotelEndDate')->nullable();
            $table->text('eventHotelRooms')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_hotel', function (Blueprint $table) {
            //
            $table->dropColumn('eventHotelStartDate',
            'eventHotelEndDate',
            'eventHotelRooms');

        });
    }
}
