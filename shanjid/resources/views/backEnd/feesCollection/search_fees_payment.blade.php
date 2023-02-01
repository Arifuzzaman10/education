@extends('backEnd.master')
@section('title') 
@lang('fees.search_fees_payment')
@endsection
@section('mainContent')
@php  $setting = generalSetting(); if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; } @endphp

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('fees.search_fees_payment')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('fees.fees_collection')</a>
                <a href="#">@lang('fees.search_fees_payment')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">               
                <div class="white-box">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'fees_payment_search', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                            @if(moduleStatusCheck('University'))
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input name="date_from" readonly
                                           class="primary-input date {{ $errors->has('date_from') ? ' is-invalid' : '' }}"
                                           type="text" autocomplete="off"
                                           value="{{ isset($date_from) ? ($date_from != '' ? $date_from : '') : old('date_from') }}">
                                    <label>@lang('university::un.date_from') <span></span></label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('date_from'))
                                        <span class="invalid-feedback" role="alert" style="display:block">
                                            <strong>{{ $errors->first('date_from') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-effect">
                                    <input name="date_to" readonly
                                           class="primary-input date {{ $errors->has('date_to') ? ' is-invalid' : '' }}"
                                           type="text" autocomplete="off"
                                           value="{{ isset($date_to) ? ($date_to != '' ? $date_to : '') : old('date_to') }}">
                                    <label>@lang('university::un.date_to') <span></span> </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('date_to'))
                                        <span class="invalid-feedback invalid-select" role="alert" style="display:block">
                                            <strong>{{ $errors->first('date_to') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @includeIf('university::common.session_faculty_depart_academic_semester_level',  ['hide'=>['USUB'],'required'=> ['US','UF','UD','UA','USN','US','USL'], 'dept_mt'=>'mt-25', 'ac_mt'=>'mt-25'])
                            @else
                            <div class="col-lg-3 mt-30-md">
                                <div class="input-effect">
                                    <input name="date_from" readonly
                                           class="primary-input date {{ $errors->has('date_from') ? ' is-invalid' : '' }}"
                                           type="text" autocomplete="off"
                                           value="{{ isset($date_from) ? ($date_from != '' ? $date_from : '') : old('date_from') }}">
                                    <label>@lang('fees.date_from') <span></span></label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('date_from'))
                                        <span class="invalid-feedback" role="alert" style="display:block">
                                            <strong>{{ $errors->first('date_from') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3 mt-30-md">
                                <div class="input-effect">
                                    <input name="date_to" readonly
                                           class="primary-input date {{ $errors->has('date_to') ? ' is-invalid' : '' }}"
                                           type="text" autocomplete="off"
                                           value="{{ isset($date_to) ? ($date_to != '' ? $date_to : '') : old('date_to') }}">
                                    <label>@lang('fees.date_to') <span></span> </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('date_to'))
                                        <span class="invalid-feedback invalid-select" role="alert" style="display:block">
                                            <strong>{{ $errors->first('date_to') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                           
                            <div class="col-lg-3 mt-30-md">
                                <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                    <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class') *</option>
                                    @foreach(@$classes as $class)
                                    <option value="{{$class->id}}"  {{( old("class") == $class->id ? "selected":"")}}>{{$class->class_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('class'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('class') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-3 mt-30-md" id="select_section_div">
                                <select class="w-100 bb niceSelect form-control{{ $errors->has('current_section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                    <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section')</option>
                                </select>
                                <div class="pull-right loader loader_style" id="select_section_loader">
                                    <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                </div>
                                @if ($errors->has('section'))
                                <span class="invalid-feedback invalid-select d-block" role="alert">
                                    <strong>{{ $errors->first('section') }}</strong>
                                </span>
                                @endif
                            </div>
                            @endif

                            <div class="col-lg-6 mt-30">
                                <div class="input-effect">
                                    <input class="primary-input form-control" type="text" name="keyword">
                                    <label>@lang('common.search_by_name'), @lang('student.admission_no'),@lang('student.roll_no')</label>
                                    <span class="focus-border"> </span>
                                </div>
                            </div>
                                                            

                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-search pr-2"></span>
                                    @lang('common.search')
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        @if (@$fees_payments)            
        <div class="row mt-40">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0"> @lang('fees.payment_ID_Details')</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>@lang('fees.payment_id')</th>
                                    <th>@lang('common.date')</th>
                                    <th>@lang('common.name')</th>
                                    @if(moduleStatusCheck('University'))
                                    <th>@lang('university::un.semester_label')</th>
                                    <th>@lang('university::un.installment')</th>
                                    @else
                                    <th>@lang('common.class')</th>
                                    @if(directFees())
                                    <th>@lang('fees.installment')</th>
                                    @else
                                    <th>@lang('fees.fees_type')</th>
                                    @endif
                                    @endif
                                    <th>@lang('fees.mode')</th>
                                    <th>@lang('fees.amount') ({{generalSetting()->currency_symbol}}) </th>
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($fees_payments as $fees_payment)
                                    @if($fees_payment->recordDetail)
                                        <tr>
                                            @if(moduleStatusCheck('University'))
                                            <td>{{universityFeesInvoice(@$fees_payment->installmentPayment->invoice_no)}}</td>
                                            @elseif( directFees())
                                            <td>{{smFeesInvoice(@$fees_payment->installmentPayment->invoice_no)}} </td>
                                            @else
                                            <td>{{$fees_payment->id.'/'.$fees_payment->fees_type_id}}</td>
                                            @endif
                                            <td>{{ dateConvert($fees_payment->payment_date)}}</td>
                                            <td>{{@$fees_payment->recordDetail->studentDetail->full_name}}</td>
                                            @if(moduleStatusCheck('University'))
                                            <td>{{@$fees_payment->recordDetail->semesterLabel->name}} ({{@$fees_payment->recordDetail->unDepartment->name}})</td>
                                            <td>{{@$fees_payment->feesInstallment->installment->title}}</td>
                                            @else
                                            <td>{{@$fees_payment->recordDetail->class->class_name}} ({{@$fees_payment->recordDetail->section->section_name}})</td>
                                            @if(directFees())
                                            <td>{{@$fees_payment->feesInstallment->installment->title}}</td>
                                            @else
                                            <td>{{@$fees_payment->feesType->name}}</td>
                                            @endif
                                            @endif
                                            <td>{{$fees_payment->payment_mode}}</td>
                                            <td>{{generalSetting()->currency_symbol}} {{$fees_payment->amount}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                        @lang('common.select')
                                                    </button>
                                                    @if(userPermission(115)) 
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            @if($fees_payment->assign_id !=null)
                                                                <a class="dropdown-item modalLink" data-modal-size="modal-lg" title="@lang('fees.edit_fees_payment')"  href="{{route('edit-fees-payment', [$fees_payment->id])}}" >@lang('fees.edit_fees') </a>
                                                            @endif
                                                            <a class="dropdown-item" target="_blank" href="{{route('fees_collect_student_wise', [@$fees_payment->recordDetail->id])}}">@lang('common.view')</a>
                                                            @if(! moduleStatusCheck('University') && directFees() == false)
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#deleteFeesPayment_{{$fees_payment->id}}" >@lang('common.delete')</a>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade admin-query" id="deleteFeesPayment_{{$fees_payment->id}}" >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('common.delete_collect_fees')</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                        </div>
                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                            {{ Form::open(['route' => 'fees-payment-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                                                <input type="hidden" name="id" id="feep_payment_id" value="{{$fees_payment->id}}">
                                                                <input type="hidden" name="assign_id" id="assign_id" value="{{$fees_payment->assign_id}}">
                                                                <input type="hidden" name="amount" id="feep_payment_amount" value="{{$fees_payment->amount}}">
                                                                <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                                                            {{ Form::close() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection