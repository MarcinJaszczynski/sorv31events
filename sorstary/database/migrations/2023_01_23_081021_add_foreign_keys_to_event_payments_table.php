<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEventPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('event_payments', function (Blueprint $table) {
            //

            $table->foreign('contractor_id')
                ->nullable()
                ->references('id')->on('contractors')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();

            $table->foreign('element_id')
                ->nullable()
                ->references('id')->on('event_elements')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();

            $table->foreign('paymenttype_id')
                ->nullable()
                ->references('id')->on('payment_types')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->change();
        });

        Schema::enableForeignKeyConstraints();
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