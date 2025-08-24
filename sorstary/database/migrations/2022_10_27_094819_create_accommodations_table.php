<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            //
            $table->foreignId('event_id')->nullable()->constrained('events');
            $table->foreignId('hotel_id')->nullable()->constrained('contractors');
            $table->foreignId('author_id')->nullable()->constrained('users');
            $table->dateTime('accomodationStart')->nullable();
            $table->dateTime('accomodoationEnd')->nullable();
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
        Schema::dropIfExists('accommodations');
    }
}
