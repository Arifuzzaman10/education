<?php
use App\SmStudentIdCard;
use App\SmLanguagePhrase;
use App\SmGeneralSettings;
use App\InfixModuleManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Modules\MenuManage\Entities\Sidebar;
use Illuminate\Database\Schema\Blueprint;
use Modules\MenuManage\Entities\UserMenu;
use Modules\MenuManage\Entities\MenuManage;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixPermissionAssign;
use Modules\RolePermission\Entities\InfixModuleStudentParentInfo;

class CreateEduUpdateVersion630Table extends Migration
{
    public function up()
    {
        //fees carryfoward new colum update
        $name ="notes";
        if (!Schema::hasColumn('sm_fees_carry_forwards', $name)) {
            Schema::table('sm_fees_carry_forwards', function ($table) use ($name) {
                $table->string('notes',191)->default("Fees Carry Forward");
            });
        }

        $name2 ="StudentAbsentNotification";
        if (!Schema::hasColumn('sm_general_settings', $name2)) {
            Schema::table('sm_general_settings', function ($table) use ($name2) {
                $table->integer('StudentAbsentNotification')->default(1)->nullable();
            });
        }

        $name3 ="attendance_layout";
        if (!Schema::hasColumn('sm_general_settings', $name3)) {
            Schema::table('sm_general_settings', function ($table) use ($name3) {
                $table->integer('attendance_layout')->default(1)->nullable();
            });
        }

        $name4 ="bank_id";
        if (!Schema::hasColumn('sm_fees_payments', $name4)) {
            Schema::table('sm_fees_payments', function ($table) use ($name4) {
                $table->integer('bank_id')->nullable();
            });
        }

        $XenditPayment ="XenditPayment";
        if (!Schema::hasColumn('sm_general_settings', $XenditPayment)) {
            Schema::table('sm_general_settings', function ($table) use ($XenditPayment) {
                $table->integer('XenditPayment')->default(1)->nullable();
            });
        }


        $HimalayaSms ="HimalayaSms";
        if (!Schema::hasColumn('sm_general_settings', $HimalayaSms)) {
            Schema::table('sm_general_settings', function ($table) use ($HimalayaSms) {
                $table->integer('HimalayaSms')->default(1)->nullable();
            });
        }



        $BulkPrint ="BulkPrint";
        if (!Schema::hasColumn('sm_general_settings', $BulkPrint)) {
            Schema::table('sm_general_settings', function ($table) use ($BulkPrint) {
                $table->integer('BulkPrint')->default(1)->nullable();
            });
        }



        $OnlineExam ="OnlineExam";
        if (!Schema::hasColumn('sm_general_settings', $OnlineExam)) {
            Schema::table('sm_general_settings', function ($table) use ($OnlineExam) {
                $table->integer('OnlineExam')->default(0)->nullable();
            });
        }


        $assign_id ="assign_id";
        if (!Schema::hasColumn('sm_bank_payment_slips', $assign_id)) {
            Schema::table('sm_bank_payment_slips', function ($table) use ($assign_id) {
                $table->integer('assign_id')->nullable();
            });
        }



        if (!Schema::hasColumn('sm_fees_payments', $assign_id)) {
            Schema::table('sm_fees_payments', function ($table) use ($assign_id) {
                $table->integer('assign_id')->nullable();
            });
        }


        $admins = [1001,1002];

        foreach ($admins as $key => $value) {

            $check_exist = InfixModuleInfo::find($value);
            if($check_exist == ""){
                $moduleInfo = new InfixModuleInfo();
                $moduleInfo->id = $value ;
                $moduleInfo->module_id =5 ;
                $moduleInfo->name = "Edit";
                $moduleInfo->type = 3;
                $moduleInfo->parent_id = 113;
                $moduleInfo->is_saas = 0;
                $moduleInfo->route = "";
                $moduleInfo->lang_name = "";
                $moduleInfo->icon_class = '';
                $moduleInfo->active_status = 1;
                $moduleInfo->school_id =  1 ;
                $moduleInfo->save();

            }

            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info =InfixModuleInfo::find($value) ? InfixModuleInfo::find($value)->name :'';
            $permission->role_id = 5;
            $permission->save();
        }

        foreach ($admins as $key => $value) {

            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info =InfixModuleInfo::find($value) ? InfixModuleInfo::find($value)->name :'';
            $permission->role_id = 6;
            $permission->save();
        }

        //fees carryfoward menu manager and role permission
        $module_id = 136;
        $exist = InfixModuleInfo::find($module_id);

        //remove About menu
        $exist3 = InfixModuleInfo::find(477);

        if($exist3){
            $exist3->delete();
        }




        $student_export = InfixModuleInfo::find(663);
        if($student_export){
            $student_export->lang_name = "student_export";
            $student_export->name = "Student Export";
            $student_export->save();
        }
        $type_three = InfixModuleInfo::whereIn('id',[436,706])->get();
        if( $type_three){
            foreach($type_three as $type){
                $type->type = 3;
                $type->save();
            }
        }

        $lang_pharse = SmLanguagePhrase::where('default_phrases','about_&_update')->first();
        if(! $lang_pharse){
            $new_lang = new SmLanguagePhrase();
        }
        else{
            $new_lang = $lang_pharse ;
        }
        $new_lang = new SmLanguagePhrase();
        $new_lang->modules  = 17;
        $new_lang->default_phrases  = "about_&_update";
        $new_lang->en  = "About & Update";
        $new_lang->es  = "About & Update";
        $new_lang->bn  = "সম্পর্ক এবং আপডেট";
        $new_lang->fr  = "About & Update";
        $new_lang->save();

        $new_lang3 = new SmLanguagePhrase();
        $new_lang3->modules  = 17;
        $new_lang3->default_phrases  = "add_days";
        $new_lang3->en  = "Add Days";
        $new_lang3->es  = "About & Update";
        $new_lang3->bn  = "দিন যোগ করুন";
        $new_lang3->fr  = "Add Days";
        $new_lang3->save();

        $new_lang3 = new SmLanguagePhrase();
        $new_lang3->modules  = 1;
        $new_lang3->default_phrases  = "utilities";
        $new_lang3->en  = "Utilities";
        $new_lang3->es  = "Utilities";
        $new_lang3->bn  = "উপযোগিতা";
        $new_lang3->fr  = "Utilities";
        $new_lang3->save();


        $new_lang4 = new SmLanguagePhrase();
        $new_lang4->default_phrases  = "student_export";
        $new_lang4->en  = "Student Export";
        $new_lang4->es  = "Student Export";
        $new_lang4->bn  = "ছাত্র রফতানি";
        $new_lang4->fr  = "Student Exports";
        $new_lang4->save();

        $new_lang5 = new SmLanguagePhrase();
        $new_lang5->modules  = 8;
        $new_lang5->default_phrases  = "previous_record";
        $new_lang5->en  = "Previous Record";
        $new_lang5->es  = "Previous Record";
        $new_lang5->bn  = "আগে নথি";
        $new_lang5->fr  = "Previous Record";
        $new_lang5->save();


        //about and update menu
        $utility_menu = InfixModuleInfo::find(4000);
        $about_menu = InfixModuleInfo::find(478);
        $previous_rec = InfixModuleInfo::find(540);
        $absent_time  = InfixModuleInfo::find(950);
        $report  = InfixModuleInfo::find(840);
        if(! $utility_menu){
            $utility = new InfixModuleInfo();
            $utility->id = 4000 ;
            $utility->module_id =18 ;
            $utility->name = "Utilities";
            $utility->type = 2;
            $utility->parent_id = 398;
            $utility->is_saas = 0;
            $utility->route = "utility";
            $utility->lang_name = "utilities";
            $utility->icon_class = '';
            $utility->active_status = 1;
            $utility->school_id = 1;
            $utility->save();
        }

        if($report){
            $report->id = 840 ;
            $report->module_id =5;
            $report->name = "Report";
            $report->parent_id = 108;
            $report->type = 2;
            $report->is_saas = 0;
            $report->route = "";
            $report->lang_name = "report";
            $report->icon_class = '';
            $report->active_status = 1;
            $report->school_id = 1;
            $report->save();
        }


        if($previous_rec){
            $previous_rec->id = 540 ;
            $previous_rec->module_id =17;
            $previous_rec->name = "previous record";
            $previous_rec->parent_id = 376;
            $previous_rec->is_saas = 0;
            $previous_rec->route = "previous-record";
            $previous_rec->lang_name = "previous-record";
            $previous_rec->icon_class = '';
            $previous_rec->active_status = 1;
            $previous_rec->school_id = 1;
            $previous_rec->save();
        }


        if(is_null($absent_time)){
            $absent_time = new InfixModuleInfo();
            $absent_time->id = 950 ;
            $absent_time->module_id =3 ;
            $absent_time->name = "Time Setup";
            $absent_time->type = 2;
            $absent_time->parent_id = 61;
            $absent_time->is_saas = 0;
            $absent_time->route = "notification_time_setup";
            $absent_time->lang_name = "time_setup";
            $absent_time->icon_class = '';
            $absent_time->active_status = 1;
            $absent_time->school_id = 1;
            $absent_time->save();
        }

        if($about_menu){
            $about_menu->id = 478 ;
            $about_menu->module_id =18 ;
            $about_menu->name = "About & Update";
            $about_menu->parent_id = 398;
            $about_menu->is_saas = 0;
            $about_menu->route = "update-system";
            $about_menu->lang_name = "about_&_update";
            $about_menu->icon_class = '';
            $about_menu->active_status = 1;
            $about_menu->school_id = 1;
            $about_menu->save();
        }

        //Fees Carry Forward
        if(!$exist){
            $module_info = new InfixModuleInfo();
        }else{
            $module_info = InfixModuleInfo::find($module_id);
        }
        $module_info->id = 136 ;
        $module_info->module_id =5 ;
        $module_info->name = "Fees Carry Forward";
        $module_info->parent_id = 108;
        $module_info->is_saas = 0;
        $module_info->route = "fees_forward";
        $module_info->lang_name = "fees_forward";
        $module_info->icon_class = '';
        $module_info->active_status = 1;
        $module_info->school_id = 1;
        $module_info->save();




        $parent_info78 =  InfixModuleStudentParentInfo::find(78);
        if($parent_info78){
            $parent_info78->route = "parent-examination-schedule/{id}";
            $parent_info78->save();
        }

        $parent_info98 =  InfixModuleStudentParentInfo::find(98);
        if($parent_info98){
            $parent_info98->route = "lesson/parent/lessonPlan/{id}";
            $parent_info98->save();
        }

        $parent_info99 =  InfixModuleStudentParentInfo::find(99);
        if($parent_info99){
            $parent_info99->route = "lesson/parent/lessonPlan-overview/{id}";
            $parent_info99->save();
        }

        // StudentAbsentNotification

        $name = 'StudentAbsentNotification';
        $student_absent = InfixModuleManager::where('name',$name)->first();
        if(!($student_absent)){
            $dataPath = 'Modules/StudentAbsentNotification/StudentAbsentNotification.json';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new InfixModuleManager();
            $s->name = $name;
            $s->email = 'support@spondonit.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
        }

        $BulkPrint = 'BulkPrint';
        $BulkPrint = InfixModuleManager::where('name',$BulkPrint)->first();
        if( !($BulkPrint)){
            $s = new InfixModuleManager();
            $s->name = 'BulkPrint';
            $s->email = 'support@spondonit.com';
            $s->notes = "This is bulkprint module for print id card, certificate and fees invoice print .";
            $s->version = "1.0";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 1;
            $s->addon_url = "mailto:support@spondonit.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
        }



        $name2 = 'Saas';
        $saas = InfixModuleManager::where('name',$name2)->first();
        if( !($saas)){
            $s = new InfixModuleManager();
            $s->name = $name2;
            $s->email = 'support@spondonit.com';
            $s->notes = "This is Saas module for manage multiple school or institutes.Every school managed by individual admin. Thanks for using.";
            $s->version = "1.1";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@spondonit.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
        }

        $Xendit = 'XenditPayment';
        $Xendit = InfixModuleManager::where('name',$Xendit)->first();
        if( !($Xendit)){
            $s = new InfixModuleManager();
            $s->name = "XenditPayment";
            $s->email = 'support@spondonit.com';
            $s->notes = "This is Xendit Payment gateway module for online payemnt in this system specially Philipine and Indonesia. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@spondonit.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
        }


        $OnlineExam = 'OnlineExam';
        $OnlineExam = InfixModuleManager::where('name',$OnlineExam)->first();
        if( !($OnlineExam)){
            $s = new InfixModuleManager();
            $s->name = "OnlineExam";
            $s->email = 'support@spondonit.com';
            $s->notes = "This is OnlineExam module for taking exam virtually . Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@spondonit.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
        }


        $HimalayaSms = 'HimalayaSms';
        $HimalayaSms = InfixModuleManager::where('name',$HimalayaSms)->first();
        if( !($HimalayaSms)){
            $s = new InfixModuleManager();
            $s->name = "HimalayaSms";
            $s->email = 'support@spondonit.com';
            $s->notes = "This is OnlineExam module for taking exam virtually . Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@spondonit.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
        }

        $onlineExamId=875;

        $new= InfixModuleInfo::find($onlineExamId);
        if(!($new)){
            $new = new InfixModuleInfo();
            $new->id = 875 ;
            $new->module_id =35 ;
            $new->name = "Online Exam";
            $new->type = 0;
            $new->parent_id = 0;
            $new->is_saas = 0;
            $new->lang_name = "online_exam";
            $new->icon_class = 'flaticon-book-1';
            $new->active_status = 1;
            $new->school_id = 1;
            $new->save();
        }


        $onlineExamMenuIds= [230,234,238];
        foreach($onlineExamMenuIds as $onlineExamMenuId){
            $store= InfixModuleInfo::find($onlineExamMenuId);
            if( $store){
                $store->module_id =35;
                $store->parent_id = 875;
                $store->update();
            }

        }

        $onlineExamSubMenuIds= [231,232,233,235,236,237,239,240,241,242,243,244];
        foreach($onlineExamSubMenuIds as $onlineExamSubMenuId){
            $store= InfixModuleInfo::find($onlineExamSubMenuId);
            if($store){
                $store->module_id =35;
                $store->update();
            }
        }


        $new_lang6 = SmLanguagePhrase::where('default_phrases','subject_attendance_layout')->first();
        if(! $new_lang6){
            $new_lang6 = new SmLanguagePhrase();
        }
        else{
            $new_lang6 = $lang_pharse ;
        }


        $new_lang6->modules  = 8;
        $new_lang6->default_phrases  = "subject_attendance_layout";
        $new_lang6->en  = "Subject Attendance Layout";
        $new_lang6->es  = "Subject Attendance Layout";
        $new_lang6->bn  = "বিষয় উপস্থিতি বিন্যাস";
        $new_lang6->fr  = "Subject Attendance Layout";
        $new_lang6->save();

        $new_lang7 = SmLanguagePhrase::where('default_phrases','layout')->first();
        if(! $new_lang7){
            $new_lang7 = new SmLanguagePhrase();
        }
        else{
            $new_lang7 = $lang_pharse ;
        }


        $new_lang7->modules  = 8;
        $new_lang7->default_phrases  = "layout";
        $new_lang7->en  = "Layout";
        $new_lang7->es  = "Layout";
        $new_lang7->bn  = "বিন্যাস";
        $new_lang7->fr  = "Layout";
        $new_lang7->save();

        $new_lang8 = SmLanguagePhrase::where('default_phrases','your')->first();
        if(! $new_lang8){
            $new_lang8 = new SmLanguagePhrase();
        }
        else{
            $new_lang8 = $lang_pharse;
        }

        $new_lang8->modules  = 0;
        $new_lang8->default_phrases  = "your";
        $new_lang8->en  = "Your";
        $new_lang8->es  = "Your";
        $new_lang8->bn  = "তোমার";
        $new_lang8->fr  = "Your";
        $new_lang8->save();

        $lang_pharse9 = SmLanguagePhrase::where('default_phrases','no_data_available_in_table')->first();
        if(! $lang_pharse9){
            $lang_pharse9 = new SmLanguagePhrase();
        }
        else{
            $lang_pharse9 = $lang_pharse;
        }

        $lang_pharse9->modules  = 1;
        $lang_pharse9->default_phrases  = "no_data_available_in_table";
        $lang_pharse9->en  = "No data available in table";
        $lang_pharse9->es  = "No data available in table";
        $lang_pharse9->bn  = "সারণীতে কোনও ডেটা উপলব্ধ নেই";
        $lang_pharse9->fr  = "No data available in table";
        $lang_pharse9->save();

        $lang_pharse10 = new SmLanguagePhrase();
        $lang_pharse10->modules  = 1;
        $lang_pharse10->default_phrases  = "entries";
        $lang_pharse10->en  = "Entries";
        $lang_pharse10->es  = "Entries";
        $lang_pharse10->bn  = "এন্ট্রি";
        $lang_pharse10->fr  = "Entries";
        $lang_pharse10->save();

        $lang_pharse11 = new SmLanguagePhrase();
        $lang_pharse11->modules  = 1;
        $lang_pharse11->default_phrases  = "quick_search";
        $lang_pharse11->en  = "Quick Search";
        $lang_pharse11->es  = "Quick Search";
        $lang_pharse11->bn  = "দ্রুত অনুসন্ধান";
        $lang_pharse11->fr  = "Quick Search";
        $lang_pharse11->save();

        $lang_pharse12 = new SmLanguagePhrase();
        $lang_pharse12->modules  = 1;
        $lang_pharse12->default_phrases  = "xendit";
        $lang_pharse12->en  = "xendit";
        $lang_pharse12->es  = "xendit";
        $lang_pharse12->bn  = "সেন্ডিত";
        $lang_pharse12->fr  = "xendit";
        $lang_pharse12->save();


        //Infix Module Info Add or Update Data
        $module_infos = [

            [920, 36, 0, '1', 0,'Bulk Print','','bulk_print','flaticon-analysis', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [921, 36, 920, '2', 0,'Student Id Card','student-id-card-bulk-print','student_id_card','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [922, 36, 920, '2', 0,'Student Certificate','certificate-bulk-print','student_certificate','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [923, 36, 920, '2', 0,'Staff Id Card','staff-id-card-bulk-print','staff_id_card','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [924, 36, 920, '2', 0,'PayrollBulk Print','payroll-bulk-print','payroll_bulk_print','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [925, 36, 920, '2', 0,'Fees Invoice Settings','invoice-settings','fees_invoice_settings','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [926, 36, 920, '2', 0,'Fees invoice Bulk Print','fees-bulk-print','fees_invoice_bulk_print','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [1100, 100, 0, '1', 0,'Custom Field','','custom_field','flaticon-slumber', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [1101, 100, 1100, '2', 0,'Student Registration','student-reg-custom-field','student_registration','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [1102, 100, 1101, '3', 0,'Add','','','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [1103, 100, 1101, '3', 0,'Edit','','','',1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [1104, 100, 1101, '3', 0,'Delete','','','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [1105, 100, 1100, '2', 0,'Staff Registration','staff-reg-custom-field','staff_registration','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [1106, 100, 1105, '3', 0,'Add','','','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [1107, 100, 1105, '3', 0,'Edit','','','',1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'],
            [1108, 100, 1105, '3', 0,'Delete','','','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22']

        ];
        //    DB::insert($module_infos);


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

        }


        //    custom_field add student and staffs

        $col_1 = "custom_field";
        $col_2 = "custom_field_form_name";

        if (!Schema::hasColumn('sm_students', $col_1)) {
            Schema::table('sm_students', function ($table) use ($col_1) {
                $table->text('custom_field',191)->nullable();
            });
        }
        if (!Schema::hasColumn('sm_students', $col_2)) {
            Schema::table('sm_students', function ($table) use ($col_2) {
                $table->string('custom_field_form_name',191)->nullable();
            });
        }

        if (!Schema::hasColumn('sm_staffs', $col_1)) {
            Schema::table('sm_staffs', function ($table) use ($col_1) {
                $table->text('custom_field',191)->nullable();
            });
        }
        if (!Schema::hasColumn('sm_staffs', $col_2)) {
            Schema::table('sm_staffs', function ($table) use ($col_2) {
                $table->string('custom_field_form_name',191)->nullable();
            });
        }

        $idCardExistField = "background_img";
        if(Schema::hasColumn('sm_student_id_cards', $idCardExistField)){
            SmStudentIdCard::truncate();
        }
        // new id card table refresh
        $idCardStringFields = ["background_img","profile_image","page_layout_style","user_photo_style","user_photo_width","user_photo_height","phone_number"];
        foreach ($idCardStringFields as $key => $idCardStringField) {
            if (!Schema::hasColumn('sm_student_id_cards', $idCardStringField)) {
                Schema::table('sm_student_id_cards', function ($table) use ($idCardStringField) {
                    $table->string($idCardStringField)->nullable();
                });
            }
        }

        $idCardIntegerFields = ["pl_width","pl_height","t_space","b_space","r_space","l_space"];
        foreach ($idCardIntegerFields as $key => $idCardIntegerField) {
            if (!Schema::hasColumn('sm_student_id_cards', $idCardIntegerField)) {
                Schema::table('sm_student_id_cards', function ($table) use ($idCardIntegerField) {
                    $table->integer($idCardIntegerField)->nullable();
                });
            }
        }

        $roleTextField = 'role_id';
        if (!Schema::hasColumn('sm_student_id_cards', $roleTextField)) {
            Schema::table('sm_student_id_cards', function ($table) use ($roleTextField) {
                $table->text('role_id')->nullable();
            });
        }




        $language_terms = [
            [2, 'full', 'Full', 'Full', 'সম্পূর্ণ', 'Full'],
            [2, 'half', 'Half', 'Half', 'অর্ধেক', 'Half'],
            [2, 'one_thired', 'One Thired', 'One Thired', 'প্রস্থ', 'One Thired'],
            [2, 'one_fourth', 'One Fourth', 'One Fourth', 'এক চতুর্থাংশ', 'One Fourth'],
            [2, 'Weight', 'Weight', 'Peso', 'ওজন', 'Poids'],
            [2, 'applicable_user', 'Applicable User', 'Applicable User', 'প্রযোজ্য ব্যবহারকারী', 'Applicable User'],
            [2, 'page_layout', 'Page Layout', 'Page Layout', 'পৃষ্ঠা বিন্যাস', 'Page Layout'],
            [2, 'round', 'Round', 'Round', 'গোল', 'Round'],
            [2, 'squre', 'Squre', 'Squre', 'বর্গক্ষেত্র', 'Squre'],
            [2, 'layout_spacing', 'Layout Spacing', 'Layout Spacing', 'বিন্যাস ফাঁক', 'Layout Spacing'],
            [2, 'top_space', 'Top Space', 'Top Space', 'শীর্ষ স্থান', 'Top Space'],
            [2, 'bottom_space', 'Bottom Space', 'Bottom Space', 'নীচের স্থান', 'Bottom Space'],
            [2, 'left_space', 'Left Space', 'Left Space', 'বাম স্থান', 'Left Space'],
            [2, 'right_space', 'Right Space', 'Right Space', 'ডান স্থান', 'Right Space'],
            [2, 'horizontal', 'Horizontal', 'Horizontal', 'অনুভূমিক', 'Horizontal'],
            [2, 'vertical', 'Vertical', 'Vertical', 'উল্লম্ব', 'Vertical'],
            [2, 'student_registration_custom_field', 'Student Registration Custom Field', 'Student Registration Custom Field', 'ছাত্র নিবন্ধন কাস্টম ক্ষেত্র', 'Student Registration Custom Field'],
            [3, 'field', 'Field', 'Field', 'ক্ষেত্র', 'Field'],
            [3, 'numeric', 'Numeric', 'Numeric', 'সংখ্যার', 'Numeric'],
            [3, 'multiline', 'Multiline', 'Multiline', 'বহুরেখা', 'Multiline'],
            [3, 'datepicker', 'Datepicker', 'Datepicker', 'তারিখ সংগ্রাহক', 'Datepicker'],
            [3, 'checkbox', 'Checkbox', 'Checkbox', 'চেকবক্স', 'Checkbox'],
            [3, 'radio', 'Radio', 'Radio', 'রেডিও', 'Radio'],
            [3, 'dropdown', 'Dropdown', 'Dropdown', 'ড্রপডাউন', 'Dropdown'],
            [3, 'length', 'Length', 'Length', 'দৈর্ঘ্য', 'Length'],
            [3, 'input', 'Input', 'Input', 'ইনপুট', 'Input'],
            [1, 'grid_gap', 'Grid Gap', 'Grid Gap', 'গ্রিড ফাঁক', 'Grid Gap'],
        ];


        foreach ($language_terms as $key => $row) {
            $lang_pharse = SmLanguagePhrase::where('default_phrases',trim($row[1]))->first();
            if(! $lang_pharse){
                $new_lang = new SmLanguagePhrase();
                $new_lang->modules = $row[0];
                $new_lang->default_phrases = trim($row[1]);
                $new_lang->en = trim($row[2]);
                $new_lang->es = trim($row[3]);
                $new_lang->bn = trim($row[4]);
                $new_lang->fr = trim($row[5]);
                $new_lang->save();
            }
        }



    }

    public function down()
    {
        Schema::dropIfExists('update_version');
    }
}
