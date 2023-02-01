<?php

namespace Modules\Zoom\Http\Controllers;


use App\User;
use App\SmClass;
use App\SmStaff;
use App\SmSection;
use App\SmStudent;
use App\YearCheck;
use App\ApiBaseMethod;
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
use Modules\Zoom\Entities\VirtualClass;
use Illuminate\Support\Facades\Validator;
use Modules\RolePermission\Entities\InfixRole;

class ZoomApiController extends Controller
{

 

    public function zoomMakeMeeting($id){
       try {
                $user_info=User::find($id);
                $data['default_settings'] =  ZoomSetting::first()->makeHidden('api_key', 'secret_key', 'created_at', 'updated_at');
                $data['roles'] = InfixRole::where(function ($q) use($user_info)  {
                    $q->where('school_id',  $user_info->school_id)->orWhere('type', 'System');
                })->whereNotIn('id', [1, 2])
                ->select('id','name')->get();

                if ( $user_info->role_id == 4) {
                    $data['default_settings'] = ZoomSetting::first();
                    $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->whereHas('participates', function ($query) use($user_info) {
                        return $query->where('user_id',  $user_info->id);
                    })
                        ->orWhere('created_by',  $user_info->id)
                        ->where('status', 1)
                        ->get();
                } elseif ( $user_info->role_id == 1) {
                    $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->get();
                } else {
                    $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->whereHas('participates', function ($query)  use($user_info) {
                        return  $query->where('user_id',  $user_info->id);
                    })
                        ->where('status', 1)
                        ->get();
                }
                return ApiBaseMethod::sendResponse($data, null);
            } catch (\Throwable $th) {
                    return ApiBaseMethod::sendError('Something went wrong, please try again.');
            } 
        
    }
    public function zoomMemberList($user_role){
        try {
           $data['users_list']=User::where('role_id',$user_role)->select('id','full_name','username','email','is_administrator','role_id')->get();
            return ApiBaseMethod::sendResponse($data, null);

        } catch (\Throwable $th) {
            return ApiBaseMethod::sendError('Something went wrong, please try again.');
        } 
    }

