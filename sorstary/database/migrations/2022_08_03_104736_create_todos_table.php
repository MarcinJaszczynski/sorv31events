<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('deadline')->nullable();
            $table->string('name', 200);
            $table->text('description')->nullable();
            $table->foreignId('principal_id')->constrained('users');
            $table->foreignId('event_id')->constrained('events')->nullable();
            $table->foreignId('parent_todo_id')->constrained('todos')->nullable();
            // $table->foreignId('status_id')->constrained('todo_statuses')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
