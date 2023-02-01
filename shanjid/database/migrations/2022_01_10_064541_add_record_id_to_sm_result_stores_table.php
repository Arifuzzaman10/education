<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecordIdToSmResultStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_result_stores', function (Blueprint $table) {
            $table->bigInteger('student_record_id')->nullable()->unsigned();
            $table->foreign('student_record_id')->references('id')->on('student_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_result_stores', function (Blueprint $table) {
            $table->dropColumn('student_record_id');
        });
    }
}
