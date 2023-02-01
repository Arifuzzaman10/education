@php 
$total_fees = 0;
$total_due = 0;
$total_paid = 0;
$total_disc = 0;
$balance_fees = 0;
@endphp
<table id="" class="display school-table school-table-style-parent-fees" cellspacing="0" width="100%">
      <thead>
        <tr>
            <td class="text-right" colspan="14">
                <a class="primary-btn small fix-gr-bg modalLink text-right" data-modal-size="modal-lg" title="@lang('fees.add_fees')" href="{{route('student-direct-fees-total-payment', [$record->id])}}" >  <i class="ti-plus pr-2"> </i> @lang('fees.add_fees') </a>
            </td>
        </tr>
          <tr>
            <th class="nowrap">@lang('fees.installment') </th>
            <th class="nowrap">@lang('fees.amount') ({{@generalSetting()->currency_symbol}})</th>
            <th class="nowrap">@lang('common.status')</th>
            <th class="nowrap">@lang('fees.due_date') </th>
            <th class="nowrap">@lang('fees.payment_ID')</th>
            <th class="nowrap">@lang('fees.mode')</th>
            <th class="nowrap">@lang('fees.payment_date')</th>
            <th class="nowrap">@lang('fees.discount') ({{@generalSetting()->currency_symbol}})</th>
            <th class="nowrap">@lang('fees.paid') ({{@generalSetting()->currency_symbol}})</th>
            <th class="nowrap">@lang('fees.balance')</th>
            <th class="nowrap">@lang('common.action')</th>
          </tr>
      </thead>
      <tbody>
        @foreach($record->directFeesInstallments as $key=> $feesInstallment)
        @php 
        $total_fees += discountFees($feesInstallment->id); 
        $total_paid += $feesInstallment->paid_amount;
        $total_disc += $feesInstallment->discount_amount;
        $balance_fees += discountFees($feesInstallment->id) - ( $feesInstallment->paid_amount );
        @endphp 
            <tr>
                <td>{{@$feesInstallment->installment->title}}</td>
                <td> 
                    @if($feesInstallment->discount_amount > 0)
                      <del>  {{$feesInstallment->amount}}  </del>
                      {{$feesInstallment->amount - $feesInstallment->discount_amount}}
                    @else 
                     {{$feesInstallment->amount}}
                    @endif 
                  </td>
                  <td>
                      <button class="primary-btn small {{feesPaymentStatus($feesInstallment->id)[1]}} text-white border-0">{{feesPaymentStatus($feesInstallment->id)[0]}}</button> 
                  </td>
                <td>{{@dateConvert($feesInstallment->due_date)}}</td>
                <td>
                  
                </td>
                
                <td>
                    
                </td>
               
              <td>
                   
              </td>
              <td> {{$feesInstallment->discount_amount}}</td>
              <td>
                  {{$feesInstallment->paid_amount}}
              </td>
                 
              <td>
                  {{discountFees($feesInstallment->id) - ( $feesInstallment->paid_amount ) }} </td>

                  @if ( discountFees($feesInstallment->id) - ( $feesInstallment->paid_amount ) ==0 )
                  <td>
                    <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                            @lang('common.select')
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item">@lang('fees.paid')</a>
                        </div>
                    </div>
                    </td>
                  @else
                  <td>

                        @php
                          $instalment_amount = $feesInstallment->amount;  
                        @endphp

                            <div class="dropdown">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                    @lang('common.select') 
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <!--  Start Xendit Payment -->
                                        @if(moduleStatusCheck('XenditPayment'))
                                            <form action="{!!route('xenditpayment.feesPayment')!!}" method="POST" style="width: 100%; text-align: center">
                                                @csrf
                                                <input type="hidden" name="installment_id" id="installment_id" value="{{$feesInstallment->id}}"/>
                                                <input type="hidden" name="amount" id="amount" value="{{ discountFees($feesInstallment->id) * 1000}}"/>
                                                <input type="hidden" name="student_id" id="student_id" value="{{@$student->id}}">
                                                <input type="hidden" name="payment_mode" id="payment_mode" value="{{$payment_gateway->id}}">
                                                <input type="hidden" name="amount" id="amount" value="{{ discountFees($feesInstallment->id) * 1000}}"/>
                                                <input type="hidden" name="record_id" value="{{$record->id}}">
                                                <div class="pay">
                                                    <button class="dropdown-item razorpay-payment-button btn filled small" type="submit">
                                                        @lang('fees.pay_with_xendit')
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    <!--  End Xendit Payment -->

                                    <!-- Start Khalti Payment  -->
                                        @if((moduleStatusCheck('KhaltiPayment') == TRUE))
                                            @php
                                                $is_khalti = DB::table('sm_payment_gateway_settings')
                                                            ->where('gateway_name','Khalti')
                                                            ->where('school_id', Auth::user()->school_id)
                                                            ->first('gateway_publisher_key');
                                            @endphp
                                            <div class="pay">
                                                <button class="dropdown-item btn filled small khalti-payment-button" data-amount="{{discountFees($feesInstallment->id)}}" data-recordId = "{{@$record->id}}">
                                                    @lang('fees.pay_with_khalti')
                                                </button>
                                            </div>
                                        @endif
                                      
                                    <!-- End Khalti Payment  -->
                                       

                                    <!-- Start Paypal Payment  -->
                                        @php
                                            $is_paypal = DB::table('sm_payment_methhods')
                                                        ->where('method','PayPal')
                                                        ->where('school_id', Auth::user()->school_id)
                                                        ->where('active_status',1)
                                                        ->first();
                                        @endphp
                                        @if(!empty($is_paypal) )
                                            <form method="POST" action="{{ route('studentPayByPaypal') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                                                @csrf
                                                <input type="hidden" name="installment_id" id="assign_id" value="{{$feesInstallment->id}}">
                                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                                <input type="hidden" name="real_amount" id="real_amount" value="{{discountFees($feesInstallment->id)}}">
                                                <input type="hidden" name="student_id" value="{{$student->id}}">
                                                <input type="hidden" name="record_id" value="{{@$record->id}}">
                                                <button type="submit" class=" dropdown-item">
                                                    @lang('fees.pay_with_paypal')
                                                </button>
                                            </form>
                                        @endif
                                    <!-- End Paypal Payment  -->

                                    <!-- Start Paystack Payment  -->
                                        @php
                                            $is_paystack = DB::table('sm_payment_methhods')
                                                        ->where('method','Paystack')
                                                        ->where('school_id', Auth::user()->school_id)
                                                        ->where('active_status',1)
                                                        ->first();
                                        @endphp
                                        @if(!empty($is_paystack))
                                            <form method="POST" action="{{ route('pay-with-paystack') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                                                @csrf
                                                <input type="hidden" name="installment_id" id="assign_id" value="{{$feesInstallment->id}}">
                                                @if(($student->email == ""))
                                                    <input type="hidden" name="email" value="{{ @$student->parents->guardians_email }}">
                                                @else
                                                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                                @endif
                                                <input type="hidden" name="orderID" value="{{$feesInstallment->id}}">
                                                <input type="hidden" name="amount" value="{{ discountFees($feesInstallment->id) * 100}}">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="student_id" value="{{$student->id}}">
                                                <input type="hidden" name="payment_mode" value="{{@$payment_gateway->id}}">
                                                <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
                                                <input type="hidden" name="key" value="{{ @$paystack_info->gateway_secret_key }}">
                                                <input type="hidden" name="record_id" value="{{@$record->id}}">
                                                <button type="submit" class=" dropdown-item">
                                                    @lang('fees.pay_via_paystack')
                                                </button>
                                            </form>
                                        @endif
                                    <!-- End Paystack Payment  -->

                                    <!-- Start Stripe Payment  -->
                                        @php
                                            $is_stripe = DB::table('sm_payment_methhods')
                                                        ->where('method','Stripe')
                                                        ->where('active_status',1)
                                                        ->where('school_id', Auth::user()->school_id)
                                                        ->first();
                                        @endphp
                                        @if(!empty($is_stripe))
                                            <a class="dropdown-item modalLink" data-modal-size="modal-lg" title="{{@$feesInstallment->installment->title}} "
                                                href="{{route('directFeesPaymentStripe',$feesInstallment->id)}} ">
                                                @lang('fees.pay_with_stripe')
                                            </a>
                                        @endif
                                    <!-- Start Stripe Payment  -->

                                    {{-- Start Xendit Payment --}}

                                    <!-- Start Razorpay Payment -->
                                        @php
                                            $is_active = DB::table('sm_payment_methhods')
                                                        ->where('method','RazorPay')
                                                        ->where('active_status',1)
                                                        ->where('school_id', Auth::user()->school_id)
                                                        ->first();
                                        @endphp
                                        @if(moduleStatusCheck('RazorPay') == TRUE and !empty($is_active))
                                            <form id="rzp-footer-form_{{$key}}" action="{!!route('razorpay/dopayment')!!}" method="POST" style="width: 100%; text-align: center">
                                                @csrf
                                                <input type="hidden" name="amount" id="amount" value="{{discount($feesInstallment->id) * 100}}"/>
                                                <input type="hidden" name="student_id" id="student_id" value="{{$student->id}}">
                                                <input type="hidden" name="payment_mode" id="payment_mode" value="{{$payment_gateway->id}}">
                                                <input type="hidden" name="amount" id="amount" value="{{discountFees($feesInstallment->id)}}"/>
                                                <div class="pay">
                                                    <button class="dropdown-item razorpay-payment-button btn filled small" id="paybtn_{{$key}}" type="button">
                                                        @lang('fees.pay_with_razorpay')
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    <!-- End Razorpay Payment -->

                                    <!-- Start Raudhahpay Payment  -->
                                        @if((moduleStatusCheck('Raudhahpay') == TRUE))
                                            <form id="xend-footer-form_{{$key}}" action="{!!route('raudhahpay.feesPayment')!!}" method="POST" style="width: 100%; text-align: center">
                                                @csrf
                                                <input type="hidden" name="amount" id="amount" value="{{discountFees($feesInstallment->id)}}"/>
                                                <input type="hidden" name="installment_id" id="assign_id" value="{{$feesInstallment->id}}">
                                                <input type="hidden" name="fees_type_id" id="fees_type_id" value="{{$feesInstallment->id}}">
                                                <input type="hidden" name="student_id" id="student_id" value="{{$student->id}}">
                                                <input type="hidden" name="record_id" id="record_id" value="{{$record->id}}">
                                                <input type="hidden" name="payment_method" id="payment_mode" value="5">
                                                <input type="hidden" name="amount" id="amount" value="{{discountFees($feesInstallment->id)}}"/>
                                                <div class="pay">
                                                    <button class="dropdown-item razorpay-payment-button btn filled small" id="paybtn_{{$key}}" type="submit">
                                                        @lang('fees.pay_with_raudhahpay')
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    <!-- End Raudhahpay Payment  -->
                                </div>
                            </div>

                            <!-- start razorpay code -->
                                <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                                <script>
                                    $('#rzp-footer-form_<?php echo $key; ?>').submit(function (e) {
                                        var button = $(this).find('button');
                                        var parent = $(this);
                                        button.attr('disabled', 'true').html('Please Wait...');
                                        $.ajax({
                                            method: 'get',
                                            url: this.action,
                                            data: $(this).serialize(),
                                            complete: function (r) {
                                                console.log('complete');
                                                console.log(r);
                                            }
                                        })
                                        return false;
                                    })
                                </script>
                                <script>
                                    function padStart(str) {
                                        return ('0' + str).slice(-2)
                                    }
                                    function demoSuccessHandler(transaction) {
                                        // You can write success code here. If you want to store some data in database.
                                        $("#paymentDetail").removeAttr('style');
                                        $('#paymentID').text(transaction.razorpay_payment_id);
                                        var paymentDate = new Date();
                                        $('#paymentDate').text(
                                            padStart(paymentDate.getDate()) + '.' + padStart(paymentDate.getMonth() + 1) + '.' + paymentDate.getFullYear() + ' ' + padStart(paymentDate.getHours()) + ':' + padStart(paymentDate.getMinutes())
                                        );

                                        $.ajax({
                                            method: 'post',
                                            url: "{!!url('razorpay/dopayment')!!}",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "razorpay_payment_id": transaction.razorpay_payment_id,
                                                "amount": <?php echo discountFees($feesInstallment->id) * 100; ?>,
                                                "student_id": <?php echo $student->id; ?>,
                                                "record_id": <?php echo $record->id; ?>
                                            },
                                            complete: function (r) {
                                                console.log('complete');
                                                console.log(r);

                                                setTimeout(function () {
                                                    toastr.success('Operation successful', 'Success', {
                                                        "iconClass": 'customer-info'
                                                    }, {
                                                        timeOut: 2000
                                                    });
                                                }, 500);

                                                location.reload();
                                            }
                                        })
                                    }
                                </script>
                                <script>
                                    var options_<?php echo $key; ?> = {
                                        key: "{{ @$razorpay_info->gateway_secret_key }}",
                                        amount: <?php echo discountFees($feesInstallment->id) * 100; ?>,
                                        name: 'Online fee payment',
                                        image: 'https://i.imgur.com/n5tjHFD.png',
                                        handler: demoSuccessHandler
                                    }
                                </script>
                                <script>
                                    window.r_<?php echo $key; ?> = new Razorpay(options_<?php echo $key; ?>);
                                    document.getElementById('paybtn_<?php echo $key; ?>').onclick = function () {
                                        r_<?php echo $key; ?>.open()
                                    }
                                </script>
                            <!-- end razorpay code -->
                     
                    </td>
                    @endif 
            </tr>




            @php $this_installment = discountFees($feesInstallment->id); @endphp
            @foreach($feesInstallment->payments as $payment)
                @php $this_installment = $this_installment - $payment->paid_amount; @endphp
           
           <tr>
             <td></td>
             <td></td>
             <td></td>
             <td class="text-right"><img src="{{asset('public/backEnd/img/table-arrow.png')}}"></td>
             <td>
                 @if($payment->active_status == 1)
                 <a href="#" data-toggle="tooltip" data-placement="right" title="{{'Collected By: '.@$payment->user->full_name}}">
                            {{@smFeesInvoice($payment->invoice_no)}}
                        </a>
                 @endif
             </td>
             <td>{{$payment->payment_mode}}</td>
             <td>{{@dateConvert($payment->payment_date)}}</td>
             <td>{{$payment->discount_amount}}</td>
             <td>{{$payment->paid_amount}}</td>
             <td>{{$this_installment}} </td>
             <td>
                <button class="primary-btn small bg-success text-white border-0">@lang('fees.paid')</button>
                  </td>
          </tr>  
         @endforeach



            @endforeach



            <tfoot>
                <tr>
                    <th>@lang('fees.grand_total') ({{generalSetting()->currency_symbol}})</th>
                    <th>{{@generalSetting()->currency_symbol}} {{$total_fees}}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{@generalSetting()->currency_symbol}} {{$total_disc}}</th>
                    <th>{{@generalSetting()->currency_symbol}} {{$total_paid}} </th>
                    <th>{{@generalSetting()->currency_symbol}}  {{$total_fees - ( $total_paid) }}</th>
                    <th></th>
                </tr>
            </tfoot>

      </tbody>
  </table>