@extends('backEnd.master')
    @section('title') 
        @lang('fees::feesModule.fine_report')
    @endsection
@section('mainContent')

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('fees::feesModule.fine_report')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('fees::feesModule.fees')</a>
                <a href="#">@lang('fees::feesModule.report')</a>
                <a href="#">@lang('fees::feesModule.fine_report')</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area">
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
                    {{ Form::open(['class' => 'form-horizontal', 'route' => 'fees.fine-search', 'method' => 'POST']) }}
                        @include('fees::report._searchForm')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        @isset($fees_dues)
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 search_hide_md">
                            <table id="table_id" class="display school-table fees-report-footer" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('common.sl')</th>
                                        <th>@lang('student.admission_no')</th>
                                        <th>@lang('student.roll_no')</th>
                                        <th>@lang('common.name')</th>
                                        <th>@lang('fees::feesModule.due_date')</th>
                                        <th>@lang('fees::feesModule.fine') ({{generalSetting()->currency_symbol}})</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalFine = 0;
                                    @endphp
                                    @foreach($fees_dues as $key=>$fees_due)
                                        @php
                                            $fine = $fees_due->Tfine;
                                            $totalFine += $fine;
                                        @endphp
                                            @if($fine != 0)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{@$fees_due->studentInfo->admission_no}}</td>
                                                    <td>{{@$fees_due->recordDetail->roll_no}}</td>
                                                    <td>{{@$fees_due->studentInfo->full_name}}</td>
                                                    <td>{{dateConvert($fees_due->due_date)}}</td>
                                                    <td>{{$fine}}</td>
                                                </tr>
                                            @endif
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">@lang('dashboard.total')</td>
                                        <td>{{$totalFine}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>
        @endisset
    </div>
</section>
@endsection
@push('script')
    <script type="text/javascript" src="{{url('Modules\Fees\Resources\assets\js\app.js')}}"></script>
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
