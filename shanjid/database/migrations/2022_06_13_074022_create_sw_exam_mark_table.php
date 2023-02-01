<?php

use App\SmGeneralSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwExamMarkTable extends Migration
{
    public function up()
    {
        $settingsColumn = 'result_type';
        Schema::table('sm_general_settings', function (Blueprint $table)use($settingsColumn) {
            if (!Schema::hasColumn('sm_general_settings', $settingsColumn)) {
                $table->string($settingsColumn)->nullable();
            }
        });
        
        $pass_mark = 'pass_mark';

        Schema::table('sm_subjects', function (Blueprint $table)use($pass_mark) {
            if (!Schema::hasColumn('sm_subjects', $pass_mark)) {
                $table->float($pass_mark)->nullable();
            }
        });

        Schema::table('sm_exams', function (Blueprint $table)use($pass_mark) {
            if (!Schema::hasColumn('sm_exams', $pass_mark)) {
                $table->float($pass_mark)->nullable();
            }
        });

        Schema::table('sm_classes', function (Blueprint $table)use($pass_mark) {
            if (!Schema::hasColumn('sm_classes', $pass_mark)) {
                $table->float($pass_mark)->nullable();
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('sw_exam_mark');
    }
}
