
<style>
    table.dataTable tfoot th, table.dataTable tfoot td.walletAmount{
        padding: 20px 10px 20px 30px !important;
    }
</style>

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>
                @if (isset($status) && $status =='pending')
                    @lang('common.pending') 
                @elseif (isset($status) && $status =='approve')
                    @lang('wallet::wallet.approve_deposit')
                @else
                    @lang('wallet::wallet.reject_deposit')
                @endif
               
            </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('wallet::wallet.wallet')</a>
                <a href="#">
                    @if (isset($status) && $status =='pending')
                        @lang('common.pending') 
                    @elseif (isset($status) && $status =='approve')
                        @lang('wallet::wallet.approve_deposit')
                    @else
                        @lang('wallet::wallet.reject_deposit') 
                    @endif
                   
                </a>
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
                            <th>@lang('wallet::wallet.amount')</th>
                            <th>@lang('common.status')</th>
                            <th>@lang('wallet::wallet.note')</th>
                            @if (isset($status) && $status =='reject')
                                <th>@lang('wallet::wallet.reject_note')</th>
                            @endif
                            <th>@lang('common.file')</th>
                            <th>@lang('common.date')</th>
                            @if (isset($status) && $status =='approve')
                                <th>@lang('wallet::wallet.approve_date')</th>
                            @endif
                            @if (isset($status) && $status =='reject')
                                <th>@lang('wallet::wallet.reject_date')</th>
                            @endif
                            @if (isset($status) && $status =='pending')
                                <th>@lang('common.action')</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalAmount = 0;
                        @endphp
                        @foreach ($walletAmounts as $key=>$walletAmount)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{@$walletAmount->userName->full_name}}</td>
                                <td>{{$walletAmount->payment_method}}</td>
                                <td>
                                    {{generalSetting()->currency_symbol}}{{number_format($walletAmount->amount, 2, '.', '')}}
                                    @php
                                        $totalAmount+= $walletAmount->amount;
                                    @endphp
                                </td>
                                <td>
                                    @if ($walletAmount->status == 'pending')
                                        <button class="primary-btn small bg-warning text-white border-0">@lang('common.pending')</button> 
                                    @elseif ($walletAmount->status == 'approve')
                                        <button class="primary-btn small bg-success text-white border-0">@lang('wallet::wallet.approve')</button>
                                    @else
                                        <button class="primary-btn small bg-danger text-white border-0">@lang('wallet::wallet.reject')</button>
                                    @endif
                                </td>
                                <td>
                                    @if ($walletAmount->note)
                                        <a class="text-color" data-toggle="modal" data-target="#note{{$walletAmount->id}}"  href="#">@lang('common.view')</a>
                                    @endif
                                </td>
                                
                                @if (isset($status) && $status =='reject')
                                    <td>
                                        @if ($walletAmount->reject_note)
                                            <a class="text-color" data-toggle="modal" data-target="#rejectNote{{$walletAmount->id}}"  href="#">@lang('common.view')</a>
                                        @endif
                                    </td>
                                @endif
                                <th>
                                    @if (file_exists($walletAmount->file))
                                        <a class="text-color" data-toggle="modal" data-target="#showFile{{$walletAmount->id}}"  href="#">@lang('common.view')</a>
                                    @endif
                                </th>
                                <td>{{dateConvert($walletAmount->created_at)}}</td>
                                @if (isset($status) && $status !='pending')
                                    <td>
                                        @if ($walletAmount->status == 'approve' || $walletAmount->status == 'reject')
                                            {{dateConvert($walletAmount->updated_at)}}
                                        @endif
                                    </td>
                                @endif
                                @if (isset($status) && $status =='pending')
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(1111))
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#approvePayment{{$walletAmount->id}}" href="">@lang('wallet::wallet.approve')</a>
                                                @endif
                                                @if(userPermission(1112))
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#rejectwalletPayment{{$walletAmount->id}}" href="#">@lang('wallet::wallet.reject')</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>

                            {{-- Note Start  --}}
                            <div class="modal fade admin-query" id="note{{$walletAmount->id}}">
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
                                                        <p>{{$walletAmount->note}}</p>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Note End  --}}

                            {{-- Reject Note Start  --}}
                            <div class="modal fade admin-query" id="rejectNote{{$walletAmount->id}}">
                                <div class="modal-dialog modal-dialog-centered large-modal">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('common.view_reject_note')</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body p-0 mt-30">
                                            <div class="container student-certificate">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-12 text-center">
                                                        <p>{{$walletAmount->reject_note}}</p>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Reject Note End  --}}

                            {{-- File View and Download Modal Start  --}}
                            <div class="modal fade admin-query" id="showFile{{$walletAmount->id}}">
                                <div class="modal-dialog modal-dialog-centered large-modal">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('common.view_file')</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body p-0 mt-30">
                                            <div class="container student-certificate">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-12 text-center">
                                                        @php
                                                            $pdf = $walletAmount->file ? explode('.', @$walletAmount->file) : ""." . "."";
                                                            $for_pdf =  $pdf[1];
                                                        @endphp
                                                        @if (@$for_pdf=="pdf")
                                                            <div class="mb-5">
                                                                @if (isset($status) && $status =='approve')
                                                                    @if(userPermission(1114))
                                                                        <a href="{{url(@$walletAmount->file)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                                    @endif
                                                                @endif
                                                                @if (isset($status) && $status =='reject')
                                                                    @if(userPermission(1116))
                                                                        <a href="{{url(@$walletAmount->file)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                                    @endif
                                                                @endif
                                                                @if (isset($status) && $status =='pending')
                                                                    @if(userPermission(1112))
                                                                        <a href="{{url(@$walletAmount->file)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        @else
                                                            @if (file_exists($walletAmount->file))
                                                                <div class="mb-5">
                                                                    <img class="img-fluid" src="{{asset($walletAmount->file)}}">
                                                                </div>
                                                                <br>
                                                                <div class="mb-5">
                                                                    @if (isset($status) && $status =='approve')
                                                                    @if(userPermission(1114))
                                                                            <a href="{{url(@$walletAmount->file)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                                        @endif
                                                                    @endif
                                                                    @if (isset($status) && $status =='reject')
                                                                        @if(userPermission(1116))
                                                                            <a href="{{url(@$walletAmount->file)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                                        @endif
                                                                    @endif
                                                                    @if (isset($status) && $status =='pending')
                                                                        @if(userPermission(1113))
                                                                            <a href="{{url(@$walletAmount->file)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                                        @endif
                                                                    @endif
                                                                </div>
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

                            @if (isset($status) && $status =='pending')
                                {{-- Approve Modal Start --}}
                                <div class="modal fade admin-query" id="approvePayment{{$walletAmount->id}}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('wallet::wallet.approve') {{$walletAmount->payment_method}} @lang('wallet::wallet.payment')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('wallet::wallet.are_you_sure_to_approve')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                    {{ Form::open(['method' => 'POST','route' =>'wallet.approve-payment']) }}
                                                        <input type="hidden" name="id" value="{{$walletAmount->id}}">
                                                        <input type="hidden" name="user_id" value="{{$walletAmount->user_id}}">
                                                        <input type="hidden" name="amount" value="{{$walletAmount->amount}}">
                                                        <button class="primary-btn fix-gr-bg" type="submit">@lang('wallet::wallet.approve')</button>
                                                    {{ Form::close() }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                {{-- Approve Modal End --}}

                                <div class="modal fade admin-query" id="rejectwalletPayment{{$walletAmount->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('wallet::wallet.reject') {{$walletAmount->payment_method}} @lang('wallet::wallet.payment')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center">
                                                        <h4>@lang('wallet::wallet.are_you_sure_to_reject')</h4>
                                                    </div>
                                                {{ Form::open(['route' => 'wallet.reject-payment', 'method' => 'POST']) }}
                                                        <input type="hidden" name="id" value="{{$walletAmount->id}}">
                                                        <input type="hidden" name="user_id" value="{{$walletAmount->user_id}}">
                                                        <input type="hidden" name="amount" value="{{$walletAmount->amount}}">
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
                                                <h4 class="modal-title">@lang('common.view') @lang('fees.bank_payment_reject_note')</h4>
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
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="walletAmount"></td>
                            <td class="walletAmount"></td>
                            <td class="walletAmount">@lang('exam.result')</td>
                            <td class="walletAmount">{{generalSetting()->currency_symbol}}{{number_format($totalAmount,2,'.','')}}</td>
                            <td class="walletAmount"></td>
                            <td class="walletAmount"></td>
                            <td class="walletAmount"></td>
                            <td class="walletAmount"></td>
                            <td class="walletAmount"></td>
                            @if (isset($status) && $status =='reject')
                                <td class="walletAmount"></td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>