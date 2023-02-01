<?php

namespace Modules\Zoom\Http\Controllers;

use App\User;
use App\SmClass;
use App\SmStaff;
use App\YearCheck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Zoom\Entities\ZoomMeeting;
use Modules\Zoom\Entities\VirtualClass;
use Modules\RolePermission\Entities\InfixRole;

class ReportController extends Controller
{

    public function report(Request $request)
    {


        $module = 'Zoom';
        if (User::checkPermission($module) != 100) {
            Toastr::error('Please verify your ' . $module . ' Module', 'Failed');
            return redirect()->route('Moduleverify', $module);
        }

        try {
            $data['classes'] = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $data['teachers'] = SmStaff::where('active_status', 1)->where('role_id', 4)->where('school_id', Auth::user()->school_id)->get();

            if ($request->has('class_id')) {
                if (Auth::user()->role_id == 4) {
                    $data = $this->setSearchKeywordData($data, $request);
                    $data['meetings'] = $this->virtaulClassSearchTeacher($request);
                } elseif (Auth::user()->role_id == 1) {
                    $data = $this->setSearchKeywordData($data, $request);
                    $data['meetings'] = $this->virtaulClassSearchAdmin($request);
                } else {
                    Toastr::error('Your are not authorized!', 'Failed');
                    return redirect()->back();
                }
            }
            return view('zoom::report.reports', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }

    public function meetingReport(Request $request)
    {

        try {
            $data['roles'] = InfixRole::where(function ($q) {
                $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
            })->whereNotIn('id', [1, 2])->get();
            if ($request->has('member_type')) {
                if (Auth::user()->role_id != 1) {
                    $data['meetings'] = $this->meetingSearchOthers($request);
                } elseif (Auth::user()->role_id == 1) {
                    $data['meetings'] = $this->meetingSearchAdmin($request);
                } else {
                    Toastr::error('Your are not authorized!', 'Failed');
                    return redirect()->back();
                }
                $data = $this->setSearchKeywordDataMeeting($data, $request);
            }
            return view('zoom::report.meetingReports', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }

    private function meetingSearchAdmin($request)
    {
        $from_time =  Carbon::parse($request['from_time'])->startOfDay()->toDateTimeString();
        $to_time =  Carbon::parse($request['to_time'])->endOfDay()->toDateTimeString();

        $query = ZoomMeeting::query();
        $query->with('participates');

        if ($request->has('member_ids')) {
            $query->whereHas('participates', function ($qry) use ($request) {
                return $qry->whereIn('user_id', $request['member_ids']);
            });
        }
        if (!$request->has('member_ids')) {
            $UserIDList = User::where('role_id', $request['member_type'])->where('school_id', Auth::user()->school_id)->pluck('id');
            $query->whereHas('participates', function ($qry) use ($UserIDList) {
                return $qry->whereIn('user_id', $UserIDList);
            });
        }

        $query->when($request->has('from_time') && $request['from_time'] != null && $request->has('to_time') && $request['to_time'] != null, function ($q) use ($from_time, $to_time) {
            return $q->whereBetween('start_time', [$from_time, $to_time]);
        });
        return $query->paginate(10);
    }

    private function meetingSearchOthers($request)
    {
        $from_time =  Carbon::parse($request['from_time'])->startOfDay()->toDateTimeString();
        $to_time =  Carbon::parse($request['to_time'])->endOfDay()->toDateTimeString();

        $query = ZoomMeeting::query();
        $query->with('participates');

        if ($request->has('member_ids')) {
            $query->whereHas('participates', function ($qry) use ($request) {
                return $qry->whereIn('user_id', $request['member_ids']);
            });
        }

        if (!$request->has('member_ids')) {
            $UserIDList = User::where('role_id', $request['member_type'])->where('school_id', Auth::user()->school_id)->pluck('id');
            $query->whereHas('participates', function ($qry) use ($UserIDList) {
                return $qry->whereIn('user_id', $UserIDList);
            });
        }

        $query->when($request->has('from_time') && $request['from_time'] != null && $request->has('to_time') && $request['to_time'] != null, function ($q) use ($from_time, $to_time) {
            return $q->whereBetween('start_time', [$from_time, $to_time]);
        });
        return $query->get();
    }

    private function virtaulClassSearchAdmin($request)
    {
        $from_time =  Carbon::parse($request['from_time'])->startOfDay()->toDateTimeString();
        $to_time =  Carbon::parse($request['to_time'])->endOfDay()->toDateTimeString();

        $query = VirtualClass::query();
        $query->when($request->has('class_id') && $request['class_id'] != null, function ($q) use ($request) {
            return $q->where('class_id', $request['class_id']);
        });
        $query->when($request->has('section_id') && $request['section_id'] != null, function ($q) use ($request) {
            return $q->where('section_id', $request['section_id']);
        });
        $query->when($request->has('teachser_ids') && $request['teachser_ids'] != null, function ($q) use ($request) {
            $q->whereHas('teachers', function ($qry) use ($request) {
                return $qry->whereIn('user_id', [$request['teachser_ids']]);
            });
        });
        $query->when($request->has('from_time') && $request['from_time'] != null && $request->has('to_time') && $request['to_time'] != null, function ($q) use ($from_time, $to_time) {
            return $q->whereBetween('start_time', [$from_time, $to_time]);
        });
        return $query->get();
    }

    private function virtaulClassSearchTeacher($request)
    {
        $from_time =  Carbon::parse($request['from_time'])->startOfDay()->toDateTimeString();
        $to_time =  Carbon::parse($request['to_time'])->endOfDay()->toDateTimeString();

        $query = VirtualClass::query();
        $query->when($request->has('class_id') && $request['class_id'] != null, function ($q) use ($request) {
            return $q->where('class_id', $request['class_id']);
        });
        $query->when($request->has('section_id') && $request['section_id'] != null, function ($q) use ($request) {
            return $q->where('section_id', $request['section_id']);
        });
        $query->when($request->has('teachser_ids') && $request['teachser_ids'] != null, function ($q) {
            $q->whereHas('teachers', function ($qry) {
                return $qry->where('user_id', Auth::user()->id);
            });
        });
        $query->when($request->has('from_time') && $request['from_time'] != null && $request->has('to_time') && $request['to_time'] != null, function ($q) use ($from_time, $to_time) {
            return $q->whereBetween('start_time', [$from_time, $to_time]);
        });
        return $query->get();
    }

    private function  setSearchKeywordData($data, $request)
    {
        $data['class_id']       = $request['class_id'];
        $data['section_id']     = $request['section_id'];
        $data['teachser_ids']   = $request['teachser_ids'];
        $data['from_time']      = $request['from_time'];
        $data['to_time']        = $request['to_time'];
        return $data;
    }

    private function  setSearchKeywordDataMeeting($data, $request)
    {
        $data['member_type']    = $request['member_type'];
        $data['member_ids']     = $request['member_ids'];
        $data['from_time']      = $request['from_time'];
        $data['to_time']        = $request['to_time'];
        return $data;
    }
}
