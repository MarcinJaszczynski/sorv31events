<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('hotelName');
            $table->string('hotelStreet');
            $table->string('hotelCity');
            $table->string('hotelRegion');
            $table->string('hotelContact')->nullable();
            $table->string('hotelPhone')->nullable();
            $table->string('hotelEmail')->nullable();
            $table->text('hotelNote')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
