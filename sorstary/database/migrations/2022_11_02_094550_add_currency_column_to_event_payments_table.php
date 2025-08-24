<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyColumnToEventPaymentsTable extends Migration
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
            $table->boolean('advance')->default(0);
            $table->integer('plannedQty')->default(1);
            $table->float('plannedPrice', 8, 2)->default(0);
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
            $table->dropColumn(['advance', 'plannedQty', 'plannedPrice']);
        });
    }
}
