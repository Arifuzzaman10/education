@push('css')
    <link rel="stylesheet" href="{{url('Modules\Fees\Resources\assets\css\feesStyle.css')}}"/>
@endpush

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('fees::feesModule.add_fees_payment')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('fees::feesModule.fees')</a>
                @if (isset($role) && $role =='admin')
                    <a href="{{route('fees.fees-invoice-list')}}">@lang('fees::feesModule.fees_invoice')</a>
                @elseif(isset($role) && $role =='student')
                    <a href="#">@lang('fees::feesModule.fees_invoice')</a>
                @endif
                <a href="#">@lang('fees::feesModule.add_fees_payment')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor student-details">
    <div class="container-fluid p-0">
        @if (isset($role) && $role =='admin')
            {{ Form::open(['class' => 'form-horizontal', 'method' => 'POST', 'route' => 'fees.fees-payment-store', 'enctype' => 'multipart/form-data']) }}
            <input type="hidden" name="record_id" value="{{$invoiceInfo->recordDetail->id}}">
        @else
            {{ Form::open(['class' => 'form-horizontal', 'method' => 'POST', 'route' => 'fees.student-fees-payment-store', 'id'=>'addFeesPayment','enctype' => 'multipart/form-data']) }}
            @if (isset(Auth::user()->wallet_balance))
                <input type="hidden" name="wallet_balance"
                       value="{{(Auth::user()->wallet_balance != null) ? Auth::user()->wallet_balance:""}}">
            @endif
        @endif
        <div class="row">
            <div class="col-lg-3">
                <div class="main-title">
                    <h3 class="mb-30">@lang('student.student_details')</h3>
                </div>
                <div class="student-meta-box">
                    <div class="student-meta-top"></div>
                    <img class="student-meta-img img-100"
                         src="{{($invoiceInfo->studentInfo->student_photo)? $invoiceInfo->studentInfo->student_photo : asset('public/uploads/staff/demo/staff.jpg')}}"
                         alt="">
                    <div class="white-box radius-t-y-0">
                        <div class="single-meta mt-10">
                            <div class="d-flex justify-content-between">
                                <div class="name">@lang('student.student_name')</div>
                                <div class="value">{{$invoiceInfo->studentInfo->full_name}}</div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">@lang('student.admission_number')</div>
                                <div class="value">{{$invoiceInfo->studentInfo->admission_no}}</div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">@lang('student.roll_number')</div>
                                <div class="value">{{$invoiceInfo->recordDetail->roll_no}}</div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">@lang('common.class')</div>
                                <div class="value">{{$invoiceInfo->recordDetail->class->class_name}}</div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name"> @lang('common.section')</div>
                                <div class="value">{{$invoiceInfo->recordDetail->section->section_name}}</div>
                            </div>
                        </div>
                        @if (isset($role) && $role =='admin')
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">@lang('wallet::wallet.wallet_balance')</div>
                                    <div class="value">
                                        {{generalSetting()->currency_symbol}}{{number_format($invoiceInfo->studentInfo->user->wallet_balance, 2, '.', '')}}
                                    </div>
                                </div>
                            </div>
                        @else
                            @if (isset(Auth::user()->id))
                                <div class="single-meta">
                                    <div class="d-flex justify-content-between">
                                        <div class="name">@lang('wallet::wallet.wallet_balance')</div>
                                        <div class="value">
                                            {{generalSetting()->currency_symbol}}{{(Auth::user()->wallet_balance != null) ? number_format(Auth::user()->wallet_balance, 2, '.', ''): 0.00}}
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="wallet_balance"
                                       value="{{(Auth::user()->wallet_balance != null) ? Auth::user()->wallet_balance:""}}">
                            @endif
                        @endif
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">@lang('wallet::wallet.add_in_wallet')</div>
                                <div class="value">
                                    <span class="add_wallet">{{generalSetting()->currency_symbol}}0.00</span>
                                    <input type="hidden" id="currencySymbol"
                                           value="{{generalSetting()->currency_symbol}}">
                                    <input type="hidden" name="add_wallet" id="addWallet" value="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-25">
                            <div class="col-lg-12">
                                <select class="niceSelect w-100 bb form-control{{ $errors->has('payment_method') ? ' is-invalid' : '' }}"
                                        name="payment_method" id="paymentMethodAddFees">
                                    <option data-display="@lang('accounts.payment_method')*"
                                            value="">@lang('accounts.payment_method')*
                                    </option>
                                    @foreach ($paymentMethods as $paymentMethod)
                                        <option value="{{$paymentMethod->method}}" {{old('payment_method') == $paymentMethod->method ? 'selected' : ''}}>{{$paymentMethod->method}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('payment_method'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('payment_method') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-25 d-none" id="bankPaymentAddFees">
                            <div class="col-lg-12">
                                <select class="niceSelect w-100 bb form-control{{ $errors->has('bank') ? ' is-invalid' : '' }}"
                                        name="bank">
                                    <option data-display="@lang('fees::feesModule.select_bank')*"
                                            value="">@lang('fees::feesModule.select_bank')*
                                    </option>
                                    @foreach ($bankAccounts as $bankAccount)
                                        <option value="{{$bankAccount->id}}" {{old('bank') == $bankAccount->id ? 'selected' : ''}}>{{$bankAccount->bank_name}}
                                            ({{$bankAccount->account_number}})
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('bank'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('bank') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-25 chequeBank d-none">
                            <div class="col-lg-12">
                                <div class="input-effect">
                                    <textarea class="primary-input form-control" cols="0" rows="3" name="payment_note"
                                              id="note">{{old('payment_note')}}</textarea>
                                    <label>@lang('common.note') <span></span> </label>
                                    <span class="focus-border textarea"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row no-gutters input-right-icon mt-25 chequeBank d-none">
                            <div class="col">
                                <div class="input-effect">
                                    <input class="primary-input form-control {{ $errors->has('file') ? ' is-invalid' : '' }}"
                                           readonly="true" type="text"
                                           placeholder="{{isset($editData->upload_file) && @$editData->upload_file != ""? getFilePath3(@$editData->upload_file):trans('common.file').''}}"
                                           id="placeholderUploadContent">
                                    <span class="focus-border"></span>
                                    @if ($errors->has('file'))
                                        <span class="invalid-feedback mb-20" role="alert">
                                            <strong>{{ $errors->first('file') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="primary-btn small fix-gr-bg"
                                           for="upload_content_file">@lang('common.browse')</label>
                                    <input type="file" class="d-none form-control" name="file" id="upload_content_file">
                                </button>
                            </div>
                        </div>
                        <div class="chequeBank d-none text-center">
                            <code>(JPG, JPEG, PNG, PDF are allowed for upload)</code>
                        </div>

                        <div class="stripPayment d-none">
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="input-effect">
                                        <input class="primary-input form-control{{ $errors->has('name_on_card') ? ' is-invalid' : '' }}"
                                               type="text" name="name_on_card" autocomplete="off"
                                               value="{{old('name_on_card')}}">
                                        <label>@lang('accounts.name_on_card') <span>*</span> </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('name_on_card'))
                                            <span class="invalid-feedback"
                                                  role="alert"> <strong>{{ $errors->first('name_on_card') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="input-effect">
                                        <input class="primary-input form-control{{ $errors->has('card-number') ? ' is-invalid' : '' }} card-number"
                                               type="text" name="card-number" autocomplete="off"
                                               value="{{old('card-number')}}">
                                        <label>@lang('accounts.card_number') <span>*</span> </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('card-number'))
                                            <span class="invalid-feedback"
                                                  role="alert"> <strong>{{ $errors->first('card-number') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="input-effect">
                                        <input class="primary-input form-control card-cvc" type="text" name="card-cvc"
                                               autocomplete="off" value="{{old('card-cvc')}}">
                                        <label>@lang('accounts.cvc') <span>*</span> </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('card-cvc'))
                                            <span class="invalid-feedback"
                                                  role="alert"> <strong>{{ $errors->first('card-cvc') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="input-effect">
                                        <input class="primary-input form-control card-expiry-month" type="text"
                                               name="card-expiry-month" autocomplete="off"
                                               value="{{old('card-expiry-month')}}">
                                        <label>@lang('accounts.expiration_month') <span>*</span> </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('card-expiry-month'))
                                            <span class="invalid-feedback"
                                                  role="alert"> <strong>{{ $errors->first('card-expiry-month') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="input-effect">
                                        <input class="primary-input form-control card-expiry-year" type="text"
                                               name="card-expiry-year" autocomplete="off"
                                               value="{{old('card-expiry-year')}}">
                                        <label>@lang('accounts.expiration_year') <span>*</span> </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('card-expiry-year'))
                                            <span class="invalid-feedback"
                                                  role="alert"> <strong>{{ $errors->first('card-expiry-year') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (moduleStatusCheck('MercadoPago') == true)
                            {{-- @include('mercadopago::form.userForm',['student_id' => $invoiceInfo->recordDetail->id, 'invoice_id' => $invoiceInfo->id,'fees'=>true]) --}}
                        @endif
                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                                <button class="primary-btn fix-gr-bg submit fmInvoice" data-toggle="tooltip">
                                    <span class="ti-check"></span>
                                    @lang('inventory.add_payment')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('fees::feesModule.fees_type_list')</h3>
                        </div>
                    </div>
                </div>
                <div class="white-box mt-4">                    
                    <div class="row">
                        <div class="col-lg-12">  
                            
                            <input type="hidden" class="weaverType" value="amount">
                            <div class="big-table"> 
                                <h4 class="text-danger" id="serviceChargeTitle"></h4> 
                                <span id="payable_amount"></span>                          
                                <table class="display school-table school-table-style p-0" cellspacing="0" width="100%">                                
                                    <thead>
                                    <tr>
                                        <th>@lang('common.sl')</th>
                                        <th>@lang('fees::feesModule.fees_type')</th>
                                        <th>@lang('accounts.amount')</th>
                                        <th>@lang('fees::feesModule.due')</th>
                                        <th>@lang('fees::feesModule.paid_amount')</th>
                                        <th>@lang('exam.waiver')</th>
                                        <th>@lang('fees::feesModule.fine')</th>
                                        <th>@lang('common.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (isset($invoiceInfo))
                                        <input type="hidden" name="invoice_id" value="{{$invoiceInfo->id}}">
                                        <input type="hidden" class="weaverType" value="amount">
                                        <input type="hidden" name="student_id" value="{{$invoiceInfo->recordDetail->id}}">
                                        @foreach ($invoiceDetails as $key=>$invoiceDetail)
                                            <tr>
                                                <td></td>
                                                <input type="hidden" name="fees_type[]"
                                                    value="{{$invoiceDetail->fees_type}}">
                                                <td>{{@$invoiceDetail->feesType->name}}</td>
                                                <td>
                                                    <div class="input-effect">
                                                        <input class="primary-input border-0 form-control addFeesAmount{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                                                            type="text" name="amount[]" autocomplete="off"
                                                            value="{{isset($invoiceDetail)? $invoiceDetail->amount: old('amount')}}"
                                                            readonly>

                                                        @if ($errors->has('amount'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('amount') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-effect">
                                                        <input class="primary-input border-0 form-control showTotalValue"
                                                            type="text" name="due[]"
                                                            value="{{isset($invoiceDetail)? $invoiceDetail->due_amount:""}}"
                                                            autocomplete="off" readonly>
                                                        <input class="dueAmount" type="hidden"
                                                            value="{{isset($invoiceDetail)? $invoiceDetail->due_amount:0}}">
                                                        <input class="extraAmount" type="hidden" name="extraAmount[]"
                                                            value="0">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="primary-input form-control addFeesPaidAmount" type="text"
                                                        name="paid_amount[]" autocomplete="off">
                                                </td>
                                                <td>
                                                    @if (isset($role) && $role == 'admin')
                                                        <div class="input-effect">
                                                            <input class="primary-input form-control addFeesWeaver"
                                                                type="text" name="weaver[]" autocomplete="off"
                                                                value="{{isset($invoiceDetail)? $invoiceDetail->weaver: old('weaver')}}">
                                                            <input class="previousWeaver" type="hidden"
                                                                value="{{isset($invoiceDetail)? $invoiceDetail->weaver: ''}}">
                                                            <span class="focus-border"></span>
                                                        </div>
                                                    @else
                                                        <input class="primary-input border-0 form-control"
                                                            value="{{isset($invoiceDetail)? $invoiceDetail->weaver:0}}"
                                                            autocomplete="off" readonly>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($role) && $role == 'admin')
                                                        <input class="primary-input form-control addFeesFine" type="text"
                                                            name="fine[]" autocomplete="off" value="0">
                                                    @else
                                                        <input class="primary-input border-0 form-control"
                                                            value="{{isset($invoiceDetail)? $invoiceDetail->fine:0}}"
                                                            autocomplete="off" readonly>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="primary-btn icon-only fix-gr-bg" data-toggle="modal"
                                                            data-tooltip="tooltip"
                                                            data-target="#addNotesModal{{$invoiceDetail->fees_type}}"
                                                            type="button"
                                                            data-placement="top" title="@lang('common.add_note')">
                                                        <span class="ti-pencil-alt"></span>
                                                    </button>
                                                </td>
                                                {{-- Notes Modal Start --}}
                                                <div class="modal fade admin-query"
                                                    id="addNotesModal{{$invoiceDetail->fees_type}}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('common.add_note')</h4>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    &times;
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="input-effect">
                                                                    <input class="primary-input form-control has-content"
                                                                        type="text" name="note[]" autocomplete="off">
                                                                    <label>@lang('common.note')</label>
                                                                    <span class="focus-border"></span>
                                                                </div>
                                                                </br>
                                                                <div class="mt-40 d-flex justify-content-between">
                                                                    <button type="button" class="primary-btn tr-bg"
                                                                            data-dismiss="modal">@lang('common.cancel')</button>
                                                                    <button type="button" class="primary-btn fix-gr-bg"
                                                                            data-dismiss="modal">@lang('common.save')</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Notes Modal End --}}
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <input class="totalStudentPaidAmount" id="ttlpaidAmount" type="hidden" name="total_paid_amount">
                                            <span id="amountDetail" class="main-title"></span>
                                        </td>
                                    </tr>
                                    </tfoot>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</section>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@if(moduleStatusCheck('RazorPay'))
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endif
<script type="text/javascript">
    @if(moduleStatusCheck('RazorPay'))
    var payment = false;
    function demoSuccessHandler(transaction) {
        payment = true;
        $('form#addFeesPayment').submit();
    }
    @endif
    window.paymentValue = $('#paymentMethodAddFees').val();
    $(function () {
        var $form = $("form#addFeesPayment");
        var publisherKey = '{!!$stripe_info->gateway_publisher_key !!}';
        var ccFalse = false;
        $('form#addFeesPayment').on('submit', function (e) {
            if (paymentValue == "Stripe") {
                if (!ccFalse) {
                    e.preventDefault();
                    Stripe.setPublishableKey(publisherKey);
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
            }
                    @if(moduleStatusCheck('RazorPay'))
            else if (paymentValue == 'RazorPay') {
                if (!payment) {
                    e.preventDefault();
                    let value = parseFloat($('input[name="total_paid_amount"]').val());
                    if (isNaN(value)) {
                        value = 0;
                    }
                    value = value * 100;
                    if (value > 0) {
                        var options = {
                            key: "{{ @$razorpay_info->gateway_secret_key }}",
                            amount: value,
                            name: 'Online fee payment',
                            image: 'https://i.imgur.com/n5tjHFD.png',
                            handler: demoSuccessHandler
                        }

                        window.r = new Razorpay(options);
                        r.open();
                    } else {
                        toastr.error('Please make some payment');
                    }

                }
            }
            @endif

        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                $form.find('input[type=text]').empty();

                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });
    $(document).on('change', '#paymentMethodAddFees', function(){
        let gateway = $(this).val();
        let status = 'payment_method';
        let showStudentPaidAmount = 0;
        $('.dueAmount').each(function(i,e){
            let amount= $(this).val()-0;
            showStudentPaidAmount+=amount;
        });
        
        serviceCharge(gateway, showStudentPaidAmount, status);
    })
    $(document).on('keyup', '.addFeesPaidAmount', function(){
        let gateway = $('#paymentMethodAddFees').val();
        if(gateway == '') {           
            return ;
        }
        let paidAmount = 0;
                $('.addFeesPaidAmount').each(function(i,e){
                    let amount= $(this).val()-0;
                    paidAmount+=amount;
        });
        let status = 'goingToPay';
       
       
        serviceCharge(gateway, paidAmount, status);
    })
    function serviceCharge(gateway, amount, status)
    {
        var symbol = "{{ generalSetting()->currency_symbol }}";
        let amountTotal = parseFloat(amount);
        $.ajax({
            type:"GET",
            data : {gateway :gateway , amount : amountTotal, status : status},
            dataType:"JSON",
            url : "{{ route('gateway-service-charge') }}",
            success:function(data){                
                if(data.service_charge) {
                    if(status == 'payment_method') {                    
                        $('#serviceChargeTitle').html('You Have to Pay service charge '+data.service_charge + ' for ' + gateway + ' per transaction');
                    } 
                    if(data.service_charge_amount && status == 'goingToPay') {
                        let total = parseFloat(amount) + parseFloat(data.service_charge_amount);
                        $("#ttlpaidAmount").val(total);                        
                        $('#amountDetail').html('your payable amount with serivce charge : '+symbol+amount+'+'+symbol+ data.service_charge_amount +' = ' +symbol+parseFloat(total) );                       
                    }
                }
            },
            error:function()
            {

            }
        })
    }
</script>
<script type="text/javascript" src="{{url('Modules\Fees\Resources\assets\js\app.js')}}"></script>
<script>
    selectPosition({!! feesInvoiceSettings()->invoice_positions !!});
</script>