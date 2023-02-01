<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClassSectionRecordIdToSmSubjectAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_subject_attendances', function (Blueprint $table) {
            $table->bigInteger('student_record_id')->nullable()->unsigned();
            $table->foreign('student_record_id')->references('id')->on('student_records')->onDelete('cascade');

            $table->integer('class_id')->nullable()->unsigned();
            $table->foreign('class_id')->references('id')->on('sm_classes')->onDelete('cascade');

            $table->integer('section_id')->nullable()->unsigned();
            $table->foreign('section_id')->references('id')->on('sm_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_subject_attendances', function (Blueprint $table) {
            $table->dropColumn('student_record_id');
            $table->dropColumn('class_id');
            $table->dropColumn('section_id');
        });
    }
}
