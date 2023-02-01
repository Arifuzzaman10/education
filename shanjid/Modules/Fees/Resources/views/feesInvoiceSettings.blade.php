@extends('backEnd.master')
    @section('title') 
        @lang('fees::feesModule.fees_invoice_settings')
    @endsection
@section('mainContent')
    @push('css')
        <link rel="stylesheet" href="{{url('Modules\Fees\Resources\assets\css\feesStyle.css')}}"/>
    @endpush
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('fees::feesModule.fees_invoice_settings')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('fees.fees')</a>
                    <a href="#">@lang('fees::feesModule.fees_invoice_settings')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    @lang('fees::feesModule.invoice_number_generator')
                                </h3>
                            </div>
                            @php
                                $invoicePostions = json_decode($invoiceSettings->invoice_positions);
                            @endphp
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                            @if (isset($invoiceSettings))
                                <input type="hidden" name="id" id="ID" value="{{$invoiceSettings->id}}">
                            @endif
                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row no-gutters input-right-icon mt-20">
                                        <div class="col-lg-12">
                                            <label for="checkbox" class="mb-2">@lang('fees::feesModule.invoice_number_position')*</label>
                                            <select ata-tags="true" multiple id="e1" name="invoice_positions[]" style="width:300px" class="selectValue">
                                                <option value="prefix">@lang('fees::feesModule.prefix') </option>
                                                <option value="admission_no">@lang('student.admission_no')</option>
                                                <option value="class">@lang('common.class')</option>
                                                <option value="section">@lang('common.section')</option>
                                            </select>
                                            @if ($errors->has('invoice_positions'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('invoice_positions') }}</strong>
                                            </span>
                                            @endif
                                            <div class="">
                                                <input type="checkbox" id="checkbox" class="common-checkbox">
                                                <label for="checkbox" class="mt-3">@lang('common.select_all') </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('fees::feesModule.invoice_number_preview')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-30">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <div class="row fees_custom_preview" id="showValue">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-title">
                        <h3 class="mb-30 mt-30">
                            @lang('fees::feesModule.invoice_attribute')
                        </h3>
                    </div>
                    <table class="display school-table school-table-style" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('uniq_id_start') ? ' is-invalid' : '' }}" type="text" name="uniq_id_start" id="uniq_id_start" autocomplete="off" value="{{isset($invoiceSettings)? $invoiceSettings->uniq_id_start: old('uniq_id_start')}}">
                                            <label>@lang('fees::feesModule.uniq_id_start')*</label>
                                            <span class="focus-border"></span>
                                                @if ($errors->has('uniq_id_start'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('uniq_id_start') }}</strong>
                                                </span>
                                                @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('prefix') ? ' is-invalid' : '' }}" type="text" name="prefix" id="prefix" autocomplete="off" value="{{isset($invoiceSettings)? $invoiceSettings->prefix: old('prefix')}}" maxlength="10">
                                            <label>@lang('fees::feesModule.prefix') (@lang('fees::feesModule.max_10_characters'))</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('class_limit') ? ' is-invalid' : '' }}" type="text"  name="class_limit" id="class_limit" autocomplete="off" value="{{isset($invoiceSettings)? $invoiceSettings->class_limit: old('class_limit')}}">
                                            <label>@lang('fees::feesModule.class_limit')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('section_limit') ? ' is-invalid' : '' }}" type="text" name="section_limit" id="section_limit" autocomplete="off" value="{{isset($invoiceSettings)? $invoiceSettings->section_limit: old('section_limit')}}">
                                            <label>@lang('fees::feesModule.section_limit')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('admission_limit') ? ' is-invalid' : '' }}" type="text" name="admission_limit" id="admission_limit" autocomplete="off" value="{{isset($invoiceSettings)? $invoiceSettings->admission_limit: old('admission_limit')}}">
                                            <label>@lang('fees::feesModule.admission_no_limit')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                </td>
                                {{-- <td>
                                    <div class="col-lg-12">
                                        <select class="w-100 niceSelect bb form-control {{ $errors->has('weaver') ? ' is-invalid' : '' }}" id="weaver" name="weaver">
                                            <option data-display="@lang('common.select_weaver') *" value="">@lang('common.select_weaver')*</option>
                                            <option value="percent" {{isset($invoiceSettings)? ($invoiceSettings->weaver == 'percent')? 'selected': "" : ''}}>@lang('fees::feesModule.percent')</option>
                                            <option value="amount" {{isset($invoiceSettings)? ($invoiceSettings->weaver == 'amount')? 'selected': "" : ''}}>@lang('fees.amount')</option>
                                        </select>
                                    </div>
                                </td> --}}
                            </tr>
                        </tbody>
                    </table>
                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            @if(userPermission(1153))
                                <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" id="invSetting">
                                    <span class="ti-check"></span>
                                    @lang('common.update')
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script type="text/javascript" src="{{url('Modules\Fees\Resources\assets\js\app.js')}}"></script>
    <script>
        $('.selectValue').select2('data',{!! $invoiceSettings->invoice_positions !!});
    </script>
@endpush