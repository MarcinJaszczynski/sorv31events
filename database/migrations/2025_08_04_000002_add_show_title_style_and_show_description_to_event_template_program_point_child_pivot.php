<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('event_template_program_point_child_pivot', function (Blueprint $table) {
            if (!Schema::hasColumn('event_template_program_point_child_pivot', 'show_title_style')) {
                $table->boolean('show_title_style')->default(true)->nullable()->after('active');
            }
            if (!Schema::hasColumn('event_template_program_point_child_pivot', 'show_description')) {
                $table->boolean('show_description')->default(true)->nullable()->after('show_title_style');
            }
        });
    }

    public function down()
    {
        Schema::table('event_template_program_point_child_pivot', function (Blueprint $table) {
            $table->dropColumn(['show_title_style', 'show_description']);
        });
    }
};
