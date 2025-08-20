<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorContatctTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_contact', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('contractor_id')->constrained('contractors');
            $table->foreignId('contact_id')->constrained('contacts');
            $table->string('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contractor_contact');
    }
}
