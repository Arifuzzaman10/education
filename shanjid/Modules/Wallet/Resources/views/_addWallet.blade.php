    <div class="col-12">
        <div class="d-flex mb-25 align-items-center justify-content-between">
            @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                <button class="primary-btn small fix-gr-bg">
                        @lang('wallet::wallet.balance'): {{generalSetting()->currency_symbol}}{{(Auth::user()->wallet_balance != null) ? number_format(Auth::user()->wallet_balance, 2, '.', ''): 0.00}}
                </button>

                @if(userPermission(1125) || userPermission(1128))
                    <button class="primary-btn small fix-gr-bg mr-2 ml-auto" data-toggle="modal" data-target="#addWalletPayment">
                        <span class="ti-plus pr-2"></span>
                        @lang('wallet::wallet.add_balance')
                    </button>
                @endif
                @if(userPermission(1126) || userPermission(1129))
                    <button class="primary-btn small fix-gr-bg" data-toggle="modal" data-target="#refundRequest">
                        @lang('wallet::wallet.refund_request')
                    </button>
                @endif
            @endif
        </div>
    </div>
</div>
<div class="row mt-30">
    <div class="col-lg-12">
        <table id="table_id" class="display school-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>@lang('common.sl')</th>
                    <th>@lang('wallet::wallet.method') </th>
                    <th>@lang('wallet::wallet.amount')</th>
                    <th>@lang('common.status')</th>
                    <th>@lang('wallet::wallet.issue_date')</th>
                    <th>@lang('wallet::wallet.note')</th>
                    <th>@lang('common.file')</th>
                    <th>@lang('wallet::wallet.approve_date')</th>
                    <th>@lang('wallet::wallet.feedback')</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($walletAmounts as $key=>$walletAmount)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$walletAmount->payment_method}}</td>
                    <td>{{generalSetting()->currency_symbol}}{{number_format($walletAmount->amount, 2, '.', '')}}</td>
                    <td>
                        @if ($walletAmount->status == 'pending')
                            <button class="primary-btn small bg-warning text-white border-0">@lang('common.pending')</button> 
                        @elseif ($walletAmount->type == 'diposit' && $walletAmount->status == 'approve')
                            <button class="primary-btn small bg-success text-white border-0">@lang('wallet::wallet.approve')</button>
                        @elseif ($walletAmount->status == 'reject')
                            <button class="primary-btn small bg-danger text-white border-0">@lang('wallet::wallet.reject')</button>
                        @elseif ($walletAmount->type == 'refund' && $walletAmount->status == 'approve')
                            <button class="primary-btn small bg-primary text-white border-0">@lang('wallet::wallet.refund')</button>
                        @endif
                    </td>
                    <td>{{dateConvert($walletAmount->created_at)}}</td>
                    <td>
                        @if ($walletAmount->note)
                            <a class="text-color" data-toggle="modal" data-target="#showNote{{$walletAmount->id}}"  href="#">@lang('common.view')</a>
                        @endif
                    </td>
                    <td>
                        @if (file_exists($walletAmount->file))
                            <a class="text-color" data-toggle="modal" data-target="#showFile{{$walletAmount->id}}"  href="#">@lang('common.view')</a>
                        @endif
                    </td>
                    <td>
                        @if ($walletAmount->status == 'approve' || $walletAmount->status == 'reject')
                            {{dateConvert($walletAmount->updated_at)}}
                        @endif
                    </td>
                    <td>
                        @if ($walletAmount->reject_note)
                            <a class="text-color" data-toggle="modal" data-target="#feedBack{{$walletAmount->id}}"  href="#">@lang('common.view')</a>
                        @endif
                    </td>
                </tr>

                {{-- Note Start  --}}
                <div class="modal fade admin-query" id="showNote{{$walletAmount->id}}">
                    <div class="modal-dialog modal-dialog-centered large-modal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('wallet::wallet.view_note')</h4>
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

                {{-- File View and Download Modal Start  --}}
                <div class="modal fade admin-query" id="showFile{{$walletAmount->id}}">
                    <div class="modal-dialog modal-dialog-centered large-modal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('wallet::wallet.view_file')</h4>
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
                                                    <a href="{{url(@$walletAmount->file)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                </div>
                                            @else
                                                @if (file_exists($walletAmount->file))
                                                    <div class="mb-5">
                                                        <img class="img-fluid" src="{{asset($walletAmount->file)}}">
                                                    </div>
                                                    <br>
                                                    <div class="mb-5">
                                                        <a href="{{url(@$walletAmount->file)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
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

                {{-- Feedback View Start  --}}
                <div class="modal fade admin-query" id="feedBack{{$walletAmount->id}}">
                    <div class="modal-dialog modal-dialog-centered large-modal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">@lang('wallet::wallet.view_feedback')</h4>
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
                {{-- Feedback View End  --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade admin-query" id="addWalletPayment">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('wallet::wallet.add_amount')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'wallet.add-wallet-amount', 'method' => 'POST', 'enctype' => 'multipart/form-data','id'=> 'addWalletAmount' ]) }}
                    <div class="row mt-25">
                        <div class="col-lg-12">
                            <div class="input-effect">
                                <input class="primary-input form-control" type="text" name="amount" id="walletAmount">
                                <label>@lang('wallet::wallet.amount') <span>*</span> </label>
                                <span class="walletError" id="walletAmountError"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-20">
                        <div class="col-lg-12">
                            <select class="niceSelect w-100 bb form-control" name="payment_method" id="addWalletPaymentMethod">
                                <option data-display="@lang('fees.payment_method') *" value="">@lang('fees.payment_method') *</option>
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{$paymentMethod->method}}">{{$paymentMethod->method}} {{  serviceCharge($paymentMethod->method) ? '+ '.__('common.service_charge').'('.serviceCharge($paymentMethod->method).')':null }}</option>
                                @endforeach
                            </select>
                            <span class="walletError" id="paymentMethodError"></span>
                        </div>
                    </div>

                    <div class="row mt-20 addWalletBank d-none">
                        <div class="col-lg-12">
                            <select class="niceSelect w-100 bb form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}" name="bank">
                                <option data-display="@lang('fees.select_bank')*" value="">@lang('fees.select_bank')*</option>
                                @foreach ($bankAccounts as $bankAccount)
                                    <option value="{{$bankAccount->id}}" {{old('bank') == $bankAccount->id ? 'selected' : ''}}>{{$bankAccount->bank_name}} ({{$bankAccount->account_number}})</option>
                                @endforeach
                            </select>
                            <span class="walletError" id="bankError"></span>
                        </div>
                    </div>

                    <div class="row mt-20 AddWalletChequeBank d-none">
                        <div class="col-lg-12">
                            <div class="input-effect">
                                <textarea class="primary-input form-control" cols="0" rows="3" name="note" id="note">{{old('note')}}</textarea>
                                <label>@lang('wallet::wallet.note') <span></span> </label>
                                <span class="focus-border textarea"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row no-gutters input-right-icon mt-25 AddWalletChequeBank d-none">
                        <div class="col">
                            <div class="input-effect">
                                <input class="primary-input form-control {{ $errors->has('file') ? ' is-invalid' : '' }}" readonly="true" type="text"
                                    placeholder="{{isset($editData->upload_file) && @$editData->upload_file != ""? getFilePath3(@$editData->upload_file):trans('common.file').''}}"
                                    id="placeholderUploadContent">
                                <span class="focus-border"></span>
                                @if ($errors->has('file'))
                                    <span class="invalid-feedback mb-10" role="alert">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <button class="primary-btn-small-input" type="button">
                                <label class="primary-btn small fix-gr-bg" for="upload_content_file">@lang('common.browse')</label>
                                <input type="file" class="d-none form-control" name="file" id="upload_content_file">
                            </button>
                        </div>
                        <br>
                    </div>

                    <div class="AddWalletChequeBank d-none text-center">
                        <code>(JPG, JPEG, PNG, PDF are allowed for upload)</code>
                    </div>
                    <span class="walletError" id="fileError"></span>

                    <div class="stripeInfo d-none">
                        <div class="row mt-30">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('name_on_card') ? ' is-invalid' : '' }}" type="text" name="name_on_card" id="name_on_card" autocomplete="off" value="{{old('name_on_card')}}">
                                    <label>@lang('accounts.name_on_card') <span>*</span> </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('name_on_card'))
                                        <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('name_on_card') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-30">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <input class="primary-input form-control card-number" type="text" name="card-number" id="card-number" autocomplete="off" value="{{old('card-number')}}">
                                    <label>@lang('accounts.card_number') <span>*</span> </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('card_number'))
                                        <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('card_number') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-30">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <input class="primary-input form-control card-cvc" type="text" name="card-cvc" id="card-cvc" autocomplete="off" value="{{old('card-cvc')}}">
                                    <label>@lang('accounts.cvc') <span>*</span> </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('cvc'))
                                        <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('cvc') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-30">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <input class="primary-input form-control card-expiry-month" type="text" name="card-expiry-month" id="card-expiry-month" autocomplete="off" value="{{old('card-expiry-month')}}">
                                    <label>@lang('accounts.expiration_month') <span>*</span> </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('expiration_month'))
                                        <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('expiration_month') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-30">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <input class="primary-input form-control card-expiry-year" type="text" name="card-expiry-year" id="card-expiry-year" autocomplete="off" value="{{old('card-expiry-year')}}">
                                    <label>@lang('accounts.expiration_year') <span>*</span> </label>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('expiration_year'))
                                        <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('expiration_year') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (moduleStatusCheck('MercadoPago') == true)
                        @include('mercadopago::form.userForm',['wallet'=>true])
                    @endif

                    <div class="row mt-30">
                        <div class="col-lg-12 text-center">
                            <button class="primary-btn fix-gr-bg submit addWallet generalPay" title="@lang('common.add')">
                                <span class="ti-check"></span>@lang('common.add')
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>
{{-- Refund Request Start --}}
<div class="modal fade admin-query" id="refundRequest">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('wallet::wallet.refund_request')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'wallet.wallet-refund-request-store', 'method' => 'POST', 'enctype' => 'multipart/form-data','id'=> 'refundAmount']) }}
                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                <div class="modal-body">
                    <div class="row mt-25">
                        <div class="col-lg-12">
                            <div class="input-effect">
                                <input class="primary-input border-0" type="text" value="{{(Auth::user()->wallet_balance != null) ? number_format(Auth::user()->wallet_balance, 2, '.', ''): 0.00}}" name="refund_amount" readonly>
                                <label>@lang('wallet::wallet.wallet_balance') ({{generalSetting()->currency_symbol}})</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-20">
                        <div class="col-lg-12">
                            <div class="input-effect">
                                <textarea class="primary-input form-control" cols="0" rows="3" name="refund_note" id="refundNote">{{old('refund_note')}}</textarea>
                                <label>@lang('wallet::wallet.note')<span>*</span> </label>
                                <span class="focus-border textarea"></span>
                                <span class="walletError" id="refundNoteError"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row no-gutters input-right-icon mt-25">
                        <div class="col">
                            <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input form-control {{ $errors->has('refund_file') ? ' is-invalid' : '' }}" readonly="true" type="text"
                                        placeholder="{{isset($editData->upload_file) && @$editData->upload_file != ""? getFilePath3(@$editData->upload_file):trans('common.file').''}}"
                                        id="placeholderRefund">
                                    <span class="focus-border"></span>
                                    @if ($errors->has('refund_file'))
                                        <span class="invalid-feedback mb-10" role="alert">
                                            <strong>{{ $errors->first('refund_file') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <button class="primary-btn-small-input" type="button">
                                <label class="primary-btn small fix-gr-bg" for="wallet_refund">@lang('common.browse')</label>
                                <input type="file" id="wallet_refund" class="d-none cutom-photo" name="refund_file">
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <code>(JPG, JPEG, PNG, PDF are allowed for upload)</code>
                    </div>
                    <span class="walletError" id="refundFileError"></span>
                    <span class="walletError" id="existsError"></span>
                    @if (Auth::user()->wallet_balance > 0)
                        <div class="row mt-30">
                            <div class="col-lg-12 text-center">
                                <button class="primary-btn fix-gr-bg submit addWallet" title="@lang('common.add')">
                                    <span class="ti-check"></span>
                                    @lang('common.submit')
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
{{-- Refund Request End --}}


