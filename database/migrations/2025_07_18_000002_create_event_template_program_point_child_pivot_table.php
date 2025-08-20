<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_template_program_point_child_pivot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_template_id');
            $table->unsignedBigInteger('program_point_child_id');
            $table->boolean('include_in_program')->default(true);
            $table->boolean('include_in_calculation')->default(true);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('event_template_id')->references('id')->on('event_templates')->onDelete('cascade');
            $table->foreign('program_point_child_id')->references('id')->on('event_template_program_points')->onDelete('cascade');
            $table->unique(['event_template_id', 'program_point_child_id'], 'et_child_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_template_program_point_child_pivot');
    }
};
