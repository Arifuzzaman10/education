<?php

use App\SmLanguagePhrase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Modules\MenuManage\Entities\Sidebar;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixPermissionAssign;
use Modules\RolePermission\Entities\InfixModuleStudentParentInfo;

class CreateZoomMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('meeting_id')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();

            //basic
            $table->string('topic')->nullable();
            $table->string('description')->nullable();
            $table->string('attached_file')->nullable();
            $table->string('date_of_meeting')->nullable();
            $table->string('time_of_meeting')->nullable();
            $table->string('meeting_duration')->nullable();
            $table->integer('time_before_start')->nullable();
            // setting
            $table->boolean('join_before_host')->nullable();
            $table->boolean('host_video')->nullable();
            $table->boolean('participant_video')->nullable();
            $table->boolean('mute_upon_entry')->nullable();
            $table->boolean('waiting_room')->nullable();
            $table->string('audio')->default('both')->comment('both, telephony & voip');
            $table->string('auto_recording')->default('none')->comment('local, cloud & none');
            $table->string('approval_type')->default(0)->comment('0 => Automatic, 1 => Manually & 2 No Registration');

            //recurring
            $table->boolean('is_recurring')->nullable();
            $table->tinyInteger('recurring_type')->nullable();
            $table->tinyInteger('recurring_repect_day')->nullable();
            $table->string('weekly_days')->nullable();
            $table->string('recurring_end_date')->nullable();

            $table->boolean('status')->default(1);
            $table->text('local_video')->nullable();
            $table->text('vedio_link')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->timestamps();
        });



        $d = [
            [18, 'zoom', 'Zoom', 'zoom', 'জুম', 'Zoom'],
            [18, 'before', 'Before', 'antaŭe', 'আগে', 'avant que'],
            [18, 'virtual_class', 'Virtual Class', 'Virtuala Klaso', 'ভার্চুয়াল ক্লাস', 'Classe virtuelle'],
            [18, 'topic', 'Topic', 'temo', 'বিষয়', 'sujette'],
            [18, 'description', 'Description', 'Priskribo', 'বর্ণনা', 'la description'],
            [18, 'date_of_meeting', 'Date of Meeting', 'Dato de Kunveno', 'সভার তারিখ', 'Dato de Kunveno'],
            [18, 'time_of_meeting', 'Time of Meeting', 'Tempo de Kunveno', 'সভার সময়', 'Heure de la réunion'],
            [18, 'meeting_durration', 'Meetting Durration (Minutes)', 'Meetting Durration (Minutes)', 'সভার সময়কাল (মিনিট)', 'Meetting Durration (Minutes)'],
            [18, 'zoom_recurring', 'Recurring', 'Recurring', 'পুনরাবৃত্তি', 'Recurring'],
            [18, 'zoom_recurring_type', 'Recurrence Type', 'Recurrence Type', 'পুনরাবৃত্তির ধরণ', 'Recurrence Type'],
            [18, 'zoom_recurring_daily', 'Daily', 'Daily', 'প্রতিদিন', 'Daily'],
            [18, 'zoom_recurring_weekly', 'Weekly', 'Weekly', 'সাপ্তাহিক', 'Weekly'],
            [18, 'zoom_recurring_monthly', 'Monthly', 'Monthly', 'মাসিক', 'Monthly'],
            [18, 'zoom_recurring_repect', 'Repeat Every', 'Repeat Every', 'প্রতিটি পুনরাবৃত্তি', 'Repeat Every'],
            [18, 'zoom_recurring_end', 'End Recurrence', 'End Recurrence', 'শেষ পুনরাবৃত্তি', 'End Recurrence'],
            [18, 'join_before_host', 'Join Before Host', 'Join Before Host', 'হোস্টের আগে যোগ দিন', 'Join Before Host'],
            [18, 'host_video', 'Host Video', 'Host Video ', 'হোস্ট ভিডিও', 'Host Video'],
            [18, 'participant_video', 'Participant Video', 'Participant Video', 'অংশগ্রহণকারী ভিডিও', 'Participant Video'],
            [18, 'mute_upon_entry', 'Participate Mic Mute', 'Participate Mic Mute ', 'মাইক নিঃশব্দে অংশ নিন', 'Participate Mic Mute'],
            [18, 'watermark', 'Watermark', 'Watermark', 'ওয়াটারমার্ক', 'Watermark'],
            [18, 'waiting_room', 'Waiting Room', 'Waiting Room', 'বিশ্রাম কক্ষ', 'Waiting Room'],
            [18, 'auto_recording', 'Auto Recording', 'Auto Recording', 'অটো রেকর্ডিং', 'Auto Recording'],
            [18, 'audio_options', 'Audio Option', 'Audio Option', 'অডিও বিকল্প', 'Audio Option'],
            [18, 'meeting_approval', 'Meeting Join Approval', 'Meeting Join Approval', 'সভা যোগদানের অনুমোদন', 'Meeting Join Approval'],
            [18, 'meeting_id', 'Meeting ID', 'Meeting ID', 'মিটিং আইডি', 'Meeting ID'],
            [18, 'zoom_start_join', 'Join/Start', 'Join/Start', 'যোগ দিন / শুরু করুন', 'Join/Start'],
            [18, 'join', 'Join', 'Join', 'যোগদান', 'Join'],
            [18, 'repeat', 'Repeat', 'Repeat', 'পুনরাবৃত্তি', 'Repeat'],
            [18, 'show', 'Show', 'Show', 'দেখান', 'Show'],
            [18, 'delete_meetings', 'Delete Meeting', 'Delete Meeting', 'সভা মুছুন', 'Delete Meeting'],
            [18, 'are_you_sure_delete', 'Are You Sure To Delete ?', 'Are you sure to delete ?', 'আপনি কি মুছে ফেলার বিষয়ে নিশ্চিত?', 'Are you sure to delete ?'],
            [18, 'are_you_sure_to', 'Are You Sure To', 'Are you sure to', 'আপনি কি  নিশ্চিত?', 'Are you sure to'],
            [18, 'zoom_setting', 'Zoom Setting', 'Zoom Setting', 'জুম সেটিং', 'Zoom Setting'],
            [18, 'for_paid_package', 'For Paid Package', 'For Paid Package', 'পেইড প্যাকেজের জন্য', 'For Paid Package'],
            [18, 'api_key', 'API Key', 'API Key', 'এপিআই কী', 'API Key'],
            [18, 'serect_key', 'Secret Key', 'Secret Key', 'গোপন চাবি', 'Secret Key'],
            [18, 'pakage', 'Pakage', 'Pakage', 'পাকেজ', 'Pakage'],
            [18, 'join_meeting', 'Join Meeting', 'Join Meeting', 'সভাতে যোগদান করুন', 'Join Meeting'],
            [18, 'attached_file', 'Attached File', 'Attached File', 'সংযুক্ত ফাইল', 'Attached File'],
            [18, 'start_date_time', 'Start Date & Time', 'Start Date & Time', 'আরম্ভের তারিখ ও সময়', 'Start Date & Time'],
            [18, 'not_yet_start', 'Not Yet Start', 'Not Yet Start', 'এখনও না শুরু', 'Not Yet Start'],
            [18, 'closed', 'Closed', 'closed', 'বন্ধ', 'closed'],
            [18, 'host_id', 'Host ID', 'Host ID', 'হোস্ট আইডি', 'Host ID'],
            [18, 'timezone', 'Timezone', 'Timezone', 'সময় অঞ্চল', 'Timezone'],
            [18, 'created_at', 'Created At', 'Created At', 'এ নির্মিত', 'Created At'],
            [18, 'join_url', 'Join URL', 'Join URL', 'ইউআরএল যোগ দিন', 'Join URL'],
            [18, 'encrypted', 'Encrypted', 'Encrypted', 'এনক্রিপ্ট করা', 'Encrypted'],
            [18, 'in_mettings', 'in Mettings', 'in Mettings', 'মিটিংয়ে', 'in Mettings'],
            [18, 'cn_mettings', 'cn Mettings', 'cn Mettings', 'সিএন সভা', 'cn Mettings'],
            [18, 'use_pmi', 'use pmi', 'use pmi', 'পিএমআই ব্যবহার করুন', 'use pmi'],
            [18, 'enforce_login', 'Enforce Login', 'Enforce Login', 'লগইন প্রয়োগ করুন', 'Enforce Login'],
            [18, 'enforce_login_domains', 'Enforce Login Domains', 'Enforce Login Domains', 'লগইন ডোমেনগুলি প্রয়োগ করুন', 'Enforce Login Domains'],
            [18, 'alternative_hosts', 'Alternative Hosts', 'Alternative Hosts', 'প্রমাণীকরণের সভা', 'Alternative Hosts'],
            [18, 'meeting_authentication', 'Meeting Authentication', 'Meeting Authentication', 'প্রমাণীকরণের সভা', 'Meeting Authentication'],
            [18, 'delete_virtual_meeting', 'Delete Virtaul Meeting', 'Delete Virtaul Meeting', 'ভার্চুয়াল সভা মুছুন', 'Delete Virtaul Meeting'],
            [18, 'delete_virtual_class', 'Delete Virtaul Class', 'Delete Virtaul Class', 'ভার্চুয়াল ক্লাস মুছুন', 'Delete Virtaul Class'],
            [18, 'join_class', 'Join Class', 'Join Class', 'ক্লাসে যোগদান করুন', 'Join Class'],
            [18, 'participants', 'Participants', 'Participants', 'অংশগ্রহণকারীরা', 'Participants'],
            [18, 'meetings', 'Meetings', 'Meetings', 'সভা', 'Meetings'],
            [18, 'select_member', 'Select Member', 'Select Member', 'সদস্য নির্বাচন করুন', 'Select Member'],
            [18, 'change_default_settings', 'Change Default Settings', 'Change Default Settings', 'ডিফল্ট সেটিংস পরিবর্তন করুন', 'Change Default Settings'],
            [18, 'virtual_class_meetting', 'Vitual Class/Meeting', 'Vitual Class/Meeting', 'ভার্চুয়াল ক্লাস / সভা', 'Vitual Class/Meeting'],
            [18, 'class_reports', 'Class Reports', 'Klasaj Raportoj', 'ক্লাস রিপোর্ট', 'Rapports de classe'],
            [18, 'meeting_reports', 'Meeting Reports','Kunvenaj Raportoj', 'সভা সভা', 'Rapports de réunion'],
            [18, 'date_of_class', 'Date of Class', 'Dato de Klaso', 'ক্লাসের তারিখ', 'Date du cours'],
            [18, 'time_of_class', 'Time of Class', 'Tempo de Klaso', 'ক্লাসের সময়', 'Heure de la classe'],
            [18, 'duration_of_class', 'Duration of Class (Minutes)', 'Duration of Class (Minutes)', 'শ্রেণীর সময়কাল (মিনিট)', 'Duration of Class (Minutes)'],
            [18, 'virtual_class_id', 'VClass ID', 'VClass ID', 'ভিস্লাস আইডি', 'VClass ID'],
            [18, 'virtual_meeting', 'Virtual Meeting', 'Virtual Meeting', 'ভার্চুয়াল সভা', 'Virtual Meeting'],
            [18, 'occurs_on', 'Occurs On', 'Okazas', 'ঘটে', 'Se produit le'],
            [18, 'video', 'Video', 'Video', 'ভিডিও', 'Video'], 
            [18, 'recorded', 'Recorded', 'Rekordo', 'রেকর্ড', 'Enregistrer']
        ];

        try {

            $zoom_101 = InfixModuleStudentParentInfo::where('id',101)->where('module_id',2022)->where('user_type',2)->first(); 
            $zoom_103 = InfixModuleStudentParentInfo::where('id',103)->where('module_id',2022)->where('user_type',2)->first(); 
   
            if($zoom_101){
                $zoom_101 =InfixModuleStudentParentInfo::find(101);  
                $zoom_101->route = "zoom/virtual-class/child/{id}";             
                $zoom_101->save();
            }
            if($zoom_103){
                $zoom_103 =InfixModuleStudentParentInfo::find(103);  
                $zoom_103->route = "zoom/meetings/parent";             
                $zoom_103->save();
            }

                        // for admins

                        $admins = [554, 555, 556, 557, 558, 559, 560, 561, 562, 563, 564, 565, 566, 567, 568, 569, 570];

                        foreach ($admins as $key => $value) {
                            $check=InfixPermissionAssign::where('module_id',$value)->where('role_id',5)->first();
                            if(empty($check)){
                                $permission = new InfixPermissionAssign();
                                $permission->module_id = $value;
                                $permission ->module_info = InfixModuleInfo::find($value)->name;
                                $permission->role_id = 5;
                                $permission->save();
                             }
                        }
            
                        //for teahcer
            
                        $teachers= [ 554, 555, 556, 557, 558, 559, 560, 561, 562, 563, 564, 565, 566, 567];
            
                        foreach ($teachers as $key => $value) {
                        $check=InfixPermissionAssign::where('module_id',$value)->where('role_id',4)->first();
                                if(empty($check)){
                                $permission = new InfixPermissionAssign();
                                $permission->module_id = $value;
                                $permission ->module_info = InfixModuleInfo::find($value)->name;
                                $permission->role_id = 4;
                                $permission->save();
                              }
                         
                        }
                        // for receiptionists
                        $receiptionists=[554, 560, 564];
                         foreach ($receiptionists as $key => $value) {
                            $check=InfixPermissionAssign::where('module_id',$value)->where('role_id',7)->first();
                                if(empty($check)){
                                $permission = new InfixPermissionAssign();
                                $permission->module_id = $value;
                                $permission ->module_info = InfixModuleInfo::find($value)->name;
                                $permission->role_id = 7;
                                $permission->save();
                              }
                           
                        }
            
                        // for librarians
            
                        $librarians= [554, 560, 564];
            
                     foreach ($librarians as $key => $value) {
                            $check=InfixPermissionAssign::where('module_id',$value)->where('role_id',8)->first();
                                if(empty($check)){
                                $permission = new InfixPermissionAssign();
                                $permission->module_id = $value;
                                $permission ->module_info = InfixModuleInfo::find($value)->name;
                                $permission->role_id = 8;
                                $permission->save();
                             } 
                          
                        }
                        // drivers
            
                      $drivers =[554, 560, 564];
                        foreach ($drivers as $key => $value) {
                             $check=InfixPermissionAssign::where('module_id',$value)->where('role_id',8)->first();
                                if(empty($check)){
                                $permission = new InfixPermissionAssign();
                                $permission->module_id = $value;
                                $permission ->module_info = InfixModuleInfo::find($value)->name;
                                $permission->role_id = 9;
                                $permission->save();
                          }
                        }
                        // accountants
                        $accountants=[554, 560, 564];
                         foreach ($accountants as $key => $value) {
                            $check=InfixPermissionAssign::where('module_id',$value)->where('role_id',6)->first();
                               if(empty($check)){
                                $permission = new InfixPermissionAssign();
                                $permission->module_id = $value;
                                $permission ->module_info = InfixModuleInfo::find($value)->name;
                                $permission->role_id = 6;
                                $permission->save();
                            }   
                        
                        }
            
                            //for students
                              $students = [554, 555, 559,];
                                foreach ($students as $key => $value) {
                                    $check=InfixPermissionAssign::where('module_id',$value)->where('role_id',2)->first();
                                     if(empty($check)){
                                        $permission = new InfixPermissionAssign();
                                        $permission->module_id = $value;
                                        $permission ->module_info = InfixModuleInfo::find($value)->name;
                                        $permission->role_id = 2;
                                        $permission->save();
                                    }
                                    
                                }
            
                            //for parents
                             $parents =[100,101,103];
                            foreach ($parents as $key => $value) {
                                $check=InfixPermissionAssign::where('module_id',$value)->where('role_id',3)->first();
                                 if(empty($check)){
                                    $permission = new InfixPermissionAssign();
                                    $permission->module_id = $value;
                                    $permission ->module_info = InfixModuleStudentParentInfo::find($value)->name;
                                    $permission->role_id = 3;
                                    $permission->save();
                                }
                                
                            }
            
            foreach ($d as $row) {
                $s = SmLanguagePhrase::where('default_phrases', trim($row[1]))->first();
                if (empty($s)) {
                    $s = new SmLanguagePhrase();
                }
                $s->modules = $row[0];
                $s->default_phrases = trim($row[1]);
                $s->en = trim($row[2]);
                $s->es = trim($row[3]);
                $s->bn = trim($row[4]);
                $s->fr = trim($row[5]);
                $s->save();
            }


            
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
        Schema::dropIfExists('zoom_meetings');
    }
}
