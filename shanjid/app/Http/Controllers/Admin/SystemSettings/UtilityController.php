<?php

namespace App\Http\Controllers\Admin\SystemSettings;

use App\SmSmsGateway;
use GuzzleHttp\Client;
use App\SmLanguagePhrase;
use App\InfixModuleManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixPermissionAssign;
use Modules\RolePermission\Entities\InfixModuleStudentParentInfo;

class UtilityController extends Controller
{
    public function index(){
        try {
            
            return view('backEnd.systemSettings.utilityView');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function action($action){

        if (config('app.app_sync')) {
            Toastr::error('Restricted in demo mode');
            return back();
        }
        try {

            $message = "";

            if($action =="optimize_clear"){
                
                \Artisan::call('optimize:clear');
                
                $message = "Your System Optimization Successfully Complete";
               
                
            }
            elseif($action =="clear_log"){
                file_put_contents(storage_path('logs/laravel.log'),'');

                $message = "Your System Log File Is Cleared";
            }
            elseif($action =="change_debug"){
                if(env('APP_DEBUG')){
                    envu([
                        'APP_ENV' => 'Production',
                        'APP_DEBUG'     =>  'false',
                        ]);

                        $message = "Debug Mode Disable Successfully ";
                }
                else{
                    envu([
                        'APP_ENV' => 'Production',
                        'APP_DEBUG'     =>  'true',
                        ]);

                        $message = "Debug Mode Enable Successfully ";
                }
                
            }
            elseif($action =="force_https"){
                if(env('FORCE_HTTPS')){
                    envu([
                        'FORCE_HTTPS'     =>  'false',
                        ]);

                        $message = "HTTPS Mode Disable Successfully ";
                }
                else{
                    envu([
                        'FORCE_HTTPS'     =>  'true',
                        ]);

                        $message = "HTTPS Mode Enable Successfully ";
                }
            }

            Toastr::success($message , 'Success');
            
            return redirect()->back();
      
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function testup(){
        try{

            $gateway = SmSmsGateway::where('gateway_name','Himalayasms')->first();

            
            $client = new Client();
		    $request = $client->get( "https://sms.techhimalaya.com/base/smsapi/index.php", [
			'query' => [
				'key' => $gateway->himalayasms_key,
				'senderid' => $gateway->himalayasms_senderId,
				'campaign' => $gateway->himalayasms_campaign,
				'routeid' => $gateway->himalayasms_routeId ,
				'contacts' => "+9779865383233",
				'msg' => "Hello I am from infixedu, It Is test example sms",
				'type' => "text"
			],
			'http_errors' => false
		]);

		$response = $request->getBody();
    }catch (\Exception $e) {
        Log::info($e->getMessage());
    }
    }
}
