<?php

namespace Modules\ParentRegistration\Http\Controllers;

use App\User;
use App\SmClass;
use App\SmParent;
use App\SmSchool;
use App\SmSection;
use App\SmStudent;
use App\SmUserLog;
use App\SmBaseSetup;
use App\SmAcademicYear;
use App\SmClassSection;
use App\SmEmailSetting;
use App\SmGeneralSettings;
use App\InfixModuleManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Modules\ParentRegistration\Entities\SmRegistrationSetting;
use Modules\ParentRegistration\Entities\SmStudentRegistration;



class ParentRegistrationController extends Controller
{
    private $User;
    private $SmGeneralSettings;
    private $SmUserLog;
    private $InfixModuleManager;
    private $URL;
    private $TYPE;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('PM');

        $this->User                 = json_encode(User::find(1));
        $this->SmGeneralSettings    = json_encode(SmGeneralSettings::find(1));
        $this->SmUserLog            = json_encode(SmUserLog::find(1));
        // $this->InfixModuleManager   = json_encode(InfixModuleManager::find(1));
        $this->URL                  = url('/');
        $this->TYPE                 = 1;
    }


    public function index()
    {
        // $module = 'ParentRegistration';
        // if (User::checkPermission($module) != 100) {
        //     Toastr::error('Please verify your ' . $module . ' Module', 'Failed');
        //     return redirect()->route('Moduleverify', $module);
        // }

        try {
            // if (date('d') <= 15) {
            //     $client = new \GuzzleHttp\Client();
            //     $s = $client->post(User::$api, array('form_params' => array('TYPE' => $this->TYPE, 'User' => $this->User, 'SmGeneralSettings' => $this->SmGeneralSettings, 'SmUserLog' => $this->SmUserLog, 'InfixModuleManager' => $this->InfixModuleManager, 'URL' => $this->URL)));
            // }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
        try {
            return view('parentregistration::index');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function about()
    {

        try {
            $data = \App\InfixModuleManager::where('name', 'ParentRegistration')->first();
            return view('parentregistration::index', compact('data'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function settings()
    {
        $setting = SmRegistrationSetting::find(1);
        return view('parentregistration::settings', compact('setting'));
    }

    public function create()
    {
        try {
            return view('parentregistration::create');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function show($id)
    {
        try {
            return view('parentregistration::show');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function edit($id)
    {
        try {
            return view('parentregistration::edit');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    // new student registration form view method
    public function registration()
    {
        try {
            $schools = SmSchool::all();
            $classes = SmClass::all();
            $academic_years = SmAcademicYear::where('active_status', 1)->where('school_id', 1)->get();
            $genders = SmBaseSetup::where('active_status', '=', '1')->where('base_group_id', '=', '1')->get();
            $reg_setting = SmRegistrationSetting::find(1);
            return view('parentregistration::registration', compact('schools', 'classes', 'academic_years', 'genders', 'reg_setting'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    // get academic year for parent registration for saas using ajax
    public function getClasAcademicyear(Request $request)
    {
        $classes = [];
        $academic_years = SmAcademicYear::where('school_id', $request->id)->get();
        return response()->json([$classes, $academic_years]);
    }

    // Get section for new registration by ajax
    public function getSection(Request $request)
    {
        try {
            $sectionIds = SmClassSection::where('class_id', '=', $request->id)->get();
            $sections = [];
            foreach ($sectionIds as $sectionId) {
                $sections[] = SmSection::find($sectionId->section_id);
            }
            return response()->json($sections);
        } catch (\Exception $e) {
            return response()->json("", 404);
        }
    }


    // Get class for regular school and saas for new student registration
    public function getClasses(Request $request)
    {
        $academic_year = SmAcademicYear::where('id', $request->id)->first();
        if (isset($request->school_id)) {
            $classes = SmClass::where('active_status', '=', '1')->where('created_at', 'LIKE', '%' . $academic_year->year . '%')->where('school_id', $request->school_id)->get();
        } else {
            $classes = SmClass::where('active_status', '=', '1')->where('created_at', 'LIKE', '%' . $academic_year->year . '%')->where('school_id', Auth::user()->school_id)->get();
        }
        return response()->json([$classes, $academic_year]);
    }

    // new stduent registration store in temporary table for review
    public function studentStore(request $request)
    {

        $reg_setting = SmRegistrationSetting::find(1);
        $input = $request->all();


        if ($reg_setting->recaptcha == 1) {

            $validator = Validator::make($input, [
                'class' => "required",
                'section' => "required",
                'academic_year' => "required",
                'first_name' => "required",
                'gender' => "required",
                'date_of_birth' => "required",
                'guardian_name' => "required",
                'relationButton' => "required",
                'guardian_email' => 'required|different:student_email',
                'guardian_mobile' => "required",
                'g-recaptcha-response' => 'required|captcha',
            ]);
        } else {

            $validator = Validator::make($input, [
                'class' => "required",
                'section' => "required",
                'academic_year' => "required",
                'first_name' => "required",
                'gender' => "required",
                'date_of_birth' => "required",
                'guardian_name' => "required",
                'relationButton' => "required",
                'guardian_email' => 'required|different:student_email',
                'guardian_mobile' => "required"
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        try {

            $student = new SmStudentRegistration();

            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->class_id = $request->class;
            $student->section_id = $request->section;
            $student->gender_id = $request->gender;
            $student->academic_year = $request->academic_year;
            $student->student_email = $request->student_email;
            $student->student_mobile = $request->student_mobile;
            $student->guardian_name = $request->guardian_name;
            $student->guardian_relation = $request->relationButton;
            $student->guardian_email = $request->guardian_email;
            $student->guardian_mobile = $request->guardian_mobile;
            $student->how_do_know_us = $request->how_do_know_us;
            $student->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
            $student->age = $request->age;

            if (SmGeneralSettings::isModule('Saas') == TRUE) {
                $student->school_id = $request->school;
            }

            $student->save();


            $setting = SmRegistrationSetting::find(1);


            if ($setting->registration_after_mail == 1) {

                $user_info = [];

                if ($request->student_email != "") {
                    $user_info[] =  array('email' => $request->student_email, 'id' => $student->id, 'slug' => 'student');
                }


                if ($request->guardian_email != "") {
                    $user_info[] =  array('email' =>  $request->guardian_email, 'id' => $student->id, 'slug' => 'parent');
                }


                try {

                    foreach ($user_info as $data) {

                        Mail::send('parentregistration::new_reg_email', compact('data'), function ($message) use ($data) {

                            $settings = SmEmailSetting::find(1);
                            $email = $settings->from_email;
                            $Schoolname = $settings->from_name;

                            $message->to($data['email'], $Schoolname)->subject('New Student Registration');
                            $message->from($email, $Schoolname);
                        });
                    }
                } catch (\Exception $e) {
                    // dd($e);
                    return redirect()->back()->with('success', 'You have successfully complete the registration.');
                }
            }


            //Toastr::success('Operation successful, Please contact with administrator for confirmation', 'Success');


            return redirect()->back()->with('success', 'You have successfully complete the registration.');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    // Show student list for new registration
    public function studentList()
    {
        $academic_years = SmAcademicYear::where('school_id', Auth::user()->school_id)->get();
        return view('parentregistration::student_list', compact('academic_years'));
    }

    // Show student list for new registration
    public function studentListSearch(Request $request)
    {


        $students = SmStudentRegistration::query();

        $students->where('school_id', Auth::user()->school_id);

        if ($request->academic_year != "") {
            $students->where('academic_year', $request->academic_year);
        }

        if ($request->class != "") {
            $students->where('class_id', $request->class);
        }
        if ($request->section != "") {
            $students->where('section_id', $request->section);
        }
        $students = $students->orderBy('id', 'desc');
        $students = $students->get();


        $academic_years = SmAcademicYear::where('school_id', Auth::user()->school_id)->get();



        return view('parentregistration::student_list', compact('students', 'academic_years'));
    }




    // Show student list for new registration
    public function saasStudentList()
    {

        $institutions  = SmSchool::all();


        return view('parentregistration::saas_student_list', compact('institutions'));
    }


    // Show student list for new registration
    public function saasStudentListsearch(Request $request)
    {


        $students = SmStudentRegistration::query();

        if ($request->institution != "") {
            $students->where('school_id', $request->institution);
        }

        if ($request->academic_year != "") {
            $students->where('academic_year', $request->academic_year);
        }

        if ($request->class != "") {
            $students->where('class_id', $request->class);
        }
        if ($request->section != "") {
            $students->where('section_id', $request->section);
        }
        $students = $students->orderBy('id', 'desc');
        $students = $students->get();

        $institutions = SmSchool::all();
        $institution_id = $request->institution;
        return view('parentregistration::saas_student_list', compact('students', 'institution_id', 'institutions'));
    }


    // Approve method for new student regis., after successfully then the student will delete from tempo. stduent table
    public function studentApprove(Request $request)
    {


        DB::beginTransaction();
        try {

            $temp_id = $request->id;

            $request = SmStudentRegistration::find($request->id);


            $student_table_detail = SmStudent::where('school_id', $request->school_id)->max('admission_no');

            $student_table_detail_roll = SmStudent::where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('school_id', $request->school_id)->max('roll_no');




            if ($student_table_detail == 0) {
                $admission_no = 1;
            } else {
                $admission_no = $student_table_detail + 1;
            }

            if ($student_table_detail_roll == 0) {
                $roll_no = 1;
            } else {
                $roll_no = $student_table_detail_roll + 1;
            }


            $created_year = $request->academicYear->year . '-01-01 12:00:00';

            // stduent user

            $user_stu = new User();
            $user_stu->role_id = 2;
            $user_stu->full_name = $request->first_name . ' ' . $request->last_name;


            $user_stu->username = $admission_no;


            $user_stu->email = $request->student_email;


            $user_stu->created_at = $created_year;
            $user_stu->school_id = $request->school_id;

            $user_stu->password = Hash::make(123456);
            $user_stu->save();
            $user_stu->toArray();


            // parent user


            $user_parent = new User();
            $user_parent->role_id = 3;

            //$user_parent->username = 'par-'.$get_admission_number;

            if (empty($request->guardian_email)) {

                $user_parent->username  = 'par' . '-' . $request->school_id . '-' . $admission_no;
            } else {

                $user_parent->username = $request->guardian_email;
            }

            $user_parent->email = $request->guardian_email;
            $user_parent->password = Hash::make(123456);
            $user_parent->created_at = $created_year;
            $user_parent->school_id = $request->school_id;
            $user_parent->save();
            $user_parent->toArray();



            $parent = new SmParent();
            $parent->user_id = $user_parent->id;

            $parent->guardians_name = $request->guardian_name;
            $parent->guardians_mobile = $request->guardian_mobile;
            $parent->guardians_email = $request->guardian_email;


            $parent->relation = $request->guardian_relation;

            if ($request->guardian_relation == 'F') {

                $parent->guardians_relation = 'Father';
            } elseif ($request->guardian_relation == 'M') {

                $parent->guardians_relation = 'Mother';
            } else {
                $parent->guardians_relation = 'Other';
            }


            $parent->created_at = $created_year;
            $parent->school_id = $request->school_id;
            $parent->save();
            $parent->toArray();


            $student = new SmStudent();

            $student->class_id = $request->class_id;
            $student->section_id = $request->section_id;

            $student->admission_date = date('Y-m-d');

            $student->user_id = $user_stu->id;
            $student->parent_id = $parent->id;


            $student->role_id = 2;

            $student->admission_no = $admission_no;

            $student->roll_no = $roll_no;


            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->full_name = $request->first_name . ' ' . $request->last_name;

            $student->gender_id = $request->gender_id;

            $student->date_of_birth = date('Y-m-d', strtotime($request->date_of_birth));
            $student->email = $request->student_email;
            $student->mobile = $request->student_mobile;
            $student->created_at = $created_year;

            $student->school_id = $request->school_id;

            $student->session_id = $request->academic_year;


            $student->save();
            $student->toArray();


            SmStudentRegistration::where('id', $temp_id)->delete();

            DB::commit();

            $setting = SmRegistrationSetting::find(1);

            // checking enable or disable
            if ($setting->approve_after_mail == 1) {


                $user_info = [];

                if ($request->student_email != "") {
                    $user_info[] =  array('email' => $request->student_email, 'id' => $student->id, 'slug' => 'student');
                }


                if ($request->guardian_email != "") {
                    $user_info[] =  array('email' =>  $request->guardian_email, 'id' => $parent->id, 'slug' => 'parent');
                }


                try {


                    foreach ($user_info as $data) {

                        Mail::send('parentregistration::approve_email', compact('data'), function ($message) use ($data) {

                            $settings = SmEmailSetting::find(1);
                            $email = $settings->from_email;
                            $Schoolname = $settings->from_name;

                            $message->to($data['email'], $Schoolname)->subject('Login Credentials');
                            $message->from($email, $Schoolname);
                        });
                    }

                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                } catch (\Exception $e) {
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->back();
                }
            }



            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    // Temporary stduent delete
    public function studentDelete(Request $request)
    {

        try {

            SmStudentRegistration::destroy($request->id);

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    // unique stduent email check by ajax from all school
    public function checkStudentEmail(Request $request)
    {
        $student = User::where('email', $request->id)->where('school_id', $request->school_id)->first();


        $SmStudentRegistration = SmStudentRegistration::where('school_id', $request->school_id)->where(function ($q) use ($request) {
            $q->where('student_email', $request->id)->orWhere('guardian_email', $request->id);
        })->first();

        if ($student != "" || $SmStudentRegistration != "") {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }

    // unique stduent mobile check by ajax from all school
    public function checkStudentMobile(Request $request)
    {
        $student = SmStudent::where('mobile', $request->id)->where('school_id', $request->school_id)->first();
        $SmStudentRegistration = SmStudentRegistration::where('student_mobile', $request->id)->where('school_id', $request->school_id)->first();

        if ($student != "" || $SmStudentRegistration != "") {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }

    // unique guardian email check by ajax from all school
    public function checkGuardianEmail(Request $request)
    {
        $student = User::where('email', $request->id)->where('school_id', $request->school_id)->first();
        $SmStudentRegistration = SmStudentRegistration::where('school_id', $request->school_id)->where(function ($q) use ($request) {
            $q->where('student_email', $request->id)->orWhere('guardian_email', $request->id);
        })->first();

        if ($student != "" || $SmStudentRegistration != "") {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }

    // unique guardian mobile check by ajax from all school
    public function checkGuardianMobile(Request $request)
    {
        $student = SmParent::where('guardians_mobile', $request->id)->where('school_id', $request->school_id)->first();
        $SmStudentRegistration = SmStudentRegistration::where('guardian_mobile', $request->id)->where('school_id', $request->school_id)->first();

        if ($student != "" || $SmStudentRegistration != "") {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }

    public function studentView($id)
    {

        $student_detail = SmStudentRegistration::where('id', $id)->first();

        return view("parentregistration::student_view", compact('student_detail'));
    }


    // registartion setting for regular school and saas
    public function Updatesettings(Request $request)
    {

        try {

            $key1 = 'NOCAPTCHA_SITEKEY';
            $key2 = 'NOCAPTCHA_SECRET';



            $value1 = $request->nocaptcha_sitekey;
            $value2 = $request->nocaptcha_secret;


            $path                   = base_path() . "/.env";
            $NOCAPTCHA_SITEKEY          = env($key1);
            $NOCAPTCHA_SECRET          = env($key2);


            if (file_exists($path)) {
                file_put_contents($path, str_replace(
                    "$key1=" . $NOCAPTCHA_SITEKEY,
                    "$key1=" . $value1,
                    file_get_contents($path)
                ));
                file_put_contents($path, str_replace(
                    "$key2=" . $NOCAPTCHA_SECRET,
                    "$key2=" . $value2,
                    file_get_contents($path)
                ));
            }




            $setting = SmRegistrationSetting::find(1);

            if ($setting == "") {
                $setting = new SmRegistrationSetting();
            }

            if (isset($request->position)) {
                $setting->position = $request->position;
            }

            if (isset($request->registration_permission)) {
                $setting->registration_permission = $request->registration_permission;
            }

            if (isset($request->registration_after_mail)) {
                $setting->registration_after_mail = $request->registration_after_mail;
            }

            if (isset($request->approve_after_mail)) {
                $setting->approve_after_mail = $request->approve_after_mail;
            }

            if (isset($request->recaptcha)) {
                $setting->recaptcha = $request->recaptcha;
            }

            $setting->nocaptcha_sitekey = $request->nocaptcha_sitekey;
            $setting->nocaptcha_secret = $request->nocaptcha_secret;

            $setting->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
