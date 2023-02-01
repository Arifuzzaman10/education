<?php

use App\Models\SmStudentRegistrationField;
use App\SmSchool;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSystemRequiredToSmStudentRegistrationFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_student_registration_fields', function (Blueprint $table) {
            if (!Schema::hasColumn('sm_student_registration_fields', 'is_system_required')) {
                $table->tinyInteger('is_system_required')->nullable()->default('0');
            }
        });
        $required_fields = ['session', 'class', 'section', 'first_name', 'last_name', 'gender', 'date_of_birth', 'relation', 'guardians_email'];

        $all_schools = SmSchool::get();
        foreach ($all_schools as $school) {
            SmStudentRegistrationField::where('school_id', $school->id)->whereIn('field_name', $required_fields)->update(['is_required' => 1, 'is_system_required' => 1]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
