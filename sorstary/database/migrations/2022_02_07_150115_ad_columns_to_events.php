<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdColumnsToEvents extends Migration
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

            $table->dateTime('eventStartDateTime')->nullable();
            $table->dateTime('eventEndDateTime')->nullable();
            $table->text('eventStartDescription')->nullable();
            $table->text('eventEndDescription')->nullable();
            $table->text('eventDietAlert')->nullable();
            $table->integer('eventTotalQty')->nullable();
            $table->integer('eventGuardiansQty')->nullable();
            $table->integer('eventFreeQty')->nullable();
            $table->string('eventStatus')->nullable();


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
            $table->dropColumn('eventStartDateTime','eventEndDateTime','eventStartDescription','eventEndDescription','eventDietAlert','eventTotalQty','eventGuardiansQty','eventFreeQty','eventStatus');
        });
    }
}
