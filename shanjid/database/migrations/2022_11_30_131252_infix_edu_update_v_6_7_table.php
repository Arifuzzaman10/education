<?php

use App\SmSchool;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\SmStudentRegistrationField;
use Illuminate\Database\Migrations\Migration;

class InfixEduUpdateV67Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_classes', function (Blueprint $table) {
            if (!Schema::hasColumn('sm_classes', 'pass_mark')) {
                $table->float('pass_mark')->nullable()->default(0.00);
            }
        });
        Schema::table('sm_student_registration_fields', function (Blueprint $table) {
            if (!Schema::hasColumn('sm_student_registration_fields', 'is_show')) {
                $table->tinyInteger('is_show')->after('label_name')->nullable()->default(1);
            }
        });
        Schema::table('sm_general_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('sm_general_settings', 'with_guardian')) {
                $table->boolean('with_guardian')->default(1);
            }
        });

        try {

            
        } catch (\Throwable $th) {
            Log::info($th);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
