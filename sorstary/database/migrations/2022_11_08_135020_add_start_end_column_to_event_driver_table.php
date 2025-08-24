<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartEndColumnToEventDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_driver', function (Blueprint $table) {
            //
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
        Schema::table('event_driver', function (Blueprint $table) {
            //
            $table->dropColumn('start', 'end');
        });
    }
}
