<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EventPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('event_payment', function (Blueprint $table) {
            $table->string('paymentName');
            $table->text('paymentDescription');
            $table->bigInteger('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('payer', ['biuro', 'pilot'])->default('biuro');
            $table->boolean('paymentStatus')->default(false);
            $table->text('invoice')->nullable();
            $table->date('paymentDate')->nullable();
            $table->integer('qty')->default(1);
            $table->float('price', 8,2)->default(0);
            $table->text('paymentNote')->nullable();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('event_payment');

    }
}
