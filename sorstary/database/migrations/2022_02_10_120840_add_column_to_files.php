<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function (Blueprint $table) {
            //
            $table->string('fileName');
            $table->text('FileNote')->nullable();
            $table->string('filePilotSet');
            $table->string('fileHotelSet');
            $table->foreignId('eventId')->constrained('events')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            //
            $table->dropColumn('fileName', 'fileNote', 'filePilotSet', 'fileHotelSet', 'eventId');
        });
    }
}
