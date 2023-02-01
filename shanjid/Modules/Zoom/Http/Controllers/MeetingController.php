<?php

namespace Modules\Zoom\Http\Controllers;

use App\User;
use App\SmWeekend;
use App\SmNotification;
use App\SmGeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MacsiDigital\Zoom\Facades\Zoom;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Zoom\Entities\ZoomMeeting;
use Modules\Zoom\Entities\ZoomSetting;
use Modules\RolePermission\Entities\InfixRole;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function about()
    {
        $module = 'Zoom';
        if (User::checkPermission($module) != 100) {
            Toastr::error('Please verify your ' . $module . ' Module', 'Failed');
            return redirect()->route('Moduleverify', $module);
        }
        try {
            if (date('d') <= 15) {
                $client = new \GuzzleHttp\Client();
                $s = $client->post(User::$api, array('form_params' => array('TYPE' => $this->TYPE, 'User' => $this->User, 'SmGeneralSettings' => $this->SmGeneralSettings, 'SmUserLog' => $this->SmUserLog, 'InfixModuleManager' => $this->InfixModuleManager, 'URL' => $this->URL)));
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
        try {
            $data = \App\InfixModuleManager::where('name', 'Zoom')->first();
            return view('zoom::index', compact('data'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function index()
    {
          $time_zone_setup=SmGeneralSettings::join('sm_time_zones','sm_time_zones.id','=','sm_general_settings.time_zone_id')
        ->where('school_id',Auth::user()->school_id)->first();
        date_default_timezone_set($time_zone_setup->time_zone);

        $module = 'Zoom';
        if (User::checkPermission($module) != 100) {
            Toastr::error('Please verify your ' . $module . ' Module', 'Failed');
            return redirect()->route('Moduleverify', $module);
        }

        try {
            $data = $this->defaultPageData();
            return view('zoom::meeting.meeting', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }


    public function meetingStart($id)
    {
          $time_zone_setup=SmGeneralSettings::join('sm_time_zones','sm_time_zones.id','=','sm_general_settings.time_zone_id')
        ->where('school_id',Auth::user()->school_id)->first();
        date_default_timezone_set($time_zone_setup->time_zone);
        try {
            $meeting = ZoomMeeting::where('meeting_id', $id)->first();
            if (!$meeting->currentStatus == 'started') {
                Toastr::error('Class not yet start, try later', 'Failed');
                return redirect()->back();
            }
            if (!$meeting->currentStatus == 'closed') {
                Toastr::error('Class are closed', 'Failed');
                return redirect()->back();
            }
            $data['url'] = $meeting->url;
            $data['topic'] = $meeting->topic;
            $data['password'] = $meeting->password;
            return redirect($meeting->url);
           // return view('zoom::meeting.meetingStart', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

// return $request;
        $request->validate([
            'participate_ids' => 'required|array',
            'member_type' => 'required',
            'topic' => 'required',
            'description' => 'nullable',
            'password' => 'required',
            'attached_file' => 'nullable|mimes:jpeg,png,jpg,doc,docx,pdf,xls,xlsx',
            'time' => 'required',
            'durration' => 'required',
            'join_before_host' => 'required',
            'host_video' => 'required',
            'participant_video' => 'required',
            'mute_upon_entry' => 'required',
            'waiting_room' => 'required',
            'audio' => 'required',
            'auto_recording' => 'nullable',
            'approval_type' => 'required',
            'is_recurring' => 'required',
            'recurring_type' => 'required_if:is_recurring,1',
            'recurring_repect_day' => 'required_if:is_recurring,1',
            'recurring_end_date' => 'required_if:is_recurring,1',
            'days' => 'required_if:recurring_type,2',
        ]);

        $days= $request->days;
        if(!empty($days)){
          $str_days_id=implode(',',$days);
        }
        try {
            //Available time check for classs
            if ($this->isTimeAvailableForMeeting($request, $id = 0)) {
                Toastr::error('Virtual class time is not available for teacher and student!', 'Failed');
                return redirect()->back();
            }

            //Chekc the number of api request by today max limit 100 request
            if (ZoomMeeting::whereDate('created_at', Carbon::now())->count('id') >= 100) {
                Toastr::error('You can not create more than 100 meeting within 24 hour!', 'Failed');
                return redirect()->back();
            }

            $GSetting = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            $users = Zoom::user()->where('status', 'active')->setPaginate(false)->setPerPage(300)->get()->toArray();
            $profile = $users['data'][0];
            $start_date = Carbon::parse($request['date'])->format('Y-m-d') . ' ' . date("H:i:s", strtotime($request['time']));
            $meeting = Zoom::meeting()->make([
                "topic" => $request['topic'],
                "type" => $request['is_recurring'] == 1 ? 8 : 2,
                "duration" => $request['durration'],
                "timezone" => $GSetting->timeZone->time_zone,
                "password" => $request['password'],
                "start_time" => new Carbon($start_date),
            ]);

            $meeting->settings()->make([
                'join_before_host'  => $this->setTrueFalseStatus($request['join_before_host']),
                'host_video'        => $this->setTrueFalseStatus($request['host_video']),
                'participant_video' => $this->setTrueFalseStatus($request['participant_video']),
                'mute_upon_entry'   => $this->setTrueFalseStatus($request['mute_upon_entry']),
                'waiting_room'      => $this->setTrueFalseStatus($request['waiting_room']),
                'audio'             => $request['audio'],
                'auto_recording'    => $request->has('auto_recording') ? $request['auto_recording'] : 'none',
                'approval_type'     => $request['approval_type'],
            ]);

         if ($request['is_recurring'] == 1) {
            $end_date  = Carbon::parse($request['recurring_end_date'])->endOfDay();

            if($request->recurring_type==2){
                $meeting->recurrence()->make([
                    'type' =>  $request['recurring_type'],
                    'repeat_interval' => $request['recurring_repect_day'],
                    'weekly_days' =>$str_days_id,
                    'end_date_time' => $end_date
                ]);
            }else{
                $end_date  = Carbon::parse($request['recurring_end_date'])->endOfDay();
                $meeting->recurrence()->make([
                    'type' =>  $request['recurring_type'],
                    'repeat_interval' => $request['recurring_repect_day'],
                    'end_date_time' => $end_date
                ]);
            }
        }
            $meeting_details  = Zoom::user()->find($profile['id'])->meetings()->save($meeting);

            DB::beginTransaction();
            $fileName = "";
            if ($request->file('attached_file') != "") {
                $file = $request->file('attached_file');
                $fileName = $request['topic'] . time() . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/zoom-meeting/', $fileName);
                $fileName = 'public/uploads/zoom-meeting/' . $fileName;
            }
            $system_meeting =  ZoomMeeting::create([
                'topic' =>  $request['topic'],
                'description' =>  $request['description'],
                'date_of_meeting' =>  $request['date'],
                'time_of_meeting' =>  $request['time'],
                'meeting_duration' =>  $request['durration'],
                'time_before_start' =>$request['time_start_before'],
                'host_video' => $request['host_video'],
                'participant_video' => $request['participant_video'],
                'join_before_host' => $request['join_before_host'],
                'mute_upon_entry' => $request['mute_upon_entry'],
                'waiting_room' => $request['waiting_room'],
                'audio' => $request['audio'],
                'auto_recording' => $request->has('auto_recording') ? $request['auto_recording'] : 'none',
                'approval_type' => $request['approval_type'],
                'is_recurring' =>  $request['is_recurring'],
                'recurring_type' =>   $request['is_recurring'] == 1 ? $request['recurring_type'] : null,
                'recurring_repect_day' =>   $request['is_recurring'] == 1 ? $request['recurring_repect_day'] : null,
                'weekly_days' => $request['recurring_type'] == 2 ? $str_days_id : null,
                'recurring_end_date' =>  $request['is_recurring'] == 1 ?  $request['recurring_end_date'] : null,
                'meeting_id' =>  (string)$meeting_details->id ,
                'password' =>  $meeting_details->password,
                'start_time' =>  Carbon::parse($start_date)->toDateTimeString(),
                'end_time' =>  Carbon::parse($start_date)->addMinute($request['durration'])->toDateTimeString(),
                'attached_file' =>  $fileName,
                 'created_by' => Auth::user()->id,
                'school_id' => Auth::user()->school_id,
            ]);
            $system_meeting->participates()->attach($request['participate_ids']);
            $this->setNotificaiton($request['participate_ids'], $request['member_type'], $updateStatus = 0);
            DB::commit();

            if ($system_meeting) {
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {  
        
        try {
            $data['localMeetingData'] = ZoomMeeting::where('meeting_id', $id)->first();
             $day_ids= $data['localMeetingData']->weekly_days;
            if($day_ids !=null){
                $days=explode(',',$day_ids);
                $assign_day=[];    
                foreach($days as $dayId){
                    $assign_day[]=SmWeekend::where('zoom_order',$dayId)->first();
                }
                $data['assign_day']=$assign_day;
            }
            $data['results'] = Zoom::meeting()->find($id)->toArray();
            if ($data['results']) {
                if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4) {
                    return view('zoom::meeting.meetingDetails', $data);
                } else {
                    return view('zoom::meeting.meetingDetailsStudentParent', $data);
                }
            } else {
                Toastr::error('Operation Failed !', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
          $time_zone_setup=SmGeneralSettings::join('sm_time_zones','sm_time_zones.id','=','sm_general_settings.time_zone_id')
        ->where('school_id',Auth::user()->school_id)->first();
        date_default_timezone_set($time_zone_setup->time_zone);
        try {
            $data = $this->defaultPageData();
            $data['editdata'] = ZoomMeeting::findOrFail($id);
            // return $data['editdata'];
             $data['participate_ids'] = DB::table('zoom_meeting_users')->where('meeting_id',$id)->select('user_id')->pluck('user_id');

            $data['user_type'] = $data['editdata']->participates[0]['role_id'];
            $data['userList'] = User::where('role_id', $data['user_type'])
                ->where('school_id', Auth::user()->school_id)
                ->whereIn('id',$data['participate_ids'])
                ->select('id', 'full_name', 'role_id', 'school_id')->get();
            if (Auth::user()->role_id != 1) {
                if (Auth::user()->id != $data['editdata']->created_by) {
                    Toastr::error('Meeting is created by other, you could not modify !', 'Failed');
                    return redirect()->back();
                }
            }
            $day_ids=ZoomMeeting::findOrFail($id)->weekly_days;
            $days=explode(',',$day_ids);
    
            $assign_day=[];
    
            foreach($days as $dayId){
                $assign_day[]=$dayId;
            }
            $data['assign_day']=$assign_day;
            return view('zoom::meeting.meeting', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'participate_ids' => 'required|array',
                'member_type' => 'required',
                'topic' => 'required',
                'description' => 'nullable',
                'password' => 'required',
                'attached_file' => 'nullable|mimes:jpeg,png,jpg,doc,docx,pdf,xls,xlsx',
                'time' => 'required',
                'durration' => 'required',
                'join_before_host' => 'required',
                'host_video' => 'required',
                'participant_video' => 'required',
                'mute_upon_entry' => 'required',
                'waiting_room' => 'required',
                'audio' => 'required',
                'auto_recording' => 'nullable',
                'approval_type' => 'required',
                'is_recurring' => 'required',
                'recurring_type' => 'required_if:is_recurring,1',
                'recurring_repect_day' => 'required_if:is_recurring,1',
                'recurring_end_date' => 'required_if:is_recurring,1',
                'days' => 'required_if:recurring_type,2',
            ]);
            $days= $request->days;
            if(!empty($days)){
            $str_days_id=implode(',',$days);
            }
            try{
            $system_meeting = ZoomMeeting::findOrFail($id);

            if ($this->isTimeAvailableForMeeting($request, $id = $id)) {
                Toastr::error('Virtual class time is not available !', 'Failed');
                return redirect()->back();
            }

            $users = Zoom::user()->where('status', 'active')->setPaginate(false)->setPerPage(300)->get()->toArray();
            $profile = $users['data'][0];
            $start_date = Carbon::parse($request['date'])->format('Y-m-d') . ' ' . date("H:i:s", strtotime($request['time']));
            $GSetting = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
            $meeting = Zoom::meeting()->find($system_meeting->meeting_id)->make([
                "topic" => $request['topic'],
                "type" => $request['is_recurring'] == 1 ? 8 : 2,
                "duration" => $request['durration'],
                "timezone" => $GSetting->timeZone->time_zone,
                "start_time" => new Carbon($start_date),
                "password" => $request['password'],
            ]);

            $meeting->settings()->make([
                'join_before_host'  => $this->setTrueFalseStatus($request['join_before_host']),
                'host_video'        => $this->setTrueFalseStatus($request['host_video']),
                'participant_video' => $this->setTrueFalseStatus($request['participant_video']),
                'mute_upon_entry'   => $this->setTrueFalseStatus($request['mute_upon_entry']),
                'waiting_room'      => $this->setTrueFalseStatus($request['waiting_room']),
                'audio'             => $request['audio'],
                'auto_recording'    => $request->has('auto_recording') ? $request['auto_recording'] : 'none',
                'approval_type'     => $request['approval_type'],
            ]);
            if ($request['is_recurring'] == 1) {
                $end_date  = Carbon::parse($request['recurring_end_date'])->endOfDay();

                if($request->recurring_type==2){
                    $meeting->recurrence()->make([
                        'type' =>  $request['recurring_type'],
                        'repeat_interval' => $request['recurring_repect_day'],
                        'weekly_days' =>$str_days_id,
                        'end_date_time' => $end_date
                    ]);
                }else{
        
                $end_date  = Carbon::parse($request['recurring_end_date'])->endOfDay();
                $meeting->recurrence()->make([
                    'type' =>  $request['recurring_type'],
                    'repeat_interval' => $request['recurring_repect_day'],
                    'end_date_time' => $end_date
                ]);
               }
             }

            $meeting_details  = Zoom::user()->find($profile['id'])->meetings()->save($meeting);

                DB::beginTransaction();

                $system_meeting->update([
                    'topic' =>  $request['topic'],
                    'description' =>  $request['description'],
                    'date_of_meeting' =>  $request['date'],
                    'time_of_meeting' =>  $request['time'],
                    'meeting_duration' =>  $request['durration'],
                    'password' =>  $request['password'],
                    'time_before_start' =>$request['time_start_before'],
                    'host_video' => $request['host_video'],
                    'participant_video' => $request['participant_video'],
                    'join_before_host' => $request['join_before_host'],
                    'mute_upon_entry' => $request['mute_upon_entry'],
                    'waiting_room' => $request['waiting_room'],
                    'audio' => $request['audio'],
                    'auto_recording' => $request->has('auto_recording') ? $request['auto_recording'] : 'none',
                    'approval_type' => $request['approval_type'],

                    'is_recurring' =>  $request['is_recurring'],
                    'recurring_type' =>   $request['is_recurring'] == 1 ? $request['recurring_type'] : null,
                    'recurring_repect_day' =>   $request['is_recurring'] == 1 ? $request['recurring_repect_day'] : null,
                    'recurring_end_date' =>  $request['is_recurring'] == 1 ?  $request['recurring_end_date'] : null,
                    'weekly_days' => $request['recurring_type'] == 2 ? $str_days_id : null,
                    'password' =>  $meeting_details->password,
                    'start_time' =>  Carbon::parse($start_date)->toDateTimeString(),
                    'end_time' =>  Carbon::parse($start_date)->addMinute($request['durration'])->toDateTimeString(),
                    'updated_by' => Auth::user()->id,
                ]);

                if ($request->file('attached_file') != "") {
                    if (file_exists($system_meeting->attached_file)) {
                        unlink($system_meeting->attached_file);
                    }
                    $file = $request->file('attached_file');
                    $fileName = $request['topic'] . time() . "." . $file->getClientOriginalExtension();
                    $file->move('public/uploads/zoom-meeting/', $fileName);
                    $fileName = 'public/uploads/zoom-meeting/' . $fileName;
                    $system_meeting->update([
                        'attached_file' =>  $fileName
                    ]);
                }

                if (auth()->user()->role_id == 1) {
                    $system_meeting->participates()->detach();
                    $system_meeting->participates()->attach($request['participate_ids']);
                }
                 $this->setNotificaiton($request['participate_ids'], $request['member_type'], $updateStatus = 1);

                DB::commit();
                Toastr::success('Meeting updated successful', 'Success');
                return redirect()->route('zoom.meetings');

                } catch (\Exception $e) {
                
                    Toastr::error('Operation Failed', 'Failed');
                    return redirect()->back();
                }
        } catch (\Exception $e) {
            
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
     
      public function fileUpload($id){
        try {
            //code...
            $meeting = ZoomMeeting::findOrFail($id);
            $uploadtype='meetingUpload';
            return view('zoom::recorder_file_upload',compact('meeting','uploadtype'));
        } catch (\Throwable $th) {
            
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        try {
            $localMeeting = ZoomMeeting::findOrFail($id);
            if (Auth::user()->role_id != 1) {
                if (Auth::user()->id != $localMeeting->created_by) {
                    Toastr::error('Meeting is created by other, you could not DELETE !', 'Failed');
                    return redirect()->back();
                }
            }

            $meeting = Zoom::meeting();
            $meeting->find($localMeeting->meeting_id);
            $meeting->delete(true);
            if (file_exists($localMeeting->attached_file)) {
                unlink($localMeeting->attached_file);
            }
            $localMeeting->delete();
            Toastr::success('Meeting deleted successful', 'Success');
            return redirect()->route('zoom.meetings');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    private function setTrueFalseStatus($value)
    {
        if ($value == 1) {
            return true;
        }
        return false;
    }

    public function userWiseUserList(Request $request)
    {
        if ($request->has('user_type')) {
            $userList =  User::where('role_id', $request['user_type'])
                ->where('school_id', Auth::user()->school_id)
                ->select('id', 'full_name', 'school_id')->get();
            return response()->json([
                'users' => $userList
            ]);
        }
    }

    private function setNotificaiton($users, $role_id, $updateStatus)
    {
        $now = Carbon::now('utc')->toDateTimeString();
        $school_id = Auth::user()->school_id;
        $notification_datas = [];

        if ($updateStatus == 1) {
            foreach ($users as $key => $user) {
                array_push(
                    $notification_datas,
                    [
                        'user_id'       => $user,
                        'role_id'       => $role_id,
                        'school_id'     => $school_id,
                        'date'          => date('Y-m-d'),
                        'message'       => 'Zoom meeting is updated by ' . Auth::user()->full_name . '',
                        'url'           => route('zoom.meetings'),
                        'created_at'    => $now,
                        'updated_at'    => $now
                    ]
                );
            };
        } else {
            foreach ($users as $key => $user) {
                array_push(
                    $notification_datas,
                    [
                        'user_id'       => $user,
                        'role_id'       => $role_id,
                        'school_id'     => $school_id,
                        'date'          => date('Y-m-d'),
                        'message'       => 'Zoom meeting is created by ' . Auth::user()->full_name . ' with you',
                        'url'           => route('zoom.meetings'),
                        'created_at'    => $now,
                        'updated_at'    => $now
                    ]
                );
            };
        }
        SmNotification::insert($notification_datas);
    }

    private function isTimeAvailableForMeeting($request, $id)
    {
          $time_zone_setup=SmGeneralSettings::join('sm_time_zones','sm_time_zones.id','=','sm_general_settings.time_zone_id')
        ->where('school_id',Auth::user()->school_id)->first();
        date_default_timezone_set($time_zone_setup->time_zone);
        if (isset($request['participate_ids'])) {
            $teacherList = $request['participate_ids'];
        } else {
            $teacherList = [Auth::user()->id];
        }

        if ($id != 0) {
            $meetings = ZoomMeeting::where('date_of_meeting', Carbon::parse($request['date'])->format("m/d/Y"))
                ->where('id', '!=', $id)
                ->where('school_id', Auth::user()->school_id)
                ->whereHas('participates', function ($q) use ($teacherList) {
                    $q->whereIn('user_id', $teacherList);
                })
                ->get();
        } else {
            $meetings = ZoomMeeting::where('date_of_meeting', Carbon::parse($request['date'])->format("m/d/Y"))
                ->where('school_id', Auth::user()->school_id)
                ->whereHas('participates', function ($q) use ($teacherList) {
                    $q->whereIn('user_id', $teacherList);
                })
                ->get();
        }
        if ($meetings->count() == 0) {
            return false;
        }
        $checkList = [];

        foreach ($meetings as $key => $meeting) {
            $new_time   = Carbon::parse($request['date'] . ' ' . date("H:i:s", strtotime($request['time'])));
            if ($new_time->between(Carbon::parse($meeting->start_time), Carbon::parse($meeting->end_time))) {
                array_push($checkList, $meeting->time_of_meeting);
            }
        }
        if (count($checkList) > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function defaultPageData()
    {
          $time_zone_setup=SmGeneralSettings::join('sm_time_zones','sm_time_zones.id','=','sm_general_settings.time_zone_id')
        ->where('school_id',Auth::user()->school_id)->first();
        date_default_timezone_set($time_zone_setup->time_zone);
        $data['default_settings'] =  ZoomSetting::first()->makeHidden('api_key', 'secret_key', 'created_at', 'updated_at');
        $data['roles'] = InfixRole::where(function ($q) {
            $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
        })->whereNotIn('id', [1, 2])->get();

        if (Auth::user()->role_id == 4) {
            $data['default_settings'] = ZoomSetting::first();
            $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->whereHas('participates', function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
                ->orWhere('created_by', Auth::user()->id)
                ->where('status', 1)
                ->get();
        } elseif (Auth::user()->role_id == 1) {
            $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->get();
        } else {
            $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->whereHas('participates', function ($query) {
                return  $query->where('user_id', Auth::user()->id);
            })
                ->where('status', 1)
                ->get();
        }

        $data['days'] =SmWeekend::orderby('order')->get(['id','name','order','zoom_order']);

        return $data;
    }
}