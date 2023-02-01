<?php

namespace App\Http\Controllers\Admin\AdminSection;

use App\Models\StudentRecord;
use App\SmClass;
use App\SmStudent;
use App\SmStudentCertificate;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\AdminSection\SmStudentCertificateRequest;
use App\Http\Requests\Admin\AdminSection\GenerateCertificateSearchRequest;


class SmStudentCertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
        // User::checkAuth();
    }


    public function index()
    {

        try {
            $certificates = SmStudentCertificate::where('active_status', 1)->where('school_id',Auth::user()->school_id)->get();
            return view('backEnd.admin.student_certificate', compact('certificates'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function store(SmStudentCertificateRequest $request)
    {
        $request->validate([
            'name' => "required|max:50",
            'header_left_text' => "nullable",
            'date' => "nullable|date",
            'body' => "nullable",
            'footer_left_text' => "nullable",
            'footer_center_text' => "nullable",
            'footer_right_text' => "nullable",
            'student_photo' => "nullable",
            'file' => "required|mimes:pdf,txt,doc,docx,jpg,jpeg,png|dimensions:width=1100,height=850"

        ]);



        try {

            $destination = 'public/uploads/certificate/';
            $fileName = fileUpload($request->file,$destination);

            $certificate = new SmStudentCertificate();
            $certificate->name = $request->name;
            $certificate->header_left_text = $request->header_left_text;
            $certificate->date = date('Y-m-d', strtotime($request->date));
            $certificate->body = $request->body;
            $certificate->footer_left_text = $request->footer_left_text;
            $certificate->footer_center_text = $request->footer_center_text;
            $certificate->footer_right_text = $request->footer_right_text;
            $certificate->student_photo = $request->student_photo;
            $certificate->file = $fileName;
            $certificate->school_id = Auth::user()->school_id;
            $certificate->academic_id = getAcademicId();

            $result = $certificate->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit($id)
    {

        try {
            if (checkAdmin()) {
                $certificate = SmStudentCertificate::find($id);
            }else{
                $certificate = SmStudentCertificate::where('id',$id)->first();
            }
            $certificates = SmStudentCertificate::get();
            return view('backEnd.admin.student_certificate', compact('certificates', 'certificate'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(SmStudentCertificateRequest $request, $id)
    {


        try {

            $destination = 'public/uploads/certificate/';
            if (checkAdmin()) {
                $certificate = SmStudentCertificate::find($request->id);
            }else{
                $certificate = SmStudentCertificate::where('id',$request->id)->where('school_id',Auth::user()->school_id)->first();
            }
            $certificate->name = $request->name;
            $certificate->header_left_text = $request->header_left_text;
            $certificate->date = date('Y-m-d', strtotime($request->date));
            $certificate->body = $request->body;
            $certificate->footer_left_text = $request->footer_left_text;
            $certificate->footer_center_text = $request->footer_center_text;
            $certificate->footer_right_text = $request->footer_right_text;
            $certificate->student_photo = $request->student_photo;
            $certificate->file = fileUpdate($certificate->file,$request->file,$destination);
            $result = $certificate->save();

            Toastr::success('Operation successful', 'Success');
            return redirect('student-certificate');

        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    public function destroy($id)
    {

        try {
            // $certificate = SmStudentCertificate::find($id);
            if (checkAdmin()) {
                $certificate = SmStudentCertificate::find($id);
            }else{
                $certificate = SmStudentCertificate::where('id',$id)->where('school_id',Auth::user()->school_id)->first();
            }
            unlink($certificate->file);
            $result = $certificate->delete();

            Toastr::success('Operation successful', 'Success');
            return redirect('student-certificate');

        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    // for get route
    public function generateCertificate()
    {

        try {
            $classes = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id',Auth::user()->school_id)->get();
            $certificates = SmStudentCertificate::get();
            return view('backEnd.admin.generate_certificate', compact('classes', 'certificates'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    // for post route
    public function generateCertificateSearch(GenerateCertificateSearchRequest $request)
    {

        try {
            $certificate_id = $request->certificate;
            $class_id = $request->class;

            $students = StudentRecord::when($request->academic_year, function ($query) use ($request) {
                $query->where('academic_id', $request->academic_year);
            })
                ->when($request->class, function ($query) use ($request) {
                    $query->where('class_id', $request->class);
                })
                ->when($request->section, function ($query) use ($request) {
                    $query->where('section_id', $request->section);
                })
                ->when(!$request->academic_year, function ($query) use ($request) {
                    $query->where('academic_id', getAcademicId());
                })->where('school_id', auth()->user()->school_id)->get();

            $classes = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id',Auth::user()->school_id)->get();
            $certificates = SmStudentCertificate::where('active_status', 1)->where('school_id',Auth::user()->school_id)->get();
            return view('backEnd.admin.generate_certificate', compact('classes', 'certificates', 'certificate_id', 'certificates', 'students', 'class_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function generateCertificateGenerate($s_id, $c_id)
    {

        try {
            $s_ids = explode('-', $s_id);
            $students = [];

            foreach ($s_ids as $sId) {
                $students[] = StudentRecord::find($sId);
            }

            $certificate = SmStudentCertificate::find($c_id);

            return view('backEnd.admin.student_certificate_print', ['students' => $students, 'certificate' => $certificate]);
            $pdf = PDF::loadView('backEnd.admin.student_certificate_print', ['students' => $students, 'certificate' => $certificate]);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream('certificate.pdf');
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}