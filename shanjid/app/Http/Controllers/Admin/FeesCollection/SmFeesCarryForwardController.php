<?php

namespace App\Http\Controllers\Admin\FeesCollection; 


use App\SmClass;
use App\SmStudent;
use App\ApiBaseMethod;
use App\SmFeesCarryForward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\FeesCollection\SmFeesForwardSearchRequest;
use App\Models\StudentRecord;
use Illuminate\Support\Facades\Validator;

class SmFeesCarryForwardController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
        // User::checkAuth();
	}

    public function feesForward(Request $request)
    {
        try {
            $classes = SmClass::get();
            return view('backEnd.feesCollection.fees_forward', compact('classes'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function feesForwardSearch(SmFeesForwardSearchRequest $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'class' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $classes = SmClass::where('active_status', 1)
                        ->where('academic_id', getAcademicId())
                        ->where('school_id',Auth::user()->school_id)
                        ->get();

            $students = StudentRecord::where('class_id', $request->class)
                        ->where('section_id', $request->section)
                        ->where('school_id',Auth::user()->school_id)
                        ->get();

            if ($students->count() != 0) {
                foreach ($students as $student) {
                    $fees_balance = SmFeesCarryForward::where('student_id', $student->student_id)->count();
                }
                $class_id = $request->class;
                if ($fees_balance == 0) {
                    return view('backEnd.feesCollection.fees_forward', compact('classes', 'students', 'class_id'));
                } else {
                    $update = "";
                    return view('backEnd.feesCollection.fees_forward', compact('classes', 'students', 'update', 'class_id'));
                }
            }else{
                Toastr::error('Operation Failed', 'Failed');
                return redirect('fees-forward');
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function feesForwardStore(Request $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->id as $student) {

                if ($request->update == 1) {

                    $fees_forward = SmFeesCarryForward::find($student);
                    $fees_forward->balance = $request->balance[$student] ?? 0;
                    $fees_forward->notes = $request->notes[$student];
                    $fees_forward->save();
                } else {
                    $fees_forward = new SmFeesCarryForward();
                    $fees_forward->student_id = $student;
                    $fees_forward->balance = $request->balance[$student] ?? 0;
                    $fees_forward->notes = $request->notes[$student];
                    $fees_forward->school_id = Auth::user()->school_id;
                    $fees_forward->academic_id = getAcademicId();
                    $fees_forward->save();
                }
            }
            DB::commit();

            
            Toastr::success('Operation successful', 'Success');
            return redirect('fees-forward');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
