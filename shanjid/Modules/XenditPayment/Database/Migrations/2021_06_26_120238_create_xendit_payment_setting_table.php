<?php

use App\SmSchool;
use App\SmPaymentMethhod;
use App\SmPaymentGatewaySetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXenditPaymentSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{

        if (moduleStatusCheck('Saas') == TRUE) {
            $schools = SmSchool::all();
            foreach ($schools as $school) {
                $is_method = SmPaymentMethhod::where('method', 'Xendit')->where('school_id', $school->id)->first();
                if (empty($is_method)) {
                    $is_method = new SmPaymentMethhod();
                }
                $is_method->method = 'Xendit';
                $is_method->type = 'Module';
                $is_method->active_status = 1;
                $is_method->school_id = $school->id;
                $is_method->created_at = date('Y-m-d h:i:s');
                $is_method->save();


                $is_setting = SmPaymentGatewaySetting::where('gateway_name', 'Xendit')->where('school_id', $school->id)->first();
                if ($is_setting == "") {
                    $is_method = new SmPaymentGatewaySetting();
                    $is_method->gateway_name = 'Xendit';
                    $is_method->gateway_username = 'demo@xendit.co';
                    $is_method->gateway_password = '123456';
                    $is_method->school_id = $school->id;
                    $is_method->created_at = date('Y-m-d h:i:s');
                    $is_method->save();
                }
            }
        } else {

            $is_method = SmPaymentMethhod::where('method', 'Xendit')->where('school_id', 1)->first();
            if (empty($is_method)) {
                $is_method = new SmPaymentMethhod();
            }
            $is_method->method = 'Xendit';
            $is_method->type = 'Module';
            $is_method->active_status = 1;
            $is_method->created_at = date('Y-m-d h:i:s');
            $is_method->save();

            $is_setting = SmPaymentGatewaySetting::where('gateway_name', 'Xendit')->where('school_id', 1)->first();
            if ($is_setting == "") {
                $is_setting = new SmPaymentGatewaySetting();
            }
            $is_setting->gateway_name = 'Xendit';
            $is_setting->gateway_username = 'demo@xendit.co';
            $is_setting->gateway_password = '123456';
            $is_setting->created_at = date('Y-m-d h:i:s');
            $is_setting->save();
        }
        
    } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xendit_payment_setting');
    }
}
