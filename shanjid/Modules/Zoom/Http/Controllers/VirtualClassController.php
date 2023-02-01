<?php

namespace Modules\Zoom\Http\Controllers;

use App\User;
use App\SmClass;
use App\SmStaff;
use App\SmParent;
use App\SmSection;
use App\SmStudent;
use App\SmWeekend;
use App\YearCheck;
use App\SmNotification;
use App\SmAssignSubject;
use App\SmGeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use MacsiDigital\Zoom\Facades\Zoom;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Zoom\Entities\ZoomMeeting;
use Modules\Zoom\Entities\ZoomSetting;
use Modules\Zoom\Entities\VirtualClass;

class VirtualClassController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

      

        $data['default_settings'] = ZoomSetting::first();
        $user=User::find(Auth::user()->id);
     
        if(Auth::user()->role_id==4){
            if($data['default_settings']->api_use_for==1 && $user->zoom_api_key_of_user ==NULL &&  $user->zoom_api_serect_of_user ==NULL){
            
                return redirect()->route('zoom.settings');
            }
       }
        $time_zone_setup=SmGeneralSettings::join('sm_time_zones','sm_time_zones.id','=','sm_general_settings.time_zone_id')
        ->where('school_id',Auth::user()->school_id)->first();
        date_default_timezone_set($time_zone_setup->time_zone);
   
        $module = 'Zoom';
        if (User::checkPermission($module) != 100) {
            Toastr::error('Please verify your ' . $module . ' Module', 'Failed');
            return redirect()->route('Moduleverify', $module);
        }

        try {

            if (teacherAccess()) {
                $teacher_info=SmStaff::where('user_id',Auth::user()->id)->first();
                $data['classes']= SmAssignSubject::where('teacher_id',$teacher_info->id)
                   ->join('sm_classes','sm_classes.id','sm_assign_subjects.class_id')
                   ->where('sm_assign_subjects.academic_id', getAcademicId())
                   ->where('sm_assign_subjects.active_status', 1)
                   ->where('sm_assign_subjects.school_id',Auth::user()->school_id)
                   ->distinct ()
                   ->select('sm_classes.id','class_name')
                    ->groupBy('sm_classes.id')
                   ->get();
            } else {
                $data['classes']= SmClass::where('active_status', 1)
                            ->where('academic_id', getAcademicId())
                            ->where('school_id',Auth::user()->school_id)
                            ->get();
            }
            $data['teachers'] = SmStaff::where('active_status', 1)->where('role_id', 4)->where('school_id', Auth::user()->school_id)->get();
            $data['default_settings'] =  ZoomSetting::first()->makeHidden('api_key', 'secret_key', 'created_at', 'updated_at');

            if (Auth::user()->role_id == 4) {
             
                $data['meetings'] = VirtualClass::orderBy('id', 'DESC')->whereHas('teachers', function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
                    ->where('status', 1)
                    ->get();
            } elseif (Auth::user()->role_id == 1 || Auth::user()->role_id==5) {
                $data['meetings'] = VirtualClass::orderBy('id', 'DESC')->get();
            } elseif (Auth::user()->role_id == 3) {
                
                $parent=SmParent::where('user_id',Auth::user()->id)->first();
                $student_detail = SmStudent::where('parent_id', $parent->id)->get();
                $data=['meetings'];
                foreach( $student_detail as $student){
                    $class_id=$student->class_id;
                    $section_id=$student->section_id;

                    $data['meetings']= VirtualClass::orderBy('id', 'DESC')->where('class_id',$class_id)->where('section_id',$section_id)->orwhere('section_id',null)->get();

                }
       
            
                  
        } elseif(Auth::user()->role_id == 2) {
               
            $student=SmStudent::where('user_id',Auth::user()->id)->first();
            $class_id=$student->class_id;
            $section_id=$student->section_id;
            $data['meetings']= VirtualClass::orderBy('id', 'DESC')->where('class_id',$class_id)->where('section_id',$section_id)->orwhere('section_id',null)->get();

          
        
       }else{

       }

            $data['days'] =SmWeekend::orderby('order')->get(['id','name','order','zoom_order']);

            
            return view('zoom::virtualClass.meeting', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }

    public function mychild($id){
        try {
         
            $student = SmStudent::where('id', $id)->first();       
            $class_id=$student->class_id;
            $section_id=$student->section_id;
            $data['meetings']= VirtualClass::orderBy('id', 'DESC')
                                            ->where('class_id',$class_id)
                                            ->where('section_id',$section_id)
                                            ->orwhere('section_id',null)
                                            ->get();
          return view('zoom::virtualClass.meeting', $data);
        } catch (\Throwable $th) {
          
        }
    }
    public function meetingStart($id)
    {
          $time_zone_setup=SmGeneralSettings::join('sm_time_zones','sm_time_zones.id','=','sm_general_settings.time_zone_id')
        ->where('school_id',Auth::user()->school_id)->first();
        date_default_timezone_set($time_zone_setup->time_zone);

        try {
            $meeting = VirtualClass::where('meeting_id', $id)->first();
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

           // return view('zoom::virtualClass.meetingStart', $data);
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
        
       try{
        if (auth()->user()->role_id == 1) {
            $request->validate([
                'class' => 'required',               
                'teacher_ids' => 'required',
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
                  
        //   return  $request->all();
             $schoolUser=SmStaff::where('user_id',$request->teacher_ids)->first();
          
             $userMail= $schoolUser->email;
             
        } else {
            $request->validate([
                'class' => 'required',              
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
                'days' => 'required_if:recurring_type,2',

            ]);
        }
        $days= $request->days;
        if(!empty($days)){
          $str_days_id=implode(',',$days);
        }
        if ($this->isTimeAvailableForMeeting($request, $id = 0)) {
            Toastr::error('Virtual class time is not available for teacher and student!', 'Failed');
            return redirect()->back();
        }

        if (VirtualClass::whereDate('created_at', Carbon::now())->count('id') >= 100) {
            Toastr::error('You can not create more than 100 meeting within 24 hour!', 'Failed');
            return redirect()->back();
        }

        // try {
        $data['default_settings'] = ZoomSetting::first();
         $user=User::find(Auth::user()->id);         

      $users = Zoom::user()->where('status', 'active')->setPaginate(false)->setPerPage(300)->get()->toArray();
     
     
      
        $profile = $users['data'][0];
        $start_date = Carbon::parse($request['date'])->format('Y-m-d') . ' ' . date("H:i:s", strtotime($request['time']));
        $GSetting = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
        
      
        $meeting = Zoom::meeting()->make([
            "topic" => $request['topic'],
            "type" => $request['is_recurring'] == 1 ? 8 : 2,
            "duration" => $request['durration'],
            "timezone" => $GSetting->timeZone->time_zone,
            "password" => $request['password'],
            "start_time" => new Carbon($start_date),
        ]);
        
         if($profile['type']==1){
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
        
        }else{
            if(auth::user()->role_id==1){
                $meeting->settings()->make([
                'join_before_host'  => $this->setTrueFalseStatus($request['join_before_host']),
                'host_video'        => $this->setTrueFalseStatus($request['host_video']),
                'participant_video' => $this->setTrueFalseStatus($request['participant_video']),
                'mute_upon_entry'   => $this->setTrueFalseStatus($request['mute_upon_entry']),
                'waiting_room'      => $this->setTrueFalseStatus($request['waiting_room']),
                'audio'             => $request['audio'],
                'auto_recording'    => $request->has('auto_recording') ? $request['auto_recording'] : 'none',
                'approval_type'     => $request['approval_type'],
                'alternative_hosts' => $userMail,
              ]);
            }
        }

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
        $system_meeting =  VirtualClass::create([
            'class_id' =>  $request['class'],
            'section_id' =>  $request['section'],
            'topic' =>  $request['topic'],
            'description' =>  $request['description'],
            'date_of_meeting' =>  $request['date'],
            'time_of_meeting' =>  $request['time'],
            'meeting_duration' =>  $request['durration'],
            'time_before_start' =>$request['time_before_start'],
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
            'meeting_id' => (string)$meeting_details->id,
            'password' =>  $meeting_details->password,
            'start_time' =>  Carbon::parse($start_date)->toDateTimeString(),
            'end_time' =>  Carbon::parse($start_date)->addMinute($request['durration'])->toDateTimeString(),
            'attached_file' =>  $fileName,
            'created_by' => Auth::user()->id,
            'school_id' => Auth::user()->school_id,
        ]);
        if (auth()->user()->role_id == 1) {
            $system_meeting->teachers()->attach($request['teacher_ids']);
        } else {
            $system_meeting->teachers()->attach(Auth::user());
        }
        $UserList = SmStudent::where('class_id', $request['class'])
            ->where('section_id', $request['section'])
            ->where('school_id', Auth::user()->school_id)
            ->select('user_id', 'role_id', 'parent_id')->get();
        $this->setNotificaiton($UserList, $updateStatus = 0);
        DB::commit();

        if ($system_meeting) {
            Toastr::success('Virtual class created successful', 'Success');
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
              $time_zone_setup=SmGeneralSettings::join('sm_time_zones','sm_time_zones.id','=','sm_general_settings.time_zone_id')
        ->where('school_id',Auth::user()->school_id)->first();
        date_default_timezone_set($time_zone_setup->time_zone);

                  $data['localMeetingData'] = VirtualClass::where('meeting_id', $id)->first();
                  $day_ids= $data['localMeetingData']->weekly_days;

                  if($day_ids !=null){
                      $days=explode(',',$day_ids);
                      $assign_day=[];    
                      foreach($days as $dayId){
                          $assign_day[]=SmWeekend::where('zoom_order',$dayId)->first();
                      }
                      $data['assign_day']=$assign_day;
                  }
                    if($data['localMeetingData']->created_by==auth()->user()->id){
                          $data['results'] = Zoom::meeting()->find($id)->toArray();
                    }else{
                        $data['results'] =null;
                    }
           
                if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4) {
                    return view('zoom::virtualClass.meetingDetails', $data);
                } else {
                    return view('zoom::virtualClass.meetingDetailsStudentParent', $data);
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
        
        $data['classes'] = SmClass::where('active_status', 1)->where('academic_id', YearCheck::getAcademicId())->where('school_id', Auth::user()->school_id)->get();
        $data['teachers'] = SmStaff::where('active_status', 1)->where('role_id', 4)->where('school_id', Auth::user()->school_id)->get();
        $data['meetings'] = VirtualClass::orderby('id','DESC')->get();
        $data['editdata'] = VirtualClass::findOrFail($id);
        if (Auth::user()->role_id != 1) {
            if (Auth::user()->id != $data['editdata']->created_by) {
                Toastr::error('Meeting is created by other, you could not modify !', 'Failed');
                return redirect()->back();
            }
        }

        $day_ids=VirtualClass::findOrFail($id)->weekly_days;
        $days=explode(',',$day_ids);

        $assign_day=[];

        foreach($days as $dayId){
            $assign_day[]=$dayId;
        }
        $data['assign_day']=$assign_day;
    
        if (Auth::user()->role_id != 1) {
            if (Auth::user()->id != $data['editdata']->created_by) {
                Toastr::error('Meeting is created by other, you could not modify !', 'Failed');
                return redirect()->back();
            }
        }
        $data['days'] =SmWeekend::orderby('order')->get(['id','name','order','zoom_order']);

        $data['default_settings'] =  ZoomSetting::first()->makeHidden('api_key', 'secret_key', 'created_at', 'updated_at');
        $data['class_sections'] = SmSection::whereIn('id', $data['editdata']->class->classSections->pluck('section_id'))->get();
        return view('zoom::virtualClass.meeting', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //  return $request->all();
        if (auth()->user()->role_id == 1) {
            $request->validate([
                'class' => 'required',
                // 'section' => 'required',
                'teacher_ids' => 'required|array',
                'topic' => 'required',
                'password' => 'required',
                // 'description' => 'required',
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
                 'days' => 'required_if:recurring_type,2',

            ]);
        } else {
            $request->validate([
                'class' => 'required',
                // 'section' => 'required',
                'topic' => 'required',
                // 'description' => 'required',
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
                'days' => 'required_if:recurring_type,2',

            ]);
        }
        $days= $request->days;
        if(!empty($days)){
          $str_days_id=implode(',',$days);
        }
        try {
            $system_meeting = VirtualClass::findOrFail($id);

            if ($this->isTimeAvailableForMeeting($request, $id = $id)) {
                Toastr::error('Virtual class time is not available for teacher and student!', 'Failed');
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
                'class_id' =>  $request['class'],
                'section_id' =>  $request['section'],
                'topic' =>  $request['topic'],
                'description' =>  $request['description'],
                'date_of_meeting' =>  $request['date'],
                'time_of_meeting' =>  $request['time'],
                'meeting_duration' =>  $request['durration'],
                'password' =>  $request['password'],
                'time_before_start' =>$request['time_before_start'],
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
                $system_meeting->teachers()->detach();
                $system_meeting->teachers()->attach($request['teacher_ids']);
            }

            $UserList = SmStudent::where('class_id', $request['class'])
                ->where('section_id', $request['section'])
                ->where('school_id', Auth::user()->school_id)
                ->select('user_id', 'role_id', 'parent_id')->get();
            $this->setNotificaiton($UserList, $updateStatus = 1);

            DB::commit();
            Toastr::success('Virtual Class updated successful', 'Success');
            return redirect()->route('zoom.virtual-class');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


   public function fileUpload($id){
        try {
            //code...
            $meeting = VirtualClass::findOrFail($id);
            $uploadtype='classUpload';
            return view('zoom::recorder_file_upload',compact('meeting','uploadtype'));
        } catch (\Throwable $th) {
           
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function updateVedio(Request $request){
       
      
        try {
            //   return $request->all();
            if($request->vedio==null && $request->link==null){
                Toastr::warning('Fill up at Least one Field', 'Failed');
                return redirect()->back();
            }
            if($request->meetingupload=='meetingUpload'){
                $system_meeting = ZoomMeeting::findOrFail($request->meeting_id);
            }elseif($request->meetingupload=='classUpload'){
                 $system_meeting = VirtualClass::findOrFail($request->meeting_id);
            }
          
            if ($request->file('vedio') != "") {
                if (file_exists($system_meeting->local_video)) {
                    unlink($system_meeting->local_video);
                }
                $file = $request->file('vedio');
                $fileName = $request['topic'] . time() . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/zoom-meeting/', $fileName);
                $fileName = 'public/uploads/zoom-meeting/' . $fileName;
                $system_meeting->local_video= $fileName;
            }
            $system_meeting->vedio_link=$request->link;
            $system_meeting->save();
            
           
            
            

            Toastr::success('File Upload successful', 'Success');
            return redirect()->route('zoom.virtual-class');


        } catch (\Throwable $th) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $localMeeting = VirtualClass::findOrFail($id);
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
        Toastr::success('Virtual Class deleted successful', 'Success');
        return redirect()->route('zoom.virtual-class');
    }

    private function setTrueFalseStatus($value)
    {
        if ($value == 1) {
            return true;
        }
        return false;
    }

    private function setNotificaiton($users, $updateStatus)
    {
        $now = Carbon::now('utc')->toDateTimeString();
        $school_id = Auth::user()->school_id;
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
                        'url'           => route('zoom.virtual-class'),
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
                        'url'           => route('zoom.virtual-class'),
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
                        'url'           => route('zoom.virtual-class'),
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
                        'url'           => route('zoom.virtual-class'),
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
        if (isset($request['teacher_ids'])) {
            $teacherList = [$request['teacher_ids']];
        } else {
            $teacherList = [Auth::user()->id];
        }

        if ($id != 0) {
            $meetings = VirtualClass::where('date_of_meeting', Carbon::parse($request['date'])->format("m/d/Y"))
                ->where('class_id', $request['class'])
                ->where('id', '!=', $id)
                ->where('section_id', $request['section'])
                ->where('school_id', Auth::user()->school_id)
                ->whereHas('teachers', function ($q) use ($teacherList) {
                    $q->whereIn('user_id', $teacherList);
                })
                ->get();
        } else {
            $meetings = VirtualClass::where('date_of_meeting', Carbon::parse($request['date'])->format("m/d/Y"))
                ->where('class_id', $request['class'])
                ->where('section_id', $request['section'])
                ->where('school_id', Auth::user()->school_id)
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
}