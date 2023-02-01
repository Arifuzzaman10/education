@extends('backEnd.master')
    @section('title') 
        @lang('wallet::wallet.wallet_transaction')
    @endsection
@section('mainContent')
@push('css')
    <style>
        table.dataTable tfoot th, table.dataTable tfoot td.walletTranscation{
            padding: 20px 10px 20px 30px !important;
        }
    </style>
@endpush
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('wallet::wallet.wallet_transaction')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('wallet::wallet.wallet')</a>
                <a href="#">@lang('wallet::wallet.wallet_transaction')</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_st_admin_visitor mt-20">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>@lang('common.sl')</th>
                            <th>@lang('common.name')</th>
                            <th>@lang('wallet::wallet.method')</th>
                            <th>@lang('common.pending')</th>
                            <th>@lang('wallet::wallet.approve')</th>
                            <th>@lang('wallet::wallet.reject')</th>
                            <th>@lang('wallet::wallet.refund')</th>
                            <th>@lang('accounts.expense')</th>
                            <th>@lang('fees::feesModule.fees_refund')</th>
                            <th>@lang('common.status')</th>
                            <th>@lang('common.date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pendingAmount = 0;
                            $approveAmount = 0;
                            $rejectAmount = 0;
                            $refundAmount = 0;
                            $expenseAmount = 0;
                            $feesRefund = 0;
                        @endphp
                        @foreach ($walletAmounts as $key=>$walletAmount)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{@$walletAmount->userName->full_name}}</td>
                                <td>{{$walletAmount->payment_method}}</td>
                                <td>
                                    @if ($walletAmount->status == 'pending')
                                        {{generalSetting()->currency_symbol}}{{number_format($walletAmount->amount, 2, '.', '')}}
                                        @php
                                            $pendingAmount+=$walletAmount->amount;
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    @if ($walletAmount->status == 'approve')
                                        {{generalSetting()->currency_symbol}}{{number_format($walletAmount->amount, 2, '.', '')}}
                                        @php
                                            $approveAmount+=$walletAmount->amount;
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    @if ($walletAmount->status == 'reject')
                                        {{generalSetting()->currency_symbol}}{{number_format($walletAmount->amount, 2, '.', '')}}
                                        @php
                                            $rejectAmount+=$walletAmount->amount;
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    @if ($walletAmount->type == 'refund' && $walletAmount->status == 'approve')
                                        {{generalSetting()->currency_symbol}}{{number_format($walletAmount->amount, 2, '.', '')}}
                                        @php
                                            $refundAmount+=$walletAmount->amount;
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    @if ($walletAmount->type == 'expense')
                                        {{generalSetting()->currency_symbol}}{{number_format($walletAmount->amount, 2, '.', '')}}
                                        @php
                                            $expenseAmount+=$walletAmount->amount;
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    @if ($walletAmount->type == 'fees_refund')
                                        {{generalSetting()->currency_symbol}}{{number_format($walletAmount->amount, 2, '.', '')}}
                                        @php
                                            $feesRefund+=$walletAmount->amount;
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    @if ($walletAmount->status == 'pending')
                                        <button class="primary-btn small bg-warning text-white border-0">@lang('common.pending')</button> 
                                    @elseif ($walletAmount->status == 'approve')
                                        <button class="primary-btn small bg-success text-white border-0">@lang('wallet::wallet.approve')</button>
                                    @elseif ($walletAmount->status == 'reject')
                                        <button class="primary-btn small bg-danger text-white border-0">@lang('wallet::wallet.reject')</button>
                                    @elseif($walletAmount->status == 'refund')
                                        <button class="primary-btn small bg-primary text-white border-0">@lang('wallet::wallet.refund')</button>
                                    @else
                                        <button class="primary-btn small bg-primary text-white border-0">@lang('accounts.expense')</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($walletAmount->status == 'approve' || $walletAmount->status == 'reject')
                                        {{dateConvert($walletAmount->updated_at)}}
                                    @else
                                        {{dateConvert($walletAmount->created_at)}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tfoot>
                            <tr>
                                <td class="walletTranscation"></td>
                                <td class="walletTranscation"></td>
                                <td class="walletTranscation">@lang('exam.result')</td>
                                <td class="walletTranscation">{{generalSetting()->currency_symbol}}{{number_format($pendingAmount, 2, '.', '')}}</td>
                                <td class="walletTranscation">{{generalSetting()->currency_symbol}}{{number_format($approveAmount, 2, '.', '')}}</td>
                                <td class="walletTranscation">{{generalSetting()->currency_symbol}}{{number_format($rejectAmount, 2, '.', '')}}</td>
                                <td class="walletTranscation">{{generalSetting()->currency_symbol}}{{number_format($refundAmount, 2, '.', '')}}</td>
                                <td class="walletTranscation">{{generalSetting()->currency_symbol}}{{number_format($expenseAmount, 2, '.', '')}}</td>
                                <td class="walletTranscation">{{generalSetting()->currency_symbol}}{{number_format($feesRefund, 2, '.', '')}}</td>
                                <td class="walletTranscation"></td>
                                <td class="walletTranscation"></td>
                            </tr>
                        </tfoot>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection