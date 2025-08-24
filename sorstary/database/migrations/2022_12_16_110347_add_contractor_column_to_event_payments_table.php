<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContractorColumnToEventPaymentsTable extends Migration
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
            $table->foreignId('element_id')->nullable()->onstrained('event_elements')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('contractor_id')->nullable()->onstrained('contractors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('paymenttype_id')->nullable()->onstrained('payment_types')->onUpdate('cascade')->onDelete('cascade');
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
