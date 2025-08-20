<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add4ForeignKeysToEventContractorsTable extends Migration
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
            $table->renameColumn('event_id', 'id_event');
            $table->renameColumn('eventelement_id', 'id_eventelement');
            $table->renameColumn('contractor_id', 'id_contractor');
            $table->renameColumn('contractortype_id', 'id_contractortype');


            $table->foreign('id_event')
                ->references('id')->on('events')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();
            $table->foreign('id_eventelement')
                ->references('id')->on('event_elements')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();
            $table->foreign('id_contractor')
                ->references('id')->on('contractors')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();
            $table->foreign('id_contractortype')
                ->references('id')->on('contractor_types')
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
        Schema::table('event_contractors', function (Blueprint $table) {
            //
        });
    }
}
