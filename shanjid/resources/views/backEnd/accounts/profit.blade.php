@extends('backEnd.master')
@section('title') 
@lang('accounts.profit_loss')
@endsection
@section('mainContent')
@php  $setting = generalSetting(); if(!empty(@$setting->currency_symbol)){ @$currency = @$setting->currency_symbol; }else{ @$currency = '$'; } @endphp
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('accounts.profit_&_loss')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('accounts.accounts')</a>
                <a href="#">@lang('accounts.profit_&_loss')</a>
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
                       {!! Form::open(['route' => 'search_profit_by_date', 'method' => 'POST' ]) !!}
                       
                            <div class="row">
                                
                                <div class="col-md-6 offset-md-3 mt-30-md">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input placeholder="" class="primary_input_field primary-input form-control text-center" type="text" name="date_range" value="">
                                            </div>
                                            @if ($errors->has('date_range'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('date_range') }}</strong>
                                                </span>
                                            @endif
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
                       {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('accounts.profit_&_loss')</h3>
                            </div>
                        </div>
                    </div>                
                    <!-- </div> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('common.time')</th>
                                        <th>@lang('accounts.income')</th>
                                        <th>@lang('accounts.expense')</th>
                                        <th>@lang('accounts.profit_/_loss')</th>
                                    </tr>
                                </thead>
                                <tbody>                                   
                                    <tr>
                                        <td >
                                            {{isset($date_time_from)? dateConvert($date_time_from).' - '.dateConvert($date_time_to): "All"}}  
                                        </td>
                                        <td>
                                            {{generalSetting()->currency_symbol}}{{number_format(@$total_income, 2)}}
                                        </td>
                                        <td>
                                            {{generalSetting()->currency_symbol}}{{number_format(@$total_expense, 2)}}
                                        </td>
                                        <td>
                                            @php
                                                $total=@$total_income-@$total_expense;
                                            @endphp
                                            {{generalSetting()->currency_symbol}}
                                            {{@$total}}
                                        </td>
                                    </tr>
                                    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
