<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPilotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_pilot', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('contractor_id')->constrained('contractors');
            $table->foreignId('event_id')->constrained('events');
            $table->string('note')->nullable();
            $table->dateTimeTz('start')->nullable();
            $table->dateTimeTz('end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_pilot');
    }
}
