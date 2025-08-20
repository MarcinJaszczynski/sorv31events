<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEventElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_elements', function (Blueprint $table) {

            $table->dateTime('eventElementStart')->nullable();
            $table->dateTime('eventElementEnd')->nullable();
            $table->float('eventElementCost')->nullable();
            $table->string('eventElementCostStatus')->nullable();
            $table->string('eventElementCostPayer')->nullable();
            $table->text('eventElementNote')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_elements', function (Blueprint $table) {

            $table->dropColumn('eventElementStart', 'eventElementEnd', 'eventElementCost', 'eventElementCostStatus', 'eventElementCostPayer', 'eventElementNote');

            //
        });
    }
}
