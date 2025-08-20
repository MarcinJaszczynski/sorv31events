<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFileTbleName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Schema::table('files', function (Blueprint $table) {
        //     $table->dropForeign(['eventId']);
        //  });
        
         Schema::rename('files', 'eventfiles');
        
        //  Schema::table('eventfiles', function (Blueprint $table) {
        //     $table->foreign('eventId')->references('id')->on('events');
        //  });

 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
