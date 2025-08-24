<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignKeyInEventElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_contractors', function (Blueprint $table) {
            //
            $table->dropForeign(['event_id'], ['eventelement_id'], ['contractor_id'], ['contractortype_id']);
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
            //
        });
    }
}
