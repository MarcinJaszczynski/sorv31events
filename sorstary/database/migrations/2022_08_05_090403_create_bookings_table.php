<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 200);
            $table->datetime('booking_start');
            $table->datetime('booking_end');
            $table->date('confirmation_deadline')->nullable();
            $table->date('confirmation_date')->nullable();
            $table->date('cancelation_deadline')->nullable();
            $table->date('cancelation_date')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users');
            $table->foreignId('contractor_id')->nullable()->constrained('contractors');
            $table->foreignId('todo_id')->nullable()->constrained('todos');
            $table->foreignId('event_id')->nullable()->constrained('events');
            $table->foreignId('event_element_id')->nullable()->constrained('event_elements');
            $table->foreignId('note_id')->nullable()->constrained('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
