<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_contractors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('event_id')->nullable()->constrained('events');
            $table->foreignId('eventelement_id')->nullable()->constrained('event_elements');
            $table->foreignId('contractor_id')->nullable()->constrained('contractors');
            $table->foreignId('contractortype_id')->nullable()->constrained('contractor_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_contractors');
    }
}
