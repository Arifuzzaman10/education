<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IsShowColumnToSmStudentRegistrationFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_student_registration_fields', function (Blueprint $table) {
            if(!Schema::hasColumn($table->getTable(), 'is_show')){
                $table->tinyInteger('is_show')->nullable()->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_student_registration_fields', function (Blueprint $table) {
            //
        });
    }
}
