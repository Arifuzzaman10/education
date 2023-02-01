@extends('backEnd.master')
@section('title') 
@lang('accounts.payroll_report')
@endsection
@section('mainContent')
@push('css')
<style>
    /* table.dataTable thead th {
        padding: 10px 30px !important;
    } */

    table.dataTable tbody th, table.dataTable tbody td {
        padding: 20px 30px 20px 30px !important;
    }

    table.dataTable tfoot th, table.dataTable tfoot td {
        padding: 10px 30px 6px 30px;
    }
</style>
@endpush
@php  @$setting = generalSetting(); if(!empty(@$setting->currency_symbol)){ @$currency = @$setting->currency_symbol; }else{ @$currency = '$'; } @endphp
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('accounts.payroll_report')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('accounts.accounts')</a>
                <a href="#">@lang('accounts.reports')</a>
                <a href="#">@lang('accounts.payroll_report')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('common.select_criteria') </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">                  
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'accounts-payroll-report-search', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                <div class="col-lg-6 offset-lg-3 mt-30-md">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input placeholder="" class="primary_input_field primary-input form-control text-center" type="text" name="date_range" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-20 text-center">
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
        @if(isset($payroll_infos))
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('accounts.payroll_report')</h3>
                            </div>
                        </div>
                    </div>                
                    <!-- </div> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('common.name')</th>
                                        <th>@lang('accounts.expense_head')</th>
                                        <th>@lang('accounts.payment_method')</th>
                                        <th>@lang('accounts.amount')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $total=0;
                                    @endphp
                                    @foreach($payroll_infos as $payroll_info)
                                    @php 
                                        $total= $total+ $payroll_info->amount
                                    @endphp
                                    <tr>
                                        <td>{{@$payroll_info->description}}</td>
                                        <td>{{@$payroll_info->ACHead->head}}</td>
                                        <td>
                                        {{@$payroll_info->paymentMethod->method}}
                                        @if(@$payroll_info->payment_method_id==3)
                                        ({{@$payroll_info->account->bank_name}})
                                        @endif
                                        </td>
                                        <td>{{@generalSetting()->currency_symbol}}{{@$payroll_info->amount}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>@lang('accounts.total')</td>
                                        <td>{{@generalSetting()->currency_symbol}}{{$total}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
@push('script')
<script>
        $('input[name="date_range"]').daterangepicker({
            ranges: {
                {!! json_encode(__('calender.Today')) !!}: [moment(), moment()],
                {!! json_encode(__('calender.Yesterday')) !!}: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                {!! json_encode(__('calender.Last 7 Days')) !!}: [moment().subtract(6, 'days'), moment()],
                {!! json_encode(__('calender.Last 30 Days')) !!}: [moment().subtract(29, 'days'), moment()],
                {!! json_encode(__('calender.This Month')) !!}: [moment().startOf('month'), moment().endOf('month')],
                {!! json_encode(__('calender.Last Month')) !!}: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "locale": {
                "separator": {!! json_encode(__('calender.separator')) !!},
                "applyLabel": {!! json_encode(__('calender.applyLabel')) !!},
                "cancelLabel": {!! json_encode(__('calender.cancelLabel')) !!},
                "fromLabel": {!! json_encode(__('calender.fromLabel')) !!},
                "toLabel": {!! json_encode(__('calender.toLabel')) !!},
                "customRangeLabel": {!! json_encode(__('calender.customRangeLabel')) !!},
                "weekLabel": {!! json_encode(__('calender.weekLabel')) !!},
                "daysOfWeek": {!! json_encode(__('calender.daysMin')) !!},
                "monthNames": {!! json_encode(__('calender.months')) !!}
            },
            "startDate": moment().subtract(7, 'days'),
            "endDate": moment()
            }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    </script>
@endpush
