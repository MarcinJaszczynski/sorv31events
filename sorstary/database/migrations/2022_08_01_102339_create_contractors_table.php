<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 200);
            $table->string('street', 200)->nullable();
            $table->string('city', 200)->nullable();
            $table->string('region', 200)->nullable();
            $table->string('country', 200)->nullable();
            $table->integer('nip')->nullable();
            $table->integer('phone')->nullable();
            $table->string('email', 200)->nullable();
            $table->string('www', 200)->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contractors');
    }
}
