<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEventElement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_elements', function (Blueprint $table) {

            $table->integer('eventElementCostQty');
            $table->text('eventElementCostNote')->nullable();
            $table->text('eventElementContact')->nullable();
            $table->text('eventElementReservation')->nullable();

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
            //
            $table->dropColumn('eventElementCostQty','eventElementCostNote','eventElementContact','eventElementReservation');
        });
    }
}
