<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractorTypeColumnToEventPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_payments', function (Blueprint $table) {
            //
            $table->foreignId('contractortype_id')
                ->nullable()
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
        Schema::table('event_payments', function (Blueprint $table) {
            //
        });
    }
}