<?php

use App\SmSchool;
use App\SmsTemplate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddSmsFunctionTable extends Migration
{
    public function up()
    {
        Schema::table('sm_subject_attendances', function (Blueprint $table){
            $table->boolean('notify')->default(false);
        });
        $schools = SmSchool::get();
        foreach($schools as $school){
            $studenAttandance = SmsTemplate::where('purpose', 'parent_leave_approve_for_student')->where('school_id', $school->id)->first();
            $studenAttandance->body= str_replace('[staff_name]','[parent_name]',$studenAttandance->body);
            $studenAttandance->variable= str_replace('[staff_name]','[parent_name]',$studenAttandance->variable);
            $studenAttandance->save();

            $holiday = SmsTemplate::where('purpose', 'holiday')->where('school_id', $school->id)->first();
            $holiday->body= str_replace('[holiday_name]',' ',$holiday->body);
            $holiday->variable= str_replace('[holiday_name]',' ',$holiday->variable);
            $holiday->save();

            $BioMat1 = SmsTemplate::where('purpose', 'student_checkout')->where('school_id', $school->id)->first();
            $BioMat1->module= "InfixBiometrics";
            $BioMat1->save();

            $BioMat2 = SmsTemplate::where('purpose', 'student_early_checkout')->where('school_id', $school->id)->first();
            $BioMat2->module= "InfixBiometrics";
            $BioMat2->save();

            $check1 = SmsTemplate::where('purpose', 'student_fees_due')->where('school_id', $school->id)->first();
            if(!$check1){
                $storeFeesDueStudent = new SmsTemplate();
                $storeFeesDueStudent->type = "sms";
                $storeFeesDueStudent->purpose = "student_fees_due";
                $storeFeesDueStudent->subject = "";
                $storeFeesDueStudent->body = "Hi [student_name], You fees due amount [dues_amount] for [fees_name] on [date]. Thank You [school_name]";
                $storeFeesDueStudent->module = "";
                $storeFeesDueStudent->variable = "[student_name], [dues_amount], [fees_name], [date], [school_name]";
                $storeFeesDueStudent->status = 1;
                $storeFeesDueStudent->school_id = $school->id;
                $storeFeesDueStudent->save();
            }

            $check2 = SmsTemplate::where('purpose', 'student_fees_due_for_parent')->where('school_id', $school->id)->first();
            if(!$check2){
                $storeFeesDueStudent = new SmsTemplate();
                $storeFeesDueStudent->type = "sms";
                $storeFeesDueStudent->purpose = "student_fees_due_for_parent";
                $storeFeesDueStudent->subject = "";
                $storeFeesDueStudent->body = "Hi [parent_name], You fees due amount [dues_amount] for [fees_name] on [date]. Thank You [school_name]";
                $storeFeesDueStudent->module = "";
                $storeFeesDueStudent->variable = "[parent_name], [dues_amount], [fees_name], [date], [school_name]";
                $storeFeesDueStudent->status = 1;
                $storeFeesDueStudent->school_id = $school->id;
                $storeFeesDueStudent->save();
            }

            $check3 = SmsTemplate::where('purpose', 'due_fees_payment')->where('school_id', $school->id)->first();
            if(!$check3){
                $storeFeesDueStudent = new SmsTemplate();
                $storeFeesDueStudent->type = "email";
                $storeFeesDueStudent->purpose = "due_fees_payment";
                $storeFeesDueStudent->subject = "Duee Fees Payment";
                $storeFeesDueStudent->body = '
                                            <table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container" style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;" width="100%">
                                            <tbody>
                                                <tr style="vertical-align:top;" valign="top">
                                                    <td style="vertical-align:top;" valign="top">
                                                        <div style="background-color:#415094;">
                                                            <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                                                                <div style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                                                                    <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                                                        <div class="col_cont" style="width:100%;">
                                                                            <div align="center" class="img-container center fixedwidth" style="padding-right:30px;padding-left:30px;">
                                                                                <a href="#">
                                                                                    <img border="0" class="center fixedwidth" src="" style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;" width="150" alt="logo.png">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="background-color:#415094;">
                                                            <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                                                                <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                                                                    <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                                                        <div class="col_cont" style="width:100%;">
                                                                            <div align="center" class="img-container center autowidth" style="padding-right:20px;padding-left:20px;">
                                                                                <img border="0" class="center autowidth" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU" style="text-decoration:none;height:auto;border:0;max-width:541px;" width="541" alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="background-color:#7c32ff;">
                                                            <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                                                                <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                                                                    <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                                                        <div class="col_cont" style="width:100%;">
                                                                            <h1 style="line-height:120%;text-align:center;margin-bottom:0px;">
                                                                                <font color="#555555" face="Arial, Helvetica Neue, Helvetica, sans-serif">
                                                                                    <span style="font-size:36px;">Dues Payment</span>
                                                                                </font>
                                                                            </h1>
                                                                            <div style="line-height:1.8;padding:20px 15px;">
                                                                                <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                                                                    <h1>Hi [student_name],</h1>
                                                                                    <p style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                                                        You fees due amount [due_amount] for [fees_name] on [date]. Thank You, [school_name]
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="background-color:#7c32ff;">
                                                            <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                                                                <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                                                                    <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                                                        <div class="col_cont" style="width:100%;">
                                                                            <div style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                                                                <div class="txtTinyMce-wrapper" style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                                                                    <p style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                                                        <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                                                            © 2020 Infix Education software|
                                                                                        </span>
                                                                                        <span style="background-color:transparent;text-align:left;">
                                                                                            <font color="#ffffff">
                                                                                                Copyright &copy; 2020 All rights reserved | This application is made by Codethemes
                                                                                            </font>
                                                                                        </span>
                                                                                        <br>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                            ';
                $storeFeesDueStudent->module = "";
                $storeFeesDueStudent->variable = "[student_name], [due_amount], [fees_name], [date], [school_name]";
                $storeFeesDueStudent->status = 1;
                $storeFeesDueStudent->school_id = $school->id;
                $storeFeesDueStudent->save();
            }
        }
    }

    public function down()
    {
        Schema::dropIfExists('add_sms_function');
    }
}
