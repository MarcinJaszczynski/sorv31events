<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyTableToCurrenciesTable extends Migration
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
            $table->foreignId('currency_id')->nullable()->constrained('currencies');
            $table->float('exchange_rate', 8, 2)->default(1.0);
            $table->foreignId('planned_currency_id')->nullable()->constrained('currencies');
            $table->float('planned_exchange_rate', 8, 2)->default(1.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currencies', function (Blueprint $table) {
            //
            $table->dropForeign(['currency_id', 'planned_currency_id']);
            $table->dropColumn(['currency_id', 'exchange_rate', 'planned_currency_id', 'planned_exchange_rate']);
        });
    }
}
