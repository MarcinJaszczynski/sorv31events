<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignInFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventfiles', function (Blueprint $table) {
            Schema::table('eventfiles', function (Blueprint $table) {
                $table->foreign('eventId')->references('id')->on('events');
             });
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
        Schema::table('eventfiles', function (Blueprint $table) {
            //
        });
    }
}
