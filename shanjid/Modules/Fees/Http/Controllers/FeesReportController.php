<?php

namespace Modules\Fees\Http\Controllers;

use App\SmClass;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Fees\Entities\FmFeesInvoice;
use Illuminate\Contracts\Support\Renderable;
use Modules\Fees\Entities\FmFeesTransaction;

class FeesReportController extends Controller
{

    public function dueFeesView()
    {
        try {
            $data = $this->allClass();
            return view('fees::report.feesDue', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function dueFeesSearch(Request $request)
    {
        try {
            $data = $this->feesSearch($request->merge(['due'=>true]));
            return view('fees::report.feesDue', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function fineReportView()
    {
        try {
            $data = $this->allClass();
            return view('fees::report.fine', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function fineReportSearch(Request $request)
    {
        try {
            $data = $this->feesSearch($request->merge(['all'=>true]));
            return view('fees::report.fine', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function paymentReportView()
    {
        try {
            $data = $this->allClass();
            return view('fees::report.payment', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function paymentReportSearch(Request $request)
    {
        try {
            $data = $this->feesSearch($request->merge(['all'=>true]));
            return view('fees::report.payment', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function balanceReportView(Request $request)
    {
        try {
            $data = $this->allClass();
            return view('fees::report.balance', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function balanceReportSearch(Request $request)
    {
        try {
            $data = $this->feesSearch($request->merge(['all'=>true]));
            return view('fees::report.balance', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function waiverReportView(Request $request)
    {
        try {
            $data = $this->allClass();
            return view('fees::report.waiver', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function waiverReportSearch(Request $request)
    {
        try {
            $data = $this->feesSearch($request->merge(['all'=>true]));
            return view('fees::report.waiver', $data);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    private function allClass()
    {
            $data['classes'] = SmClass::where('school_id', auth()->user()->school_id)
                        ->where('academic_id', getAcademicId())
                        ->get();
            return $data;
    }

    private function feesSearch($request)
    {
            $data['classes'] = SmClass::where('school_id', auth()->user()->school_id)
                        ->where('academic_id', getAcademicId())
                        ->get();
            $rangeArr = $request->date_range ? explode('-', $request->date_range) : [date('m/d/Y'), date('m/d/Y')];
            if ($request->date_range) {
                $date_from = date('Y-m-d', strtotime(trim($rangeArr[0])));
                $date_to = date('Y-m-d', strtotime(trim($rangeArr[1])));
            }

            $data['fees_dues']  = FmFeesInvoice::when($request->class, function ($query) use ($request) {
                        $query->where('class_id', $request->class);
                    })
                    ->when($request->section, function ($query) use ($request) {
                        $query->whereHas('recordDetail', function($q) use($request){
                            return $q->where('section_id', $request->section);
                        });
                    })
                    ->when($request->student, function ($query) use ($request) {
                        $query->whereHas('recordDetail', function($q) use($request){
                            return $q->where('id', $request->student);
                        });
                    })
                    ->when($request->due, function ($query) use ($date_from, $date_to) {
                        $query->whereBetween('due_date', [$date_from, $date_to]);
                    })
                    ->when($request->all, function ($query) use ($date_from, $date_to) {
                        $query->whereDate('created_at', '>=', $date_from)
                            ->whereDate('created_at', '<=', $date_to);
                    })
                    ->where('school_id', auth()->user()->school_id)
                    ->where('academic_id', getAcademicId())
                    ->get();

            return $data;
    }
}
