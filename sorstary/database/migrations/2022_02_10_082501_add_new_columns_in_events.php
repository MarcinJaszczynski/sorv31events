<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsInEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            //
                $table->text('eventPurchaserName')->nullable();
                $table->text('eventPurchaserStreet')->nullable();
                $table->text('eventPurchaserCity')->nullable();
                $table->text('eventPurchaserNip')->nullable();
                $table->text('eventPurchaserContactPerson')->nullable();
                $table->text('eventPurchaserTel')->nullable();           
                $table->text('eventPurchaserEmail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            //
            $table->dropColumn('eventPurchaserName','eventPurchaserStreet','eventPurchaserCity','eventPurchaserNip','eventPurchaserContactPerson','eventPurchaserTel','eventPurchaserEmail');
        });
    }
}
