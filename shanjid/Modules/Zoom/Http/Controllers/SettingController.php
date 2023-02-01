<?php

namespace Modules\Zoom\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Zoom\Entities\ZoomSetting;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function settings()
    {

        $module = 'Zoom';
        if (User::checkPermission($module) != 100) {
            Toastr::error('Please verify your ' . $module . ' Module', 'Failed');
            return redirect()->route('Moduleverify', $module);
        }

        try {
            $data['setting'] = ZoomSetting::first();
            return view('zoom::settings', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'package_id' => 'required',
            'host_video' => 'required',
            'participant_video' => 'required',
            'join_before_host' => 'required',
            'audio' => 'required',
            'auto_recording' => 'required',
            'approval_type' => 'required',
            'mute_upon_entry' => 'required',
            'waiting_room' => 'required',
            'secret_key' => 'required',
            'api_key' => 'required',
        ]);
       if($request->api_use_for=='on'){
            $status=1;
       }else{
        $status=0;
       }
        try {
            $settings =  ZoomSetting::first();
            $settings->update([
                'package_id' => $request['package_id'],
                'host_video' => $request['host_video'],
                'participant_video' => $request['participant_video'],
                'join_before_host' => $request['join_before_host'],
                'audio' => $request['audio'],
                'auto_recording' => $request['auto_recording'],
                'approval_type' => $request['approval_type'],
                'mute_upon_entry' => $request['mute_upon_entry'],
                'waiting_room' => $request['waiting_room'],
                'api_use_for' => $status,
                'api_key' => $request['api_key'],
                'secret_key' => $request['secret_key']
            ]);

            $this->putEnvConfigration('ZOOM_CLIENT_KEY', $request['api_key']);
            $this->putEnvConfigration('ZOOM_CLIENT_SECRET', $request['secret_key']);
            Artisan::call('config:clear');
            Toastr::success('Zoom Setting updated successfully !', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }
    public function updateIndSettings(Request $request){
        // return $request->all();
        $request->validate([
            'secret_key' => 'required',
            'api_key' => 'required',
        ]);
      $settings =  User::find(Auth::user()->id);
      $settings->zoom_api_key_of_user= $request['api_key'];
      $settings->zoom_api_serect_of_user=$request['secret_key'];
      $settings->save();
        return redirect()->back();
    }

    private function putEnvConfigration($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $key . '=' . env($key),
                $key . '=' . $value,
                file_get_contents($path)
            ));
        }
    }
}
