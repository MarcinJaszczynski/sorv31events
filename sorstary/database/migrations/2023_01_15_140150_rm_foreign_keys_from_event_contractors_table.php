<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RmForeignKeysFromEventContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_elements', function (Blueprint $table) {
            //
            $table->renameColumn('eventIdinEventElements', 'rm_eventIdinEventElements');
            $table->renameColumn('last_change_user_id', 'rm_last_change_user_id');
            $table->renameColumn('contractor_id', 'rm_contractor_id');
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



        Schema::table('event_contractors', function (Blueprint $table) {


        });
    }
}