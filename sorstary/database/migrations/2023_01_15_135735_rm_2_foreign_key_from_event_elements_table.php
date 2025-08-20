<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rm2ForeignKeyFromEventElementsTable extends Migration
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
            Schema::table(
                'event_elements',
                function (Blueprint $table) {
                    //
                    $table->dropForeign(['last_change_user_id']);
                    $table->dropForeign(['eventIdinEventElements']);

                }
            );
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