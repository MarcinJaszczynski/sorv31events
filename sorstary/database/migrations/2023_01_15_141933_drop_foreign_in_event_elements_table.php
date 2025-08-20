<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignInEventElementsTable extends Migration
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

            $table->renameColumn('rm_eventIdinEventElements', 'eventIdinEventElements');
            $table->renameColumn('rm_last_change_user_id', 'last_change_user_id');
            $table->renameColumn('rm_contractor_id', 'contractor_id');

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
        });
    }
}