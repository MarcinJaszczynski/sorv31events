<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignPurchaserToEventsTable extends Migration
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

            $table->dropForeign(['purchaser_id']);
            // $table->dropColumn('purchaser_id');
            $table->foreign('purchaser_id')->references('id')->on('contractors')->onUpdate('cascade')->onDelete('cascade');

            // $table->foreignId('purchaser_id')->constrained('contractors')->onUpdate('cascade')->onDelete('cascade');
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
