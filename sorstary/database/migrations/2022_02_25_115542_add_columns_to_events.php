<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            //
            $table->text('eventPilotNotes')->nullable();
            $table->datetime('busBoardTime')->nullable();
            $table->text('eventPilotName')->change();
            $table->text('eventDriverName')->change();
            $table->renameColumn('eventPilotName', 'eventPilot');
            $table->renameColumn('eventDriverName', 'eventDriver');
            $table->dropColumn('eventPilotContact');
            $table->dropColumn('eventDriverContact');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
}
