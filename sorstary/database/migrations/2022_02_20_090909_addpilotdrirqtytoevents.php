<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Addpilotdrirqtytoevents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('events', function (Blueprint $table) {
            //

            $table->string('eventPilotName')->nullable();
            $table->string('eventPilotContact')->nullable();
            $table->string('eventDriverName')->nullable();
            $table->string('eventDriverContact')->nullable();
            $table->integer('eventAdvancePayment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('events', function (Blueprint $table) {
            //

            $table->dropColumn('eventPilotName','eventPilotContact','eventDriverName','eventDriverContact','eventAdvancePayment');
        });
    }
}
