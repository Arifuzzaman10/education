<?php

use App\InfixModuleManager;
use App\SmSchool;
use App\SmsTemplate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExamMarkTemplateToSmsTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $allTempletes = [
            ['sms', 'exam_mark_student', '', 'Hi [student_name] , You are in class [class_name] ([section_name]), Your exam type [exam_type], [subject_marks]. School Name- [school_name]', '', '[student_name], [class_name], [section_name], [exam_type], [subject_names], [total_mark], [school_name], [subject_marks]'],
            ['sms', 'exam_mark_parent', '', 'Hello, [parent_name], your child [student_name] of class [class_name] ([section_name]) exam type [exam_type], [subject_marks]. School Name- [school_name], Thank You.', '', '[parent_name], [student_name], [class_name], [section_name], [exam_type], [subject_names], [total_mark], [school_name], [subject_marks]'],
        ];

        $schools = SmSchool::get(['id', 'school_name']);
        foreach ($schools as $school) {
            foreach ($allTempletes as $allTemplete) {
                if (!SmsTemplate::where('purpose', $allTemplete[1])->first()) {
                    $storeTemplete = new SmsTemplate();
                    $storeTemplete->type = $allTemplete[0];
                    $storeTemplete->purpose = $allTemplete[1];
                    $storeTemplete->subject = $allTemplete[2];
                    $storeTemplete->body = $allTemplete[3];
                    $storeTemplete->module = $allTemplete[4];
                    $storeTemplete->variable = $allTemplete[5];
                    $storeTemplete->school_id = $school->id;
                    $storeTemplete->save();
                }
            }
        }

        $s = new InfixModuleManager();
            $s->name = 'InfixBiometrics';
            $s->email = 'support@spondonit.com';
            $s->notes = "This is InfixBiometrics Module For Bio metrics attendance sync from local to application. Thanks For Using.";
            $s->version = "1.0";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "https://spondonit.com/contact";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_template', function (Blueprint $table) {
            //
        });
    }
}
