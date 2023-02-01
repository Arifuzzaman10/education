<?php

use App\SmsTemplate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateAddSchoolNameVariableSmsTemplateTable extends Migration
{
    public function up()
    {
        $allDatas = SmsTemplate::all();
        foreach($allDatas as $allData){
            $existsData = str_contains($allData->variable, "[school_name]");
            $allData->variable = ($existsData) ? $allData->variable : $allData->variable.", [school_name]";
            $allData->save();
        }
        
        $templete = SmsTemplate::where('purpose', 'student_dues_fees')->first();
        $templete1 = SmsTemplate::where('purpose', 'student_dues_fees_for_parent')->first();

        $studentUpdate = SmsTemplate::find($templete->id);
        $studentUpdate->module = 'Fees';
        $studentUpdate->variable = '[student_name], [dues_amount], [fees_name], [date], [school_name]';
        $studentUpdate->save();

        $parentUpdate = SmsTemplate::find($templete1->id);
        $parentUpdate->module = 'Fees';
        $parentUpdate->variable = '[parent_name], [dues_amount], [fees_name], [date], [school_name]';
        $parentUpdate->save();
    }

    public function down()
    {
        Schema::dropIfExists('add_school_name_variable_sms_template');
    }
}
