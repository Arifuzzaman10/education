@extends('backEnd.master')
@section('title')
@lang('hr.generate_payroll')
@endsection
@section('mainContent')

@php  $setting = generalSetting(); if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; } @endphp


<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('hr.staffs_payroll')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="{{route('payroll')}}">@lang('hr.payroll')</a>
                <a href="#">@lang('hr.generate_payroll')</a>
            </div>
        </div>
    </div>
</section>
<section class="student-details mb-40">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="main-title">
                    <h3 class="mb-30">@lang('hr.generate_payroll')</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="student-meta-box">
                    <div class="student-meta-top staff-meta-top"></div>
                    <img class="student-meta-img img-100" src="{{asset($staffDetails->staff_photo)}}"  alt="">
                    <div class="white-box">
                        <div class="single-meta mt-20">
                            <div class="row">
                                <div class="col-lg-2 col-md-6">
                                    <div class="name">
                                        @lang('common.name')
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="value text-left">
                                        @if(isset($staffDetails)){{$staffDetails->full_name}}@endif
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="name">
                                        @lang('hr.staff_no')
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="value text-left">
                                        @if(isset($staffDetails)){{$staffDetails->staff_no}}@endif
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-3 col-3">
                                    <div class="value text-left">
                                        @lang('hr.month')
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-9 d-flex col-9">
                                    <div class="value ml-20" data-toggle="tooltip" title="Present!">
                                        P
                                    </div>
                                    <div class="value ml-20" data-toggle="tooltip" title="Late!">
                                        L
                                    </div>
                                    <div class="value ml-20" data-toggle="tooltip" title="Absent!">
                                        A
                                    </div>
                                    <div class="value ml-20" data-toggle="tooltip" title="Half Day!">
                                        F
                                    </div>
                                    <div class="value ml-20" data-toggle="tooltip" title="Holiday!">
                                        H
                                    </div>
                                    <div class="value ml-20" data-toggle="tooltip" title="Approved Leave!">
                                        V
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="single-meta">
                            <div class="row">
                                <div class="col-lg-2 col-md-6">
                                    <div class="name">
                                        @lang('common.mobile')
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="value text-left">
                                       @if(isset($staffDetails)){{$staffDetails->mobile}}@endif
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="name">
                                        @lang('common.email')
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="value text-left">
                                        @if(isset($staffDetails)){{$staffDetails->email}}@endif
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-3 col-3">
                                    <div class="value text-left">
                                        {{$payroll_month}}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-9 d-flex col-9">
                                    <div class="value ml-20">
                                        
                                        {{$p}}
                                    </div>
                                    <div class="value ml-20">
                                        
                                        {{$l}}
                                    </div>
                                    <div class="value ml-20">
                                        
                                        {{$a}}
                                    </div>
                                    <div class="value ml-20">
                                        
                                        {{$f}}
                                    </div>
                                    <div class="value ml-20">
                                        
                                        {{$h}}
                                    </div>
                                    <div class="value ml-20">
                                        V
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="row">
                                <div class="col-lg-2 col-md-6">
                                    <div class="name">
                                        @lang('hr.role')
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="value text-left">
                                        @if(isset($staffDetails)){{$staffDetails->roles->name}}@endif
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="name">
                                        @lang('hr.department')
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="value text-left">
                                        @if(isset($staffDetails)){{$staffDetails->departments?$staffDetails->departments->name:''}}@endif
                                    </div>
                                </div>
                                 
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="row">
                                <div class="col-lg-2 col-md-6">
                                    <div class="name">
                                        @lang('hr.designation')
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="value text-left">
                                       @if(isset($staffDetails)){{$staffDetails->designations ? $staffDetails->designations->title :''}}@endif
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="name">
                                        @lang('hr.date_of_joining')
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="value text-left">
                                        @if(isset($staffDetails))
                                           {{$staffDetails->date_of_joining != ""? dateConvert($staffDetails->date_of_joining):''}}

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(moduleStatusCheck('Lms')==true)
                             @if(in_array($staffDetails->role_id,[4]))
                                <div class="single-meta">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-6">
                                            <div class="name">
                                                @lang('lms::lms.total_course')
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <div class="value text-left">@lang('lms::lms.total_sell') </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <div class="name">
                                                @lang('lms::lms.this_month_sell')
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <div class="value text-left">
                                                @lang('lms::lms.this_month_revenue')
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <div class="value text-left">
                                                @lang('lms::lms.payable_amount')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-meta">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-6">
                                            <div class="name">
                                            {{$totalCourse}}
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <div class="value text-left"> {{$totalSellCourseCount}} </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <div class="name">
                                                {{generalSetting()->currency_symbol}} {{ $thisMonthSell }}
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <div class="value text-left">
                                                {{generalSetting()->currency_symbol}} {{ $thisMonthRevenue }}
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <div class="value text-left">
                                                {{generalSetting()->currency_symbol}} {{ $staffDetails->lms_balance }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif    
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'savePayrollData', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
<section class="">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="d-flex justify-content-between mb-20">
                    <div class="main-title">
                        <h3>@lang('hr.earnings')</h3>
                    </div>

                    <div>
                        <button type="button" class="primary-btn icon-only fix-gr-bg" onclick="addMoreEarnings()">
                            <span class="ti-plus"></span>
                        </button>
                    </div>
                </div>

                <div class="white-box">
                    <table class="w-100 table-responsive" id="tableID">
                        <tbody id="addEarningsTableBody">
                            @if($staffDetails->lms_balance && moduleStatusCheck('Lms')==true)
                                <tr id="rowLms">
                                    <td width="80%" class="pr-30">
                                        <div class="input-effect mt-10">
                                            <input class="primary-input form-control infi_input" type="hidden" id="earningsType0" name="earningsType[]" value="lms_balance">
                                            <label for="earningsType0">@lang('lms::lms.lms_balance')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </td>
                                    <td width="20%">
                                        <div class="input-effect mt-10">
                                            <input oninput="numberCheckWithDot(this)" class="primary-input form-control" type="text" oninput="this.value = Math.abs(this.value)" id="earningsValue0"  name="earningsValue[]" value="{{ $staffDetails->lms_balance }}">
                                            <label for="earningsValue0">@lang('hr.value')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </td>
                                    
                                </tr>
                                <tr id="row0">
                                    <td width="80%" class="pr-30">
                                        <div class="input-effect mt-10">
                                            <input class="primary-input form-control infi_input" type="text" id="earningsType0" name="earningsType[]">
                                            <label for="earningsType0">@lang('common.type')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </td>
                                    <td width="20%">
                                        <div class="input-effect mt-10">
                                            <input oninput="numberCheckWithDot(this)" class="primary-input form-control" type="text" oninput="this.value = Math.abs(this.value)" id="earningsValue0"  name="earningsValue[]">
                                            <label for="earningsValue0">@lang('hr.value')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </td>
                                    
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4 no-gutters">
                <div class="d-flex justify-content-between mb-20">
                    <div class="main-title">
                        <h3>@lang('hr.deductions')</h3>
                    </div>

                    <div>
                        <button type="button" class="primary-btn icon-only fix-gr-bg" onclick="addDeductions()">
                            <span class="ti-plus"></span>
                        </button>
                    </div>
                </div>

                <div class="white-box">
                <table class="w-100 table-responsive" id="tableDeduction">
                        <tbody id="addDeductionsTableBody">
                            <tr id="DeductionRow0">
                                <td width="80%" class="pr-30">
                                    <div class="input-effect mt-10">
                                        <input class="primary-input form-control" type="text" id="deductionstype0" name="deductionstype[]">
                                        <label for="deductionstype0">@lang('common.type')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </td>
                                <td width="20%">
                                    <div class="input-effect mt-10">
                                        <input class="primary-input form-control" type="text" oninput="this.value = Math.abs(this.value)" id="deductionsValue0" name="deductionsValue[]">
                                        <label for="deductionsValue0">@lang('hr.value')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4 no-gutters">
                <div class="d-flex justify-content-between mb-20">
                    <div class="main-title">
                        <h3>@lang('hr.payroll_summary')</h3>
                    </div>

                    <div>
                        <button type="button" class="primary-btn small fix-gr-bg" onclick="calculateSalary()">
                            @lang('hr.calculate')
                        </button>
                    </div>
                </div>

                <input type="hidden" name="staff_id" value="{{$staffDetails->id}}">
                <input type="hidden" name="payroll_month" value="{{$payroll_month}}">
                <input type="hidden" name="payroll_year" value="{{$payroll_year}}">


                <div class="white-box">
                <table class="w-100 table-responsive">
                        <tbody class="d-block">
                            <tr class="d-block">
                                <td width="100%" class="pr-30 d-block">
                                    <div class="input-effect mt-10">
                                        <input class="primary-input form-control" type="text" id="basicSalary" value="{{$staffDetails->basic_salary}}" name="basic_salary" readonly>
                                        <label for="basicSalary">@lang('hr.basic_salary') ({{generalSetting()->currency_symbol}})</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="d-block">
                                <td width="100%" class="pr-30 d-block">
                                    <div class="input-effect mt-30">
                                        <input class="primary-input form-control" readonly type="text" id="total_earnings" name="total_earning">
                                        <label for="total_earnings">@lang('hr.earning')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="d-block">
                                <td width="100%" class="pr-30 d-block">
                                    <div class="input-effect mt-30">
                                        <input class="primary-input form-control" type="text" readonly id="total_deduction" name="total_deduction">
                                        <label for="total_deduction">@lang('hr.deduction')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="d-block">
                                <td width="100%" class="pr-30 d-block">
                                    <div class="input-effect mt-30">
                                        <input class="primary-input form-control" type="text" readonly id="leave_deduction" value="{{round(($staffDetails->basic_salary/30) * $extra_days)}}" name="leave_deduction">
                                        <input type="hidden" name="extra_leave_taken" value="{{@$extra_days}}">
                                        <label for="leave_deduction">@lang('hr.leave') @lang('hr.deduction') ({{generalSetting()->currency_symbol}})</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="d-block">
                                <td width="100%" class="pr-30 d-block">
                                    <div class="input-effect mt-30">
                                        <input class="primary-input form-control" readonly type="text" id="gross_salary" value="0">
                                        <input type="hidden" name="final_gross_salary" id="final_gross_salary">
                                        <label for="gross_salary">@lang('hr.gross_salary')  ({{generalSetting()->currency_symbol}})</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="d-block">
                                <td width="100%" class="pr-30 d-block">
                                    <div class="input-effect mt-30">
                                        <input class="primary-input form-control"  type="text" id="tax" value="0" name="tax">
                                        <label for="tax">@lang('hr.tax')</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="d-block">
                                <td width="100%" class="pr-30 d-block">
                                    <div class="input-effect mt-30 mb-30">
                                        <input class="primary-input form-control{{ $errors->has('net_salary') ? ' is-invalid' : '' }}" readonly type="text" id="net_salary" name="net_salary">
                                        <label for="net_salary">@lang('hr.net_salary') ({{generalSetting()->currency_symbol}})</label>
                                        <span class="focus-border"></span>

                                        @if ($errors->has('net_salary'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('net_salary') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12 mt-20 text-right">
                <!-- <button type="submit" class="primary-btn small fix-gr-bg">
                    Submit
                </button> -->

                @if(userPermission(175))

              

                <button class="primary-btn fix-gr-bg">
                    <span class="ti-check"></span>
                    @lang('hr.submit')
                </button>
                @endif
            </div>
           
            </div>
        </div>
    </div>
</section>
{{ Form::close() }}
<!-- End Modal Area -->
@endsection
