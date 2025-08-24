<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignContractorToEventElementsTable extends Migration
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
            $table->foreign('contractor_id')
                ->references('id')->on('contractors')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();
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