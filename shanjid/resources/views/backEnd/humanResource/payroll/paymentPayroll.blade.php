<div class="container-fluid">
   {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'savePayrollPaymentData',
   'method' => 'POST', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return validateForm()']) }}
   <div class="row">
    <div class="col-lg-12">
        <div class="row mt-25">
            <div class="col-lg-6" id="sibling_class_div">
                <div class="input-effect">
                    <input readonly class="read-only-input primary-input form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" type="text" name="amount" value="{{$payrollDetails->staffs->full_name}} ({{$payrollDetails->staffs->staff_no}})">
                    <input type="hidden" name="payroll_generate_id" value="{{$payrollDetails->id}}">
                    <input type="hidden" name="role_id" value="{{$role_id}}">
                    <input type="hidden" name="payroll_month" value="{{$payrollDetails->payroll_month}}">
                    <input type="hidden" name="payroll_year" value="{{$payrollDetails->payroll_year}}">
                    <label>@lang('hr.staff_name') <span></span> </label>
                    <span class="focus-border"></span>
                    @if ($errors->has('amount'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('amount') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-6" id="">
                <div class="input-effect">
                    <select class="niceSelect1 w-100 bb form-control{{ $errors->has('expense_head_id') ? ' is-invalid' : '' }}" name="expense_head_id" id="expense_head_id">
                        <option data-display="Expense Head*" value="">@lang('accounts.expense_head') *</option>
                        @if(isset($chart_of_accounts))
                        @foreach($chart_of_accounts as $value)
                        <option value="{{$value->id}}" >{{$value->head}}</option>
                        @endforeach
                        @endif
                    </select>
                    <span class="modal_input_validation red_alert"></span>

                </div>
            </div>
        </div>

        <div class="row mt-25">
            <div class="col-lg-6" id="">
                <div class="input-effect">
                    <input readonly class="read-only-input primary-input form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" type="text" name="amount" value="{{$payrollDetails->payroll_month}} - {{$payrollDetails->payroll_year}}">
                    <label>@lang('hr.month_year') <span></span> </label>
                    <span class="focus-border"></span>
                    @if ($errors->has('amount'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('amount') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="col-lg-6" id="">
                <div class="input-effect">
                    <input class="read-only-input primary-input date form-control{{ $errors->has('apply_date') ? ' is-invalid' : '' }}" id="payment_date" type="text"
                    name="payment_date" value="{{date('m/d/Y')}}">
                    <label>@lang('fees.payment_date') <span>*</span> </label>
                    <span class="focus-border"></span>
                    @if ($errors->has('payment_date'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('payment_date') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            
        </div>

        <div class="row mt-25">
            <div class="col-lg-6">
                <div class="input-effect">
                    <input class="read-only-input primary-input form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" type="text" name="" value="{{$payrollDetails->net_salary}}" readonly>
                    <label>@lang('accounts.payment_amount') <span>*</span> </label>
                    <span class="focus-border"></span>
                    @if ($errors->has('discount'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('discount') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-effect">
                    <select class="niceSelect1 w-100 bb form-control{{ $errors->has('payment_mode') ? ' is-invalid' : '' }}" name="payment_mode" id="payment_mode">
                        <option data-display="Payment Method *" value="">@lang('accounts.payment_method') *</option>
                        @if(isset($paymentMethods))
                        @foreach($paymentMethods as $value)
                        <option value="{{$value->id}}" >{{$value->method}}</option>
                        @endforeach
                        @endif
                    </select>
                    <span class="modal_input_validation red_alert"></span>
                </div>
            </div>
        </div>
        <div class="row mt-25" id="bankOption">
            <div class="col-lg-12">
                <div class="input-effect">
                    <select class="niceSelect1 w-100 bb form-control{{ $errors->has('bank_id') ? ' is-invalid' : '' }}" name="bank_id" id="account_id">
                    @if(isset($account_id))
                    @foreach($account_id as $key=>$value)
                    <option value="{{$value->id}}">{{$value->bank_name}}</option>
                    @endforeach
                    @endif
                    </select>
                    <span class="focus-border"></span>
                    @if ($errors->has('bank_id'))
                    <span class="invalid-feedback invalid-select" role="alert">
                        <strong>{{$errors->first('bank_id')}}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mt-25">
            <div class="col-lg-12" id="sibling_name_div">
                <div class="input-effect mt-20">
                    <textarea class="primary-input form-control" cols="0" rows="3" name="note" id="note"></textarea>
                    <label>@lang('common.note') </label>
                    <span class="focus-border textarea"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 text-center mt-40">
        <div class="mt-40 d-flex justify-content-between">
            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
            <input class="primary-btn fix-gr-bg" type="submit" value="save information">
        </div>
    </div>
</div>
{{ Form::close() }}
</div>

<script>

 //Payroll proceed to pay
 $(document).ready(function(){
        $('#bankOption').hide();
    });

    $(document).ready(function(){
        $("#payment_mode").on("change", function() {
            if ($(this).val() == "3") {
                $('#bankOption').show();
            } else {
                $('#bankOption').hide();
            }
        });
    });

$("#search-icon").on("click", function() {
        $("#search").focus();
    });

    $("#start-date-icon").on("click", function() {
        $("#startDate").focus();
    });

    $("#end-date-icon").on("click", function() {
        $("#endDate").focus();
    });

    $(".primary-input.date").datepicker({
        autoclose: true,
        setDate: new Date(),
    });
    $(".primary-input.date").on("changeDate", function(ev) {
        // $(this).datepicker('hide');
        $(this).focus();
    });

    $(".primary-input.time").datetimepicker({
        format: "LT",
    });

    if ($(".niceSelect1").length) {
        $(".niceSelect1").niceSelect();
    }
</script>