<?php

namespace App\Http\Controllers\Admin\AdminSection;

use App\SmVisitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Admin\AdminSection\SmVisitorRequest;

class SmVisitorController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
	}

    public function index(Request $request)
    {
        try {
            $visitors = SmVisitor::get();
            return view('backEnd.admin.visitor', compact('visitors'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function store(SmVisitorRequest $request)
    {
        try {
            $destination = 'public/uploads/visitor/';
            $fileName=fileUpload($request->file,$destination); 
            $visitor = new SmVisitor();
            $visitor->name = $request->name;
            $visitor->phone = $request->phone;
            $visitor->visitor_id = $request->visitor_id;
            $visitor->no_of_person = $request->no_of_person;
            $visitor->purpose = $request->purpose;
            $visitor->date = date('Y-m-d',strtotime($request->date));
            $visitor->in_time = $request->in_time;
            $visitor->out_time = $request->out_time;
            $visitor->file = $fileName;
            $visitor->created_by=auth()->user()->id;
            $visitor->school_id = Auth::user()->school_id;
            if(moduleStatusCheck('University')){
                $visitor->un_academic_id = getAcademicId();
            }else{
                $visitor->academic_id = getAcademicId();
            }
            $visitor->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        try{
            $visitor = SmVisitor::find($id);
            $visitors = SmVisitor::orderby('id','DESC')->get();
            return view('backEnd.admin.visitor', compact('visitor', 'visitors'));
        }catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(SmVisitorRequest $request)
    {
        try{
            $destination = 'public/uploads/visitor/';
            $visitor = SmVisitor::find($request->id);
            $visitor->name = $request->name;
            $visitor->phone = $request->phone;
            $visitor->visitor_id = $request->visitor_id;
            $visitor->no_of_person = $request->no_of_person;
            $visitor->purpose = $request->purpose;
            $visitor->date = date('Y-m-d',strtotime($request->date));
            $visitor->in_time = $request->in_time;
            $visitor->out_time = $request->out_time;          
            $visitor->file = fileUpdate($visitor->file,$request->file,$destination);   
            if(moduleStatusCheck('University')){
                $visitor->un_academic_id = getAcademicId();
            }  
            $visitor->save();

            Toastr::success('Operation successful', 'Success');
            return redirect('visitor');
        }catch (\Exception $e) {
          Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function delete(Request $request, $id)
    {
        try{
            $visitor = SmVisitor::find($id);
            if ($visitor->file != "" && file_exists($visitor->file)) {
                    unlink($visitor->file);
            }
            $visitor->delete();

            Toastr::success('Operation successful', 'Success');
            return redirect('visitor');
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function download_files($id){
        try {
            $visitor = SmVisitor::find($id);
            if (file_exists($visitor->file)) {
                return Response::download($visitor->file);
            }
        } catch (\Throwable $th) {
            Toastr::error('File not found', 'Failed');
            return redirect()->back();
        }
    }
}