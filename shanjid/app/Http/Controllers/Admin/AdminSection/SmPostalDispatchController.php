<?php

namespace App\Http\Controllers\Admin\AdminSection;

use App\SmPostalDispatch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\AdminSection\SmPostalDispatchRequest;


class SmPostalDispatchController extends Controller
{
    public function __construct()
	{
        $this->middleware('PM');
	}

    public function index(Request $request)
    {
        try{
            $postal_dispatchs = SmPostalDispatch::get();
            return view('backEnd.admin.postal_dispatch', compact('postal_dispatchs'));
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function store(SmPostalDispatchRequest $request)
    {
        try{
            $destination =  'public/uploads/postal/';
            $fileName=fileUpload($request->image,$destination);
            $postal_dispatch = new SmPostalDispatch();
            $postal_dispatch->from_title = $request->from_title;
            $postal_dispatch->reference_no = $request->reference_no;
            $postal_dispatch->address = $request->address;
            $postal_dispatch->date = date('Y-m-d', strtotime($request->date));
            $postal_dispatch->note = $request->note;
            $postal_dispatch->to_title = $request->to_title;
            $postal_dispatch->file = $fileName;
            $postal_dispatch->created_by=Auth::user()->id;
            $postal_dispatch->school_id = Auth::user()->school_id;
            if(moduleStatusCheck('University')){
                $postal_dispatch->un_academic_id = getAcademicId();
            }else{
                $postal_dispatch->academic_id = getAcademicId();
            }
            $postal_dispatch->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function show(Request $request, $id)
    {
        try{
            $postal_dispatchs = SmPostalDispatch::get(); 
            $postal_dispatch = SmPostalDispatch::find($id);
            return view('backEnd.admin.postal_dispatch', compact('postal_dispatchs', 'postal_dispatch'));
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function update(SmPostalDispatchRequest $request)
    {
        try{
            $destination='public/uploads/postal/' ;
            $postal_dispatch = SmPostalDispatch::find($request->id);

            $postal_dispatch->from_title = $request->from_title;
            $postal_dispatch->reference_no = $request->reference_no;
            $postal_dispatch->address = $request->address;
            $postal_dispatch->date = date('Y-m-d', strtotime($request->date));
            $postal_dispatch->note = $request->note;
            $postal_dispatch->to_title = $request->to_title;            
            $postal_dispatch->file =fileUpdate($postal_dispatch->file,$request->file,$destination); 
            if(moduleStatusCheck('University')){
                $postal_dispatch->un_academic_id = getAcademicId();
            }         
            $postal_dispatch->save();

            Toastr::success('Operation successful', 'Success');
            return redirect('postal-dispatch');
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        try{
            $postal_dispatch = SmPostalDispatch::find($id);
            if ($postal_dispatch->file != "") {
                if (file_exists($postal_dispatch->file)) {
                    unlink($postal_dispatch->file);
                }
            }
            $postal_dispatch->delete();

            Toastr::success('Operation successful', 'Success');
            return redirect('postal-dispatch');
        }catch (\Exception $e) {
           Toastr::error('Operation Failed', 'Failed');
           return redirect()->back();
        }
    }
}
