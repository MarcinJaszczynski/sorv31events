<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnsToTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->foreignId('executor_id')->nullable()->constrained('users');
            $table->foreignId('status_id')->nullable()->constrained('todo_statuses');
            $table->foreignId('contractor_id')->nullable()->constrained('contractors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todos', function (Blueprint $table) {
            //
            $table->dropIfExists(['executor_id', 'status_id', 'contractor_id']);
        });
    }
}
