@extends('backEnd.master')
@section('title') 
@lang('accounts.transaction')
@endsection
@section('mainContent')
@push('css')
<style>
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
            <h1>@lang('accounts.transaction')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('accounts.accounts')</a>
                <a href="#">@lang('reports.reports')</a>
                <a href="#">@lang('accounts.transaction')</a>
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
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'transaction-search', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                <div class="col-lg-6 mt-30-md">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input placeholder="" class="primary_input_field primary-input form-control" type="text" name="date_range" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" id="account-type">
                                        <option data-display="@lang('common.search_type')" value="all">@lang('common.search_type')</option>
                                        <option value="In">@lang('accounts.income')</option>
                                        <option value="Ex">@lang('accounts.expense')</option>
                                    </select>
                                    @if ($errors->has('type'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ @$errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <select class="niceSelect w-100 bb form-control" name="payment_method" id="payment_method">
                                            <option data-display="@lang('common.all')" value="all">@lang('common.all')</option>
                                            @foreach($payment_methods as $key=>$value)
                                            <option value="{{$value->id}}"
                                                {{isset($search_info)? ($search_info['method_id'] == $value->id? 'selected':''):''}}
                                                >{{$value->method}}</option>
                                            @endforeach
                                        </select>
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
        @if(isset($add_incomes))
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('accounts.income_result')</h3>
                            </div>
                        </div>
                    </div>                
                    <!-- </div> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('common.date')</th>
                                        <th>@lang('common.name')</th>
                                        <th>@lang('accounts.payroll')</th>
                                        <th>@lang('accounts.payment_method')</th>
                                        <th>@lang('accounts.amount')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_income=0;
                                    @endphp
                                    @foreach($add_incomes as $add_income)
                                    @php 
                                        @$total_income = @$total_income + @$add_income->amount; 
                                    @endphp
                                    <tr>
                                        <td>{{dateConvert(@$add_income->date)}}</td>
                                        <td>{{@$add_income->name}}</td>
                                        <td>{{@$add_income->ACHead->head}}</td>
                                        <td>
                                        {{@$add_income->paymentMethod->method}}
                                        @if(@$add_income->payment_method_id==3)
                                            ({{@$add_income->account->bank_name}})
                                        @endif
                                        </td>
                                        <td>{{@$add_income->amount}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-right">@lang('accounts.grand_total'):</th>
                                        <th>{{@generalSetting()->currency_symbol}}{{$total_income}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($add_expenses))
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('accounts.expense_result')</h3>
                            </div>
                        </div>
                    </div>               
                    <!-- </div> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('common.date')</th>
                                        <th>@lang('common.name')</th>
                                        <th>@lang('accounts.expense_head')</th>
                                        <th>@lang('accounts.payment_method')</th>
                                        <th>@lang('accounts.amount')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $total_expense=0;
                                @endphp
                                    @foreach($add_expenses as $add_expense)
                                    @php 
                                        @$total_expense = @$total_expense + @$add_expense->amount; 
                                    @endphp
                                    <tr>
                                        <td>{{dateConvert(@$add_expense->date)}}</td>
                                        <td>{{@$add_expense->name}}</td>
                                        <td>{{@$add_expense->ACHead->head}}</td>
                                        <td>
                                        {{@$add_expense->paymentMethod->method}}
                                        @if(@$add_expense->payment_method_id==3)
                                            ({{@$add_expense->account->bank_name}})
                                        @endif
                                        </td>
                                        <td>{{@generalSetting()->currency_symbol}}{{@$add_expense->amount}}</td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-right">@lang('accounts.grand_total'):</th>
                                        <th>{{@generalSetting()->currency_symbol}}{{$total_expense}}</th>
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
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        "startDate": moment().subtract(7, 'days'),
        "endDate": moment()
        }, function(start, end, label) {
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });
</script>
@endpush