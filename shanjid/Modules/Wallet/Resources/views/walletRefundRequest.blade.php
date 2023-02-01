@extends('backEnd.master')
    @section('title') 
        @lang('wallet::wallet.refund_request')
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
            <h1>@lang('wallet::wallet.refund_request')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('wallet::wallet.wallet')</a>
                <a href="#">@lang('wallet::wallet.refund_request')</a>
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
                            <th>@lang('common.pending')</th>
                            <th>@lang('wallet::wallet.approve')</th>
                            <th>@lang('wallet::wallet.reject')</th>
                            <th>@lang('common.note')</th>
                            <th>@lang('common.status')</th>
                            <th>@lang('common.file')</th>
                            <th>@lang('wallet::wallet.create_date')</th>
                            <th>@lang('common.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $pendingAmount = 0;
                            $approveAmount = 0;
                            $rejectAmount = 0;
                        @endphp
                        @foreach ($walletRefunds as $key=>$walletRefund)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{@$walletRefund->userName->full_name}}</td>
                                <td>
                                    @if ($walletRefund->type == 'refund' && $walletRefund->status == 'pending')
                                        {{generalSetting()->currency_symbol}}{{number_format($walletRefund->amount, 2, '.', '')}}
                                        @php
                                            $pendingAmount+=$walletRefund->amount
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    @if ($walletRefund->type == 'refund' && $walletRefund->status == 'approve')
                                        {{generalSetting()->currency_symbol}}{{number_format($walletRefund->amount, 2, '.', '')}}
                                        @php
                                            $approveAmount+=$walletRefund->amount
                                        @endphp
                                    @endif
                                </td>
                                <td>
                                    @if ($walletRefund->type == 'refund' && $walletRefund->status == 'reject')
                                        {{generalSetting()->currency_symbol}}{{number_format($walletRefund->amount, 2, '.', '')}}
                                        @php
                                            $rejectAmount+=$walletRefund->amount
                                        @endphp
                                    @endif
                                </td>

                                <td>
                                    @if ($walletRefund->note)
                                        <a class="text-color" data-toggle="modal" data-target="#refundNote{{$walletRefund->id}}"  href="#">@lang('common.view')</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($walletRefund->status == 'pending')
                                        <button class="primary-btn small bg-warning text-white border-0">@lang('common.pending')</button> 
                                    @elseif ($walletRefund->status == 'approve')
                                        <button class="primary-btn small bg-success text-white border-0">@lang('wallet::wallet.approve')</button>
                                    @else
                                        <button class="primary-btn small bg-danger text-white border-0">@lang('wallet::wallet.reject')</button>
                                    @endif
                                </td>
                                <td>
                                    @if (file_exists($walletRefund->file))
                                        <a class="text-color" data-toggle="modal" data-target="#showFile{{$walletRefund->id}}"  href="#">@lang('common.view')</a>
                                    @endif
                                </td>
                                <td>{{dateConvert($walletRefund->created_at)}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            @lang('common.select')
                                        </button>
                                        @if ($walletRefund->status == 'pending')
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(1120))
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#approveRefund{{$walletRefund->id}}" href="">@lang('wallet::wallet.approve')</a>
                                                @endif
                                                @if(userPermission(1121))
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#rejectRefund{{$walletRefund->id}}" href="#">@lang('wallet::wallet.reject')</a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- Reject Note Start  --}}
                            <div class="modal fade admin-query" id="refundNote{{$walletRefund->id}}">
                                <div class="modal-dialog modal-dialog-centered large-modal">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('common.view_note')</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body p-0 mt-30">
                                            <div class="container student-certificate">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-12 text-center">
                                                        <p>{{$walletRefund->note}}</p>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Reject Note End  --}}


                            {{-- File View and Download Modal Start  --}}
                            <div class="modal fade admin-query" id="showFile{{$walletRefund->id}}">
                                <div class="modal-dialog modal-dialog-centered large-modal">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('wallet::wallet.refund_file')</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body p-0 mt-30">
                                            <div class="container student-certificate">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-12 text-center">
                                                        @php
                                                            $pdf = $walletRefund->file ? explode('.', @$walletRefund->file) : ""." . "."";
                                                            $for_pdf =  $pdf[1];
                                                        @endphp
                                                        @if (@$for_pdf=="pdf")
                                                            @if(userPermission(1122))
                                                                <div class="mb-5">
                                                                    <a href="{{url(@$walletRefund->file)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                                </div>
                                                            @endif
                                                        @else
                                                            @if (file_exists($walletRefund->file))
                                                                <div class="mb-5">
                                                                    <img class="img-fluid" src="{{asset($walletRefund->file)}}">
                                                                </div>
                                                                <br>
                                                                @if(userPermission(1122))
                                                                    <div class="mb-5">
                                                                        <a href="{{url(@$walletRefund->file)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- File View and Download Modal End  --}}

                            {{-- Approve Modal Start --}}
                            <div class="modal fade admin-query" id="approveRefund{{$walletRefund->id}}">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('wallet::wallet.approve_refund')</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="text-center">
                                                <h4>@lang('wallet::wallet.are_you_sure_to_approve')</h4>
                                            </div>

                                            <div class="mt-40 d-flex justify-content-between">
                                                <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                {{ Form::open(['method' => 'POST','route' =>'wallet.approve-refund']) }}
                                                    <input type="hidden" name="id" value="{{$walletRefund->id}}">
                                                    <input type="hidden" name="user_id" value="{{$walletRefund->user_id}}">
                                                    <input type="hidden" name="amount" value="{{$walletRefund->amount}}">
                                                    <button class="primary-btn fix-gr-bg" type="submit">@lang('wallet::wallet.approve')</button>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Approve Modal End --}}

                            <div class="modal fade admin-query" id="rejectRefund{{$walletRefund->id}}" >
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('wallet::wallet.reject_refund')</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center">
                                                    <h4>@lang('wallet::wallet.are_you_sure_to_reject')</h4>
                                                </div>
                                            {{ Form::open(['route' => 'wallet.reject-refund', 'method' => 'POST']) }}
                                                    <input type="hidden" name="id" value="{{$walletRefund->id}}">
                                                    <input type="hidden" name="user_id" value="{{$walletRefund->user_id}}">
                                                    <input type="hidden" name="amount" value="{{$walletRefund->amount}}">
                                                <div class="form-group">
                                                    <label><strong>@lang('wallet::wallet.reject_note')</strong></label>
                                                    <textarea name="reject_note" class="form-control" rows="6"></textarea>
                                                </div>
                                
                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.close')</button>
                                                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.submit')</button>
                                                </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade admin-query" id="showReasonModal" >
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('wallet::wallet.view_bank_payment_reject_note')</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label><strong>@lang('wallet::wallet.reject_note')</strong></label>
                                                <textarea readonly class="form-control" rows="4"></textarea>
                                            </div>
                                            <div class="mt-40 d-flex justify-content-between">
                                                <button type="button" class="primary-btn fix-gr-bg" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="walletTranscation"></td>
                            <td class="walletTranscation">@lang('exam.result')</td>
                            <td class="walletTranscation">{{generalSetting()->currency_symbol}}{{number_format($pendingAmount, 2, '.', '')}}</td>
                            <td class="walletTranscation">{{generalSetting()->currency_symbol}}{{number_format($approveAmount, 2, '.', '')}}</td>
                            <td class="walletTranscation">{{generalSetting()->currency_symbol}}{{number_format($rejectAmount, 2, '.', '')}}</td>
                            <td class="walletTranscation"></td>
                            <td class="walletTranscation"></td>
                            <td class="walletTranscation"></td>
                            <td class="walletTranscation"></td>
                            <td class="walletTranscation"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection