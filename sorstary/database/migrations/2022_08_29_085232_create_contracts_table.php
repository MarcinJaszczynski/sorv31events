<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('event_id')->constrained('events');
            $table->string('contractor_first_name', 80);
            $table->string('contractor_last_name', 80);
            $table->string('contractor_email');
            $table->string('contractor_contact_phone', 80);
            $table->string('tour_participant_first_name', 80);
            $table->string('tour_participant_last_name', 80);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
