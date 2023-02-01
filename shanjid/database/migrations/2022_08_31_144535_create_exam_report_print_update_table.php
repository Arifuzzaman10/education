<?php

use App\CustomResultSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\InfixModuleInfo;

class CreateExamReportPrintUpdateTable extends Migration
{
    public function up()
    {
        $dropColumn = "print_status";
        if (Schema::hasColumn('custom_result_settings', $dropColumn)) {
            Schema::table('custom_result_settings', function($table) use ($dropColumn) {
                $table->dropColumn($dropColumn);
            });
        }

        $columns =["profile_image", "header_background", "body_background"];
        foreach($columns as $column){
            if (!Schema::hasColumn('custom_result_settings', $column)) {
                Schema::table('custom_result_settings', function (Blueprint $table) use ($column) {
                    $table->string($column)->nullable();
                });
            }
        }

        $store = CustomResultSetting::find(1);
        if(!$store){
            $store = new CustomResultSetting();
            $store->merit_list_setting = 'total_mark';
            $store->print_status = "image";
        }
        $store->profile_image = "image";
        $store->header_background = "header";
        $store->body_background = "body";
        $store->save();

        $permission = InfixModuleInfo::find(5000);
        if(!$permission){
            $permission = new InfixModuleInfo();
            $permission->id = 5000;
            $permission->module_id = 9;
            $permission->parent_id = 870;
            $permission->type = '2';
            $permission->is_saas = 0;
            $permission->name = "Position Setup";
            $permission->route = "exam-report-position";
            $permission->lang_name = "position_setup";
            $permission->active_status = 1;
            $permission->created_by = 1;
            $permission->updated_by = 1;
            $permission->school_id = 1;
            $permission->save();
        }
    }

    public function down()
    {
        Schema::dropIfExists('exam_report_print_update');
    }
}
