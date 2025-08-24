<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNamesInEventContractorsTable extends Migration
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
            $table->renameColumn('id_event', 'event_id');
            $table->renameColumn('id_eventelement', 'eventelement_id');
            $table->renameColumn('id_contractor', 'contractor_id');
            $table->renameColumn('id_contractortype', 'contractortype_id');
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
