<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToEventElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $table->renameColumn('rm_eventIdinEventElements', 'eventIdinEventElements');
        // $table->renameColumn('rm_last_change_user_id', 'last_change_user_id');
        // $table->renameColumn('rm_contractor_id', 'contractor_id');

        Schema::table('event_elements', function (Blueprint $table) {

            $table->foreign('eventIdinEventElements')
                ->references('id')->on('events')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();
            $table->foreign('last_change_user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();
            // $table->foreign('contractor_id')
            //     ->references('id')->on('contractors')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade')
            //     ->change();
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