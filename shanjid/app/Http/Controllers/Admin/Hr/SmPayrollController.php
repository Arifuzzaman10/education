<?php

namespace App\Http\Controllers\Admin\Hr;

use App\Role;
use App\SmStaff;
use Carbon\Carbon;
use App\SmAddExpense;
use App\SmBankAccount;
use App\SmBankStatement;
use App\SmChartOfAccount;
use App\SmGeneralSettings;
use App\SmHrPayrollEarnDeduc;
use App\SmHrPayrollGenerate;
use App\SmLeaveDeductionInfo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\SmLeaveDefine;
use App\SmPaymentMethhod;
use App\SmStaffAttendence;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\RolePermission\Entities\InfixRole;

class SmPayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
        // User::checkAuth();
    }

    public function index(Request $request)
    {

        try {
            $roles = InfixRole::where('active_status', '=', '1')->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where('id', '!=', 10)->where(function ($q) {
                $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
            })
                ->orderBy('name', 'asc')
                ->get();
            return view('backEnd.humanResource.payroll.index', compact('roles'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function searchStaffPayr(Request $request)
    {

        $request->validate([
            'role_id' => "required",
            'payroll_month' => "required",
            'payroll_year' => "required",

        ]);

        try {
            $role_id = $request->role_id;
            $payroll_month = $request->payroll_month;
            $payroll_year = $request->payroll_year;

            $staffs = SmStaff::where('active_status', '=', '1')->where('role_id', '=', $request->role_id)->where('school_id', Auth::user()->school_id)->get();

            $roles = InfixRole::where('active_status', '=', '1')->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where(function ($q) {
                $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
            })->get();
            return view('backEnd.humanResource.payroll.index', compact('staffs', 'roles', 'payroll_month', 'payroll_year', 'role_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function generatePayroll(Request $request, $id, $payroll_month, $payroll_year)
    {

        try {
            $staffDetails = SmStaff::find($id);
            // return $staffDetails;
            $month = date('m', strtotime($payroll_month));
           
            $attendances = SmStaffAttendence::where('staff_id', $id)->where('attendence_date', 'like', $payroll_year . '-' . $month . '%')->where('school_id', Auth::user()->school_id)->get();

            $staff_leaves = SmLeaveDefine::where('user_id', $staffDetails->user_id)->where('role_id', $staffDetails->role_id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $staff_leave_deduct_days = SmLeaveDeductionInfo::where('staff_id', $id)->where('pay_year', $payroll_year)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get()->sum("extra_leave");

            // return $payroll_year;
            foreach ($staff_leaves as $staff_leave) {
                //  $approved_leaves = SmLeaveRequest::approvedLeave($staff_leave->id);
                $remaining_days = $staff_leave->days - $staff_leave->remainingDays;
                $extra_Leave_days = $remaining_days < 0 ? $staff_leave->remainingDays - $staff_leave->days : 0;
            }

            if ($staff_leave_deduct_days != "") {
                $extra_days = @$extra_Leave_days-@$staff_leave_deduct_days;
            } else {
                $extra_days = @$extra_Leave_days;
            }

            // return $extra_days;

            // $approved_leave = SmLeaveRequest::where('staff_id', $id)->where('active_status',1)->where('approve_status','A')->where('school_id', Auth::user()->school_id)->get();
            // return $extra_days;
            $p = 0;
            $l = 0;
            $a = 0;
            $f = 0;
            $h = 0;
            foreach ($attendances as $value) {
                if ($value->attendence_type == 'P') {
                    $p++;
                } elseif ($value->attendence_type == 'L') {
                    $l++;
                } elseif ($value->attendence_type == 'A') {
                    $a++;
                } elseif ($value->attendence_type == 'F') {
                    $f++;
                } elseif ($value->attendence_type == 'H') {
                    $h++;
                }
            }
            // for teacher commission Lms module-abu nayem
             if (moduleStatusCheck('Lms')==true) {
                $data['courses'] = \Modules\Lms\Entities\CourseTeacher::where('staff_id', $id)->get(['id','course_id']);
                $data['courseIds'] = $data['courses']->pluck('course_id')->toArray();
                $data['totalCourse'] = $data['courses']->count();
                $totalSellCourse = \Modules\Lms\Entities\CoursePurchaseLog::whereIn('course_id', $data['courseIds'])->where('active_status', 'approve');
                $data['totalSellCourseCount'] = $totalSellCourse->count();
                $data['thisMonthSell'] = $totalSellCourse->whereMonth('created_at', $month)
                                                         ->whereYear('created_at', $payroll_year)
                                                         ->count();
                $thisMonthSellAmount =  $totalSellCourse->sum('amount');
                $teacher_commission = \Modules\Lms\Entities\CourseSetting::first()->teacher_commission;
                $data['thisMonthRevenue'] = earnRevenue($thisMonthSellAmount, $teacher_commission);
                return view('backEnd.humanResource.payroll.generatePayroll', compact('staffDetails', 'payroll_month', 'payroll_year', 'p', 'l', 'a', 'f', 'h', 'extra_days'))->with($data);
             }
             //end teacher commission 
            return view('backEnd.humanResource.payroll.generatePayroll', compact('staffDetails', 'payroll_month', 'payroll_year', 'p', 'l', 'a', 'f', 'h', 'extra_days'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function savePayrollData(Request $request)
    {
        // return $request->all();
        $request->validate([
            'net_salary' => "required",
        ]);

        try {
            $payrollGenerate = new SmHrPayrollGenerate();
            $payrollGenerate->staff_id = $request->staff_id;
            $payrollGenerate->payroll_month = $request->payroll_month;
            $payrollGenerate->payroll_year = $request->payroll_year;
            $payrollGenerate->basic_salary = $request->basic_salary;
            $payrollGenerate->total_earning = $request->total_earning;
            $payrollGenerate->total_deduction = $request->total_deduction;
            $payrollGenerate->gross_salary = $request->final_gross_salary;
            $payrollGenerate->tax = $request->tax;
            $payrollGenerate->net_salary = $request->net_salary;
            $payrollGenerate->payroll_status = 'G';
            $payrollGenerate->created_by = Auth()->user()->id;
            $payrollGenerate->school_id = Auth::user()->school_id;
            if(moduleStatusCheck('University')){
                $payrollGenerate->un_academic_id = getAcademicId();
            }else{
                $payrollGenerate->academic_id = getAcademicId();
            }
            $result = $payrollGenerate->save();
            $payrollGenerate->toArray();

            if ($request->leave_deduction > 0) {
                $leave_deduct = new SmLeaveDeductionInfo;
                $leave_deduct->staff_id = $request->staff_id;
                $leave_deduct->payroll_id = $payrollGenerate->id;
                $leave_deduct->extra_leave = $request->extra_leave_taken;
                $leave_deduct->salary_deduct = $request->leave_deduction;
                $leave_deduct->pay_month = $request->payroll_month;
                $leave_deduct->pay_year = $request->payroll_year;
                $leave_deduct->created_by = Auth()->user()->id;
                $leave_deduct->school_id = Auth::user()->school_id;
                if(moduleStatusCheck('University')){
                    $leave_deduct->un_academic_id = getAcademicId();
                }else{
                    $leave_deduct->academic_id = getAcademicId();
                }
                $leave_deduct->save();
            }

            if ($result) {
                $earnings = count($request->get('earningsType', []));
                for ($i = 0; $i < $earnings; $i++) {
                    if (!empty($request->earningsType[$i]) && !empty($request->earningsValue[$i])) {
                         // for teacher commission Lms module-abu nayem                      
                            if ($request->earningsType[0]=='lms_balance' && moduleStatusCheck('Lms')==true) {
                                $payable_amount =  $request->earningsValue[0];
                                $staff = SmStaff::findOrFail($request->staff_id);
                                $lms_balance = $staff->lms_balance;
                                if ($payable_amount>0) {
                                    $balance = $lms_balance - $payable_amount;
                                    $staff->lms_balance = $balance;
                                    $staff->save();
                                }
                            }
                        //end    
                        $payroll_earn_deducs = new SmHrPayrollEarnDeduc;
                        $payroll_earn_deducs->payroll_generate_id = $payrollGenerate->id;
                        $payroll_earn_deducs->type_name = $request->earningsType[$i];
                        $payroll_earn_deducs->amount = $request->earningsValue[$i];
                        $payroll_earn_deducs->earn_dedc_type = 'E';
                        $payroll_earn_deducs->created_by = Auth()->user()->id;
                        $payroll_earn_deducs->school_id = Auth::user()->school_id;
                        if(moduleStatusCheck('University')){
                            $payroll_earn_deducs->un_academic_id = getAcademicId();
                        }else{
                            $payroll_earn_deducs->academic_id = getAcademicId();
                        }
                        $result = $payroll_earn_deducs->save();
                    }
                }

                $deductions = count($request->get('deductionstype', []));
                for ($i = 0; $i < $deductions; $i++) {
                    if (!empty($request->deductionstype[$i]) && !empty($request->deductionsValue[$i])) {
                       
                     
                        $payroll_earn_deducs = new SmHrPayrollEarnDeduc;
                        $payroll_earn_deducs->payroll_generate_id = $payrollGenerate->id;
                        $payroll_earn_deducs->type_name = $request->deductionstype[$i];
                        $payroll_earn_deducs->amount = $request->deductionsValue[$i];
                        $payroll_earn_deducs->earn_dedc_type = 'D';
                        $payroll_earn_deducs->school_id = Auth::user()->school_id;
                        if(moduleStatusCheck('University')){
                            $payroll_earn_deducs->un_academic_id = getAcademicId();
                        }else{
                            $payroll_earn_deducs->academic_id = getAcademicId();
                        }
                        $result = $payroll_earn_deducs->save();
                    }
                }
                Toastr::success('Operation successful', 'Success');
                return redirect('payroll');
            } else {
                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function paymentPayroll(Request $request, $id, $role_id)
    {
        try {
            $chart_of_accounts = SmChartOfAccount::where('type', 'E')
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $payrollDetails = SmHrPayrollGenerate::find($id);

            $paymentMethods = SmPaymentMethhod::whereIn('method', ['Cash', 'Cheque', 'Bank'])
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $account_id = SmBankAccount::where('school_id', Auth::user()->school_id)
                ->get();

            return view('backEnd.humanResource.payroll.paymentPayroll', compact('payrollDetails', 'paymentMethods', 'role_id', 'chart_of_accounts', 'account_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function savePayrollPaymentData(Request $request)
    {
        $request->validate([
            'expense_head_id' => "required",
        ]);

        try {
            $payroll_month = $request->payroll_month;
            $payroll_year = $request->payroll_year;

            $payments = SmHrPayrollGenerate::find($request->payroll_generate_id);
            $payments->payment_date = date('Y-m-d', strtotime($request->payment_date));
            $payments->payment_mode = $request->payment_mode;
            $payments->note = $request->note;
            $payments->payroll_status = 'P';
            $payments->updated_by = Auth()->user()->id;
            if(moduleStatusCheck('University')){
                $payments->un_academic_id = getAcademicId();
            }else{
                $payments->academic_id = getAcademicId();
            }
            $result = $payments->update();

            $leave_deduct = SmLeaveDeductionInfo::where('payroll_id', $request->payroll_generate_id)->first();
            if (!empty($leave_deduct)) {
                $leave_deduct->active_status = 1;
                $leave_deduct->save();
            }

            if ($result) {
                $store = new SmAddExpense();
                $store->name = 'Staff Payroll';
                $store->expense_head_id = $request->expense_head_id;
                $store->payment_method_id = $request->payment_mode;
                if ($request->payment_mode == 3) {
                    $store->account_id = $request->bank_id;
                }
                if(moduleStatusCheck('University')){
                    $store->un_academic_id = getAcademicId();
                }else{
                    $store->academic_id = getAcademicId();
                }
                $store->date = Carbon::now();
                $store->amount = $payments->net_salary;
                $store->description = 'Staff Payroll Payment';
                $store->school_id = Auth::user()->school_id;
                $store->save();
            }

            if ($request->payment_mode == 3) {
                $bank = SmBankAccount::where('id', $request->bank_id)
                    ->where('school_id', Auth::user()->school_id)
                    ->first();
                $after_balance = $bank->current_balance - $payments->net_salary;

                $bank_statement = new SmBankStatement();
                $bank_statement->amount = $payments->net_salary;
                $bank_statement->after_balance = $after_balance;
                $bank_statement->type = 0;
                $bank_statement->details = "Staff Payroll Payment";
                $bank_statement->item_receive_id = $payments->id;
                $bank_statement->payment_date = date('Y-m-d', strtotime($request->payment_date));
                $bank_statement->bank_id = $request->bank_id;
                $bank_statement->school_id = Auth::user()->school_id;
                $bank_statement->payment_method = $request->payment_method;
                $bank_statement->save();

                $current_balance = SmBankAccount::find($request->bank_id);
                $current_balance->current_balance = $after_balance;
                $current_balance->update();
            }

            $staffs = SmStaff::where('active_status', '=', '1')->where('role_id', '=', $request->role_id)->where('school_id', Auth::user()->school_id)->get();
            $roles = InfixRole::where('active_status', '=', '1')->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where(function ($q) {
                $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
            })->get();
            Toastr::success('Operation successful', 'Success');
            return view('backEnd.humanResource.payroll.index', compact('staffs', 'roles', 'payroll_month', 'payroll_year'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function viewPayslip($id)
    {

        try {
            $schoolDetails = SmGeneralSettings::where('school_id', auth()->user()->school_id)->first();
            $payrollDetails = SmHrPayrollGenerate::find($id);

            $payrollEarnDetails = SmHrPayrollEarnDeduc::where('active_status', '=', '1')->where('payroll_generate_id', '=', $id)->where('earn_dedc_type', '=', 'E')->where('school_id', Auth::user()->school_id)->get();

            $payrollDedcDetails = SmHrPayrollEarnDeduc::where('active_status', '=', '1')->where('payroll_generate_id', '=', $id)->where('earn_dedc_type', '=', 'D')->where('school_id', Auth::user()->school_id)->get();

            return view('backEnd.humanResource.payroll.viewPayslip', compact('payrollDetails', 'payrollEarnDetails', 'payrollDedcDetails', 'schoolDetails'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function printPayslip($id)
    {

        try {
            $schoolDetails = SmGeneralSettings::where('school_id', auth()->user()->school_id)->first();
            $payrollDetails = SmHrPayrollGenerate::find($id);

            $payrollEarnDetails = SmHrPayrollEarnDeduc::where('active_status', '=', '1')->where('payroll_generate_id', '=', $id)->where('earn_dedc_type', '=', 'E')->where('school_id', Auth::user()->school_id)->get();

            $payrollDedcDetails = SmHrPayrollEarnDeduc::where('active_status', '=', '1')->where('payroll_generate_id', '=', $id)->where('earn_dedc_type', '=', 'D')->where('school_id', Auth::user()->school_id)->get();

            return view('backEnd.humanResource.payroll.payslip_print', compact('payrollDetails', 'payrollEarnDetails', 'payrollDedcDetails', 'schoolDetails'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }

    }

    public function payrollReport(Request $request)
    {
        try {
            $roles = InfixRole::where('active_status', '=', '1')->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where(function ($q) {
                $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
            })
                ->orderBy('name', 'asc')
                ->get();
            return view('backEnd.reports.payroll', compact('roles'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function searchPayrollReport(Request $request)
    {
        $request->validate([
            'role_id' => "required",
            'payroll_month' => "required",
            'payroll_year' => "required",

        ]);
        try {
            $role_id = $request->role_id;
            $payroll_month = $request->payroll_month;
            $payroll_year = $request->payroll_year;

            $query = '';
            if ($request->role_id != "") {
                $query = "AND s.role_id = '$request->role_id'";
            }
            if ($request->payroll_month != "") {
                $query .= "AND pg.payroll_month = '$request->payroll_month'";
            }

            if ($request->payroll_year != "") {
                $query .= "AND pg.payroll_year = '$request->payroll_year'";
            }

            $school_id = Auth::user()->school_id;

            $staffsPayroll = DB::select(DB::raw("SELECT pg.*, s.full_name, r.name, d.title
												FROM sm_hr_payroll_generates pg
												LEFT JOIN sm_staffs s ON pg.staff_id = s.id
												LEFT JOIN roles r ON s.role_id = r.id
												LEFT JOIN sm_designations d ON s.designation_id = d.id
												WHERE pg.active_status AND pg.payroll_status='P' AND pg.school_id = '$school_id'

												$query"));

            $roles = InfixRole::where('active_status', '=', '1')->where('id', '!=', 1)->where('id', '!=', 2)->where('id', '!=', 3)->where(function ($q) {
                $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
            })->get();
            return view('backEnd.reports.payroll', compact('staffsPayroll', 'roles', 'payroll_month', 'payroll_year', 'role_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