        private function isTimeAvailableForMeeting($request, $id)
    {
        $creator_info=User::find($request->creator_id);
        if (isset($request['participate_ids'])) {
            $teacherList = $request['participate_ids'];
        } else {
            $teacherList = [$creator_info->id];
        }

        if ($id != 0) {
            $meetings = ZoomMeeting::where('date_of_meeting', Carbon::parse($request['date'])->format("m/d/Y"))
                ->where('id', '!=', $id)
                ->where('school_id', $creator_info->school_id)
                ->whereHas('participates', function ($q) use ($teacherList) {
                    $q->whereIn('user_id', $teacherList);
                })
                ->get();
        } else {
            $meetings = ZoomMeeting::where('date_of_meeting', Carbon::parse($request['date'])->format("m/d/Y"))
                ->where('school_id', $creator_info->school_id)
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
      private function setTrueFalseStatus($value)
    {
        if ($value == 1) {
            return true;
        }
        return false;
    }

        private function setNotificaiton($users, $role_id, $updateStatus,$creator_info)
    {
        $now = Carbon::now('utc')->toDateTimeString();
        $school_id = $creator_info->school_id;
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
                        'message'       => 'Zoom meeting is updated by ' .$creator_info->full_name . '',
                        'url'           => route('zoom.meetings.index'),
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
                        'message'       => 'Zoom meeting is created by ' .$creator_info->full_name . ' with you',
                        'url'           => route('zoom.meetings.index'),
                        'created_at'    => $now,
                        'updated_at'    => $now
                    ]
                );
            };
        }
        SmNotification::insert($notification_datas);
    }
    public function zoomStoreMeeting(Request $request){



      $input = $request->all();

        $validator = Validator::make($input, [
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
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }




        try {
             $creator_info=User::find($request->creator_id);
            //Available time check for classs
            if ($this->isTimeAvailableForMeeting($request, $id = 0)) {
                 return ApiBaseMethod::sendError('Time is not available for teacher and student!');
            }

            //Chekc the number of api request by today max limit 100 request
            if (ZoomMeeting::whereDate('created_at', Carbon::now())->count('id') >= 100) {
                return ApiBaseMethod::sendError('You can not create more than 100 meeting within 24 hour!');
            }

            $GSetting = SmGeneralSettings::where('school_id', $creator_info->school_id)->first();
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
                $meeting->recurrence()->make([
                    'type' =>  $request['recurring_type'],
                    'repeat_interval' => $request['recurring_repect_day'],
                    'end_date_time' => $end_date
                ]);
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
                'meeting_id' =>  $meeting_details->id,
                'password' =>  $meeting_details->password,
                'start_time' =>  Carbon::parse($start_date)->toDateTimeString(),
                'end_time' =>  Carbon::parse($start_date)->addMinute($request['durration'])->toDateTimeString(),
                'attached_file' =>  $fileName,
                'created_by' =>  $creator_info->id,
                'school_id' =>  $creator_info->school_id
            ]);
            $system_meeting->participates()->attach($request['participate_ids']);
            $this->setNotificaiton($request['participate_ids'], $request['member_type'], $updateStatus = 0, $creator_info);
            DB::commit();

            if ($system_meeting) {
                return ApiBaseMethod::sendResponse('', 'Meeting created');
            } else {
                 return ApiBaseMethod::sendError('Something went wrong, please try again.');
            }
        } catch (\Exception $e) { 
             return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
    }
      
    public function zoomEditMeeting($meeting_id,$user_id){
        try {
                 $user_info=User::find($user_id);
                $data['default_settings'] =  ZoomSetting::first()->makeHidden('api_key', 'secret_key', 'created_at', 'updated_at');
                $data['roles'] = InfixRole::where(function ($q) use($user_info)  {
                    $q->where('school_id',  $user_info->school_id)->orWhere('type', 'System');
                })->whereNotIn('id', [1, 2])->get();

                if ( $user_info->role_id == 4) {
                    $data['default_settings'] = ZoomSetting::first();
                    $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->whereHas('participates', function ($query) use($user_info) {
                        return $query->where('user_id',  $user_info->id);
                    })
                        ->orWhere('created_by',  $user_info->id)
                        ->where('status', 1)
                        ->get();
                } elseif ( $user_info->role_id == 1) {
                    $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->get();
                } else {
                    $data['meetings'] = ZoomMeeting::orderBy('id', 'DESC')->whereHas('participates', function ($query)  use($user_info) {
                        return  $query->where('user_id',  $user_info->id);
                    })
                        ->where('status', 1)
                        ->get();
                }


                $data['editdata'] = ZoomMeeting::findOrFail($meeting_id);
                $data['user_type'] = $data['editdata']->participates[0]['role_id'];
                $data['userList'] = User::where('role_id', $data['user_type'])
                    ->where('school_id', $user_info->school_id)
                    ->select('id', 'full_name', 'role_id', 'school_id')->get();
                if ($user_info->role_id != 1) {
                if ($user_info->id != $data['editdata']->created_by) {
                    return ApiBaseMethod::sendError('Meeting is created by other, you could not modify !');
                }
            }
            return ApiBaseMethod::sendResponse($data, null);
        } catch (\Exception $e) {
            return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
    }
    public function zoomUpdateMeeting(Request $request){
  
    $input = $request->all();

        $validator = Validator::make($input, [
            'participate_ids' => 'required|array',
            'member_type' => 'required',
            'meeting_id' => 'required',
            'creator_id' => 'required',
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
        ]);

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        try{
             $creator_info=User::find($request->creator_id);
        $system_meeting = ZoomMeeting::findOrFail($request->meeting_id);

        if ($this->isTimeAvailableForMeeting($request, $id = $request->meeting_id)) {
           return ApiBaseMethod::sendError('Time is not available !');
        }

        $users = Zoom::user()->where('status', 'active')->setPaginate(false)->setPerPage(300)->get()->toArray();
        $profile = $users['data'][0];
        $start_date = Carbon::parse($request['date'])->format('Y-m-d') . ' ' . date("H:i:s", strtotime($request['time']));
        $GSetting = SmGeneralSettings::where('school_id', $creator_info->school_id)->first();
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
            $meeting->recurrence()->make([
                'type' =>  $request['recurring_type'],
                'repeat_interval' => $request['recurring_repect_day'],
                'end_date_time' => $end_date
            ]);
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

            'password' =>  $meeting_details->password,
            'start_time' =>  Carbon::parse($start_date)->toDateTimeString(),
            'end_time' =>  Carbon::parse($start_date)->addMinute($request['durration'])->toDateTimeString(),
            'created_by' =>  $creator_info->id,
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

        if ($creator_info->role_id == 1) {
            $system_meeting->participates()->detach();
            $system_meeting->participates()->attach($request['participate_ids']);
        }
        $this->setNotificaiton($request['participate_ids'], $request['member_type'], $updateStatus = 1,$creator_info);

        DB::commit();
         return ApiBaseMethod::sendResponse(null, 'Meeting updated');

        } catch (\Exception $e) {
            return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
    }

    public function zoomDeleteMeeting($id){
        try {
            $localMeeting = ZoomMeeting::findOrFail($id);
            $meeting = Zoom::meeting();
            $meeting->find($localMeeting->meeting_id);
            $meeting->delete(true);
            if (file_exists($localMeeting->attached_file)) {
                unlink($localMeeting->attached_file);
            }
            $localMeeting->delete();
            return ApiBaseMethod::sendResponse(null, 'Meeting deleted');
        } catch (\Exception $e) {
             return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
        }

    public function meetingStart($id,$user_id)
    {
            try {

                $user_info=User::find($user_id);
                $meeting = ZoomMeeting::where('meeting_id', $id)->first();

                

                $GSetting = SmGeneralSettings::where('school_id', $user_info->school_id)->first();
                $now = Carbon::now()->setTimezone($GSetting->timeZone->time_zone);

            if($meeting->is_recurring == 1){
                if($now->between(Carbon::parse($meeting->start_time)->addMinute(-10)->format('Y-m-d H:i:s'), Carbon::parse($meeting->recurring_end_date)->endOfDay()->format('Y-m-d H:i:s'))){
                   $status= 'started';
                }
                if(!$now->gt(Carbon::parse($meeting->recurring_end_date)->addMinute(-10))){
                   $status= 'waiting';
                }
               $status= 'closed';
            }else{
                if($now->between(Carbon::parse($meeting->start_time)->addMinute(-10)->format('Y-m-d H:i:s'), Carbon::parse($meeting->end_time)->format('Y-m-d H:i:s'))){
                   $status= 'started';
                }

                if(!$now->gt(Carbon::parse($meeting->end_time)->addMinute(-10))){
                   $status= 'waiting';
                }
               $status= 'closed';
            }

                if (!$status == 'started') {
                    return ApiBaseMethod::sendError('Meeting not yet start, try later.');
                }
                if (!$status == 'closed') {
                    return ApiBaseMethod::sendError('Meeting is closed.');
                }
                if($user_info->id == $meeting->created_by || $user_info->role_id == 1){
                    $url= 'https://zoom.us/wc/'.$meeting->meeting_id.'/start';
                }else{
                    $url= 'https://zoom.us/wc/'.$meeting->meeting_id.'/join';
                }
                $data['url'] = $url;
                $data['topic'] = $meeting->topic;
                $data['password'] = $meeting->password;
                 return ApiBaseMethod::sendResponse($data, null);
            } catch (\Exception $e) {
               
                return ApiBaseMethod::sendError('Something went wrong, please try again.');
            }
    }



//Virtual Class Room
        public function makeVirtualClass($user_id){

        $module = 'Zoom';
        if (User::checkPermission($module) != 100) {
            return ApiBaseMethod::sendError('Zoom Module not verified.');
        }
        try {
            $user_info=User::find($user_id);
            $data['classes'] = SmClass::where('active_status', 1)
            ->where('academic_id', YearCheck::getAcademicId())
            ->where('school_id', $user_info->school_id)
            ->select('id','class_name')
            ->get();
            $data['teachers'] = SmStaff::where('active_status', 1)->where('role_id', 4)
            ->where('school_id', $user_info->school_id)
            ->select('id','staff_no','full_name','email','user_id')
            ->get();
            $data['default_settings'] =  ZoomSetting::first()->makeHidden('api_key', 'secret_key', 'created_at', 'updated_at');

            if ($user_info->role_id == 4) {
                $data['default_settings'] = ZoomSetting::first();
                $data['meetings'] = VirtualClass::orderBy('id', 'DESC')->whereHas('teachers', function ($query) use($user_info) {
                    return $query->where('user_id', $user_info->id);
                })
                    ->where('status', 1)
                    ->get();
            } elseif ($user_info->role_id == 1) {
                $data['meetings'] = VirtualClass::orderBy('id', 'DESC')->get();
            } else {
                $data['meetings'] = VirtualClass::orderBy('id', 'DESC')->with('section', 'section.students')->whereHas('section', function ($query) use($user_info) {
                    return  $query->whereHas('students', function ($query) use($user_info) {
                        return $query->where('user_id', $user_info->id);
                    });
                })
                    ->where('status', 1)
                    ->get();
            }
             return ApiBaseMethod::sendResponse($data, null);
        } catch (\Exception $e) {
           
              return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
        }
//  public function VirtualClassStart($id)
//     {

//         try {
//             $meeting = VirtualClass::where('meeting_id', $id)->first();
//             if (!$meeting->currentStatus == 'started') {
//                 return ApiBaseMethod::sendError('Class not yet start, try later.');
//             }
//             if (!$meeting->currentStatus == 'closed') {
//                 Toastr::error('Class are closed', 'Failed');
//                 return redirect()->back();
//             }
//             $data['url'] = $meeting->url;
//             $data['topic'] = $meeting->topic;
//             $data['password'] = $meeting->password;

//              return ApiBaseMethod::sendResponse($data, null);
//         } catch (\Exception $e) {
//              return ApiBaseMethod::sendError('Something went wrong, please try again.');
//         }
//     }

    public function storeVirtualClass(Request $request)
    {
        $creator_info=User::find($request->created_by);
        $input = $request->all();
        if ($creator_info->role_id == 1) {
          

        $validator = Validator::make($input, [
                'class' => 'required',
                'section' => 'required',
                'teacher_ids' => 'required|array',
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
            ]);
        } else {
           $validator = Validator::make($input, [
                'class' => 'required',
                'section' => 'required',
                'topic' => 'required',
                'description' => 'nullable',
                'password' => 'required',
                'attached_file' => 'nullable|mimes:jpeg,png,jpg,doc,docx,pdf,xls,xlsx',
                'date' => 'required',
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
            ]);
        }
          if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($this->isTimeAvailableForClass($request, $id = 0)) {
            return ApiBaseMethod::sendError('Virtual class time is not available for teacher and student!');
        }

        if (VirtualClass::whereDate('created_at', Carbon::now())->count('id') >= 100) {
            return ApiBaseMethod::sendError('You can not create more than 100 meeting within 24 hour!');
        }

        try {
        $users = Zoom::user()->where('status', 'active')->setPaginate(false)->setPerPage(300)->get()->toArray();
        $profile = $users['data'][0];
        $start_date = Carbon::parse($request['date'])->format('Y-m-d') . ' ' . date("H:i:s", strtotime($request['time']));
        $GSetting = SmGeneralSettings::where('school_id',$creator_info->school_id)->first();
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
            $meeting->recurrence()->make([
                'type' =>  $request['recurring_type'],
                'repeat_interval' => $request['recurring_repect_day'],
                'end_date_time' => $end_date
            ]);
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
        $system_meeting =  VirtualClass::create([
            'class_id' =>  $request['class'],
            'section_id' =>  $request['section'],
            'topic' =>  $request['topic'],
            'description' =>  $request['description'],
            'date_of_meeting' =>  $request['date'],
            'time_of_meeting' =>  $request['time'],
            'meeting_duration' =>  $request['durration'],

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
            'meeting_id' =>  $meeting_details->id,
            'password' =>  $meeting_details->password,
            'start_time' =>  Carbon::parse($start_date)->toDateTimeString(),
            'end_time' =>  Carbon::parse($start_date)->addMinute($request['durration'])->toDateTimeString(),
            'attached_file' =>  $fileName,
            'created_by' =>  $creator_info->id,
            'school_id' =>  $creator_info->school_id,
        ]);
        if ($creator_info->role_id == 1) {
            $system_meeting->teachers()->attach($request['teacher_ids']);
        } else {
            $system_meeting->teachers()->attach($creator_info);
        }
        $UserList = SmStudent::where('class_id', $request['class'])
            ->where('section_id', $request['section'])
            ->where('school_id',$creator_info->school_id)
            ->select('user_id', 'role_id', 'parent_id')->get();
        $this->setNotificaitonForClass($UserList, $updateStatus = 0,$creator_info);
        DB::commit();

       return ApiBaseMethod::sendResponse(null, 'Virtual class created');
        } catch (\Exception $e) {
            return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
    }
       private function isTimeAvailableForClass($request, $id)
    {
        $creator_info=User::find($request->created_by);
        if (isset($request['teacher_ids'])) {
            $teacherList = $request['teacher_ids'];
        } else {
            $teacherList = [$creator_info->id];
        }

        if ($id != 0) {
            $meetings = VirtualClass::where('date_of_meeting', Carbon::parse($request['date'])->format("m/d/Y"))
                ->where('class_id', $request['class'])
                ->where('id', '!=', $id)
                ->where('section_id', $request['section'])
                ->where('school_id', $creator_info->school_id)
                ->whereHas('teachers', function ($q) use ($teacherList) {
                    $q->whereIn('user_id', $teacherList);
                })
                ->get();
        } else {
            $meetings = VirtualClass::where('date_of_meeting', Carbon::parse($request['date'])->format("m/d/Y"))
                ->where('class_id', $request['class'])
                ->where('section_id', $request['section'])
                ->where('school_id', $creator_info->school_id)
                ->whereHas('teachers', function ($q) use ($teacherList) {
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
            $strat_time = Carbon::parse($meeting->date_of_meeting . ' ' . $meeting->time_of_meeting);
            $end_time   = Carbon::parse($meeting->date_of_meeting . ' ' . $meeting->time_of_meeting)->addMinute($meeting->meeting_duration);

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
       private function setNotificaitonForClass($users, $updateStatus,$creator_info)
    {
        $now = Carbon::now('utc')->toDateTimeString();
        $school_id = $creator_info->school_id;
        $notification_datas = [];

        if ($updateStatus == 1) {
            foreach ($users as $key => $user) {
                array_push(
                    $notification_datas,
                    [
                        'user_id'       => $user->user_id,
                        'role_id'       => 2,
                        'school_id'     => $school_id,
                        'date'          => date('Y-m-d'),
                        'message'       => 'Zoom virtual class room details udpated',
                        'url'           => route('zoom.virtual-class.index'),
                        'created_at'    => $now,
                        'updated_at'    => $now
                    ]
                );
                array_push(
                    $notification_datas,
                    [
                        'user_id'       => $user->parent_id,
                        'role_id'       => 3,
                        'school_id'     => $school_id,
                        'date'          => date('Y-m-d'),
                        'message'       => 'Zoom virtual class room details udpated of your child',
                        'url'           => route('zoom.virtual-class.index'),
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
                        'user_id'       => $user->user_id,
                        'role_id'       => 2,
                        'school_id'     => $school_id,
                        'date'          => date('Y-m-d'),
                        'message'       => 'Zoom virtual class room created for you',
                        'url'           => route('zoom.virtual-class.index'),
                        'created_at'    => $now,
                        'updated_at'    => $now
                    ]
                );
                array_push(
                    $notification_datas,
                    [
                        'user_id'       => $user->parent_id,
                        'role_id'       => 3,
                        'school_id'     => $school_id,
                        'date'          => date('Y-m-d'),
                        'message'       => 'Zoom virtual class room created for your child',
                        'url'           => route('zoom.virtual-class.index'),
                        'created_at'    => $now,
                        'updated_at'    => $now
                    ]
                );
            };
        }
        SmNotification::insert($notification_datas);
    }

        public function showClassInfo($id)
    {
        try {
            $data['localMeetingData'] = VirtualClass::where('meeting_id', $id)->first();
            $data['results'] = Zoom::meeting()->find($id)->toArray();
            return ApiBaseMethod::sendResponse($data, null);
        } catch (\Exception $e) {
             return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
    }

        public function ClassEdit($id,$uid){
        try{

            
        $user_info=User::find($uid);
        $data['classes'] = SmClass::where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', $user_info->school_id)
        ->select('id','class_name')->get();
        $data['teachers'] = SmStaff::where('active_status', 1)->where('role_id', 4)->where('school_id', $user_info->school_id)->get();
        $data['meetings'] = VirtualClass::all();
        $data['editdata'] = VirtualClass::where('meeting_id',$id)->first();
        return $data;
        if ($user_info->role_id != 1) {
            if ($user_info->id != $data['editdata']->created_by) {
                return ApiBaseMethod::sendError('Meeting is created by other, you could not modify !.');
            }
            $data['default_settings'] =  ZoomSetting::first()->makeHidden('api_key', 'secret_key', 'created_at', 'updated_at');
            $data['class_sections'] = SmSection::whereIn('id', $data['editdata']->class->classSections->pluck('section_id'))->get();
             
        
            }
            return ApiBaseMethod::sendResponse($data, null);
        } catch (\Exception $e) {
            // return $e->getMessage();
             return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
    }











        public function ClassUpdate(Request $request){
        $creator_info=User::find($request->created_by);
        if ($creator_info->role_id == 1) {
            $request->validate([
                'class' => 'required',
                'section' => 'required',
                'teacher_ids' => 'required|array',
                'topic' => 'required',
                'password' => 'required',
                'description' => 'required',
                'date' => 'required',
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
            ]);
        } else {
            $request->validate([
                'class' => 'required',
                'section' => 'required',
                'topic' => 'required',
                'description' => 'required',
                'password' => 'required',
                'date' => 'required',
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
            ]);
        }

        try {
            $system_meeting = VirtualClass::findOrFail($request->id);

          
            if ($this->isTimeAvailableForClass($request, $id =1)) {
                return ApiBaseMethod::sendError('Virtual class time is not available for teacher and student!');
            }

            $users = Zoom::user()->where('status', 'active')->setPaginate(false)->setPerPage(300)->get()->toArray();
            $profile = $users['data'][0];
            $start_date = Carbon::parse($request['date'])->format('Y-m-d') . ' ' . date("H:i:s", strtotime($request['time']));
            $GSetting = SmGeneralSettings::where('school_id', $creator_info->school_id)->first();
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
                $meeting->recurrence()->make([
                    'type' =>  $request['recurring_type'],
                    'repeat_interval' => $request['recurring_repect_day'],
                    'end_date_time' => $end_date
                ]);
            }

            $meeting_details  = Zoom::user()->find($profile['id'])->meetings()->save($meeting);

            DB::beginTransaction();

            $system_meeting->update([
                'class_id' =>  $request['class'],
                'section_id' =>  $request['section'],
                'topic' =>  $request['topic'],
                'description' =>  $request['description'],
                'date_of_meeting' =>  $request['date'],
                'time_of_meeting' =>  $request['time'],
                'meeting_duration' =>  $request['durration'],
                'password' =>  $request['password'],

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

                'password' =>  $meeting_details->password,
                'start_time' =>  Carbon::parse($start_date)->toDateTimeString(),
                'end_time' =>  Carbon::parse($start_date)->addMinute($request['durration'])->toDateTimeString(),
                'updated_by' => $creator_info->id,
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

            if ($creator_info->role_id == 1) {
                $system_meeting->teachers()->detach();
                $system_meeting->teachers()->attach($request['teacher_ids']);
            }

            $UserList = SmStudent::where('class_id', $request['class'])
                ->where('section_id', $request['section'])
                ->where('school_id', $creator_info->school_id)
                ->select('user_id', 'role_id', 'parent_id')->get();
            $this->setNotificaitonForClass($UserList, $updateStatus = 1,$creator_info);

            DB::commit();
            return ApiBaseMethod::sendResponse(null, 'Virtual Class updated successful');
        } catch (\Exception $e) {
             return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
    }


     public function classStart($id,$user_id)
    {
            try {

                $user_info=User::find($user_id);
                $meeting = VirtualClass::where('meeting_id', $id)->first();

                

                $GSetting = SmGeneralSettings::where('school_id', $user_info->school_id)->first();
                $now = Carbon::now()->setTimezone($GSetting->timeZone->time_zone);

            if($meeting->is_recurring == 1){
                if($now->between(Carbon::parse($meeting->start_time)->addMinute(-10)->format('Y-m-d H:i:s'), Carbon::parse($meeting->recurring_end_date)->endOfDay()->format('Y-m-d H:i:s'))){
                   $status= 'started';
                }
                if(!$now->gt(Carbon::parse($meeting->recurring_end_date)->addMinute(-10))){
                   $status= 'waiting';
                }
               $status= 'closed';
            }else{
                if($now->between(Carbon::parse($meeting->start_time)->addMinute(-10)->format('Y-m-d H:i:s'), Carbon::parse($meeting->end_time)->format('Y-m-d H:i:s'))){
                   $status= 'started';
                }

                if(!$now->gt(Carbon::parse($meeting->end_time)->addMinute(-10))){
                   $status= 'waiting';
                }
               $status= 'closed';
            }

                if (!$status == 'started') {
                    return ApiBaseMethod::sendError('Meeting not yet start, try later.');
                }
                if (!$status == 'closed') {
                    return ApiBaseMethod::sendError('Meeting is closed.');
                }
                if($user_info->id == $meeting->created_by || $user_info->role_id == 1){
                    $url= 'https://zoom.us/wc/'.$meeting->meeting_id.'/start';
                }else{
                    $url= 'https://zoom.us/wc/'.$meeting->meeting_id.'/join';
                }
                $data['url'] = $url;
                $data['topic'] = $meeting->topic;
                $data['password'] = $meeting->password;
                 return ApiBaseMethod::sendResponse($data, null);
            } catch (\Exception $e) {
                return ApiBaseMethod::sendError('Something went wrong, please try again.');
            }
    }
}
