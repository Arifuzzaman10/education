<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLessonPlanSubtopicToGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_general_settings', function (Blueprint $table) {
            if(!Schema::hasColumn($table->getTable(), 'sub_topic_enable')){
                $table->boolean('sub_topic_enable')->default(true);
            }
        });

        $sql = ("INSERT INTO `infix_module_infos` (`id`, `module_id`, `parent_id`, `type`, `is_saas`, `name`, `route`, `lang_name`, `icon_class`, `active_status`, `created_by`, `updated_by`, `school_id`, `created_at`, `updated_at`) VALUES
        (835, 29, 800, '1', 0,'Lesson Plan Setting','lesson.lesson-planner.settomg','lesson_plan','',1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22');
         ");
        DB::insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_general_settings', function (Blueprint $table) {
            if(Schema::hasColumn($table->getTable(), 'sub_topic_enable')){
                $table->dropColumn('sub_topic_enable');
            }
        });

        \Modules\RolePermission\Entities\InfixModuleInfo::where('id', 835)->delete();
    }
}
