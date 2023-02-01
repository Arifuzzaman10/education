<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixPermissionAssign;

class Create100percentMarkModificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

                //Infix Module Info Add or Update Data
                $module_infos = [

                    [3214, 9, 207, '2', 0,'MarkSheet Report','exam','exam_setup','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],

                   
                    [3215, 9, 207, '2', 0,'Subject Mark Sheet','exam_schedule','exam_schedule','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],

             
                    [3216, 9, 207, '2', 0,'Final Mark Sheet','exam_attendance','exam_attendance','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],

             
                    [3217, 9, 207, '2', 0,'Student Final Mark Sheet','marks_register','marks_register','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],

        
                ];
        
        foreach ($module_infos as $key => $info) {
            $exist = InfixModuleInfo::find($info[0]);
            if (!$exist) {
                $module_info= new InfixModuleInfo();
                $module_info->id=$info[0];
                $module_info->module_id=$info[1];
                $module_info->parent_id=$info[2];
                $module_info->type=$info[3];
                $module_info->is_saas=$info[4];
                $module_info->name=$info[5];
                $module_info->route=$info[6];
                $module_info->lang_name=$info[7];
                $module_info->icon_class=$info[8];
                $module_info->active_status=$info[9];
                $module_info->created_by=$info[10];
                $module_info->updated_by=$info[11];
                $module_info->school_id=$info[12];
                $module_info->created_at=$info[13];
                $module_info->updated_at=$info[14];
                $module_info->save();
            }

            $permission = new InfixPermissionAssign();
            $permission->module_id = $info[0];
            $permission ->module_info =InfixModuleInfo::find($info[0]) ? InfixModuleInfo::find($info[0])->name :'';
            $permission->role_id = 5;
            $permission->save();

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('100percent_mark_modification');
    }
}
