<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreloaderColumnsToGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_general_settings', function (Blueprint $table) {
            if(!Schema::hasColumn($table->getTable(), 'preloader_status')){
                $table->boolean('preloader_status')->default(1);
            }
            if(!Schema::hasColumn($table->getTable(), 'preloader_style')){
                $table->boolean('preloader_style')->default(3);
            }
            if(!Schema::hasColumn($table->getTable(), 'preloader_type')){
                $table->boolean('preloader_type')->default(1);
            }
            if(!Schema::hasColumn($table->getTable(), 'preloader_image')){
                $table->string('preloader_image')->default('public/uploads/settings/preloader/preloader1.gif');
            }
        });

        $sql = ("INSERT INTO `infix_module_infos` (`id`, `module_id`, `parent_id`, `type`, `is_saas`, `name`, `route`, `lang_name`, `icon_class`, `active_status`, `created_by`, `updated_by`, `school_id`, `created_at`, `updated_at`) VALUES
        (2200, 18, 398, 2, 0,'Preloader Setting','setting.preloader','preloader_setting','',1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22');
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
            if(Schema::hasColumn($table->getTable(), 'preloader_status')){
                $table->dropColumn('preloader_status');
            }
            if(Schema::hasColumn($table->getTable(), 'preloader_style')){
                $table->dropColumn('preloader_style');
            }
            if(Schema::hasColumn($table->getTable(), 'preloader_type')){
                $table->dropColumn('preloader_type');
            }
            if(Schema::hasColumn($table->getTable(), 'preloader_image')){
                $table->dropColumn('preloader_image');
            }
        });

        \Modules\RolePermission\Entities\InfixModuleInfo::where('id', 2200)->delete();
    }
}
