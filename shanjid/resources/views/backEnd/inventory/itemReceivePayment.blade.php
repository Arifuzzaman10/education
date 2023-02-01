
<div class="container-fluid">
   {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'save-item-receive-payment',
   'method' => 'POST', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return validateForm()']) }}

   <div class="row">
    <div class="col-lg-12">
        <div class="row mt-25">
            <div class="col-lg-12" id="">
               
            </div>
        </div>
        <input type="hidden" name="item_receive_id" value="{{$id}}">
        <div class="row mt-25">
            <div class="col-lg-12">
                <div class="input-effect">
                    <select class="niceSelect1 w-100 bb form-control{{ $errors->has('expense_head_id') ? ' is-invalid' : '' }}" name="expense_head_id" id="expense_head_id">
                        <option data-display="@lang('accounts.expense_head') *" value="">@lang('common.select')</option>
                            @foreach($expense_head as $key=>$value)
                            <option value="{{$value->id}}"
                            {{@$editData->expense_head_id == $value->id? 'selected': ''}}
                            >{{$value->head}}</option>
                            @endforeach
                        </select>
                        <span class="focus-border"></span>
                        @if ($errors->has('expense_head_id'))
                        <span class="invalid-feedback invalid-select" role="alert">
                            <strong>{{ $errors->first('expense_head_id') }}</strong>
                        </span>
                        @endif
                        <span class="modal_input_validation red_alert"></span>
                    </div>
            </div>
        </div>
        <div class="row mt-25">
        <div class="col-lg-12">
                <div class="input-effect">
                    <select class="niceSelect1 w-100 bb form-control{{ $errors->has('payment_mode') ? ' is-invalid' : '' }}" name="payment_method" id="item_receive_add_payment_method">
                        @if(@$editData->paymentMethodName->method =="Bank")
                            <option data-string="{{@$editData->paymentMethodName->method}}" value="{{@$editData->payment_method}}" selected>{{@$editData->paymentMethodName->method}}</option>
                        @else
                        @foreach($paymentMethhods as $key=>$value)
                        @if(isset($editData))
                        <option data-string="{{$value->method}}" value="{{$value->id}}"
                            {{@$editData->payment_method == $value->id? 'selected': ''}}>{{$value->method}}</option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                    <span class="modal_input_validation red_alert"></span>
                </div>
            </div>
            <input type="hidden" name="paymentMethodName" value="">
        </div>
        <div class="row mt-25">
            <div class="col-lg-12 d-none" id="add_payment_item_receive_bankAccount">
                <div class="input-effect">
                    <select class="niceSelect1 w-100 bb form-control{{ $errors->has('bank_id') ? ' is-invalid' : '' }}" name="bank_id" id="receive_account_id">
                        @if(isset($editData))
                            <option value="{{$editData->account_id}}" selected>{{@$editData->bankName->account_name}} ({{@$editData->bankName->bank_name}})</option>
                        @endif
                        </select>
                        <span class="focus-border"></span>
                        @if ($errors->has('bank_id'))
                        <span class="invalid-feedback invalid-select" role="alert">
                            <strong>{{ $errors->first('bank_id') }}</strong>
                        </span>
                        @endif
                </div>
            </div>
        </div>
        <div class="row mt-25">
            <div class="col-lg-12">
                <div class="input-effect">
                    <input class="read-only-input primary-input form-control{{ $errors->has('reference_no') ? ' is-invalid' : '' }}" type="text" name="reference_no" id="reference_no" value="">
                    <label> @lang('inventory.reference_note') <span>*</span> </label>
                    <span class="focus-border"></span>
                    @if ($errors->has('reference_no'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('reference_no') }}</strong>
                    </span>
                    @endif
                    <span class="modal_input_validation red_alert"></span>
                </div>
            </div>
        </div>

        <div class="row mt-25">
            <div class="col-lg-6">
                <div class="input-effect">
                    <input class="read-only-input primary-input form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" type="number" name="amount" value="{{$paymentDue->total_due}}" id="total_due" onkeyup="checkDue()">
                    <input type="hidden" id="total_due_value" value="{{$paymentDue->total_due}}">
                    <label>@lang('accounts.payment_amount') <span>*</span> </label>
                    <span class="focus-border"></span>
                    @if ($errors->has('amount'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('amount') }}</strong>
                    </span>
                    @endif
                    <span class="modal_input_validation red_alert"></span>
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
            <div class="col-lg-12" id="sibling_name_div">
                <div class="input-effect mt-20">
                    <textarea class="primary-input form-control" cols="0" rows="3" name="notes" id="notes"></textarea>
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
    if ($(".niceSelect1").length) {
        $(".niceSelect1").niceSelect();
    }

    $(document).ready(function() {
        $("#item_receive_add_payment_method").on("change", function() {
            let methodName = $(this).find(':selected').data('string');
            if (methodName == "Bank") {
                $("#add_payment_item_receive_bankAccount").removeClass('d-none');
            } else {
                $("#add_payment_item_receive_bankAccount").addClass('d-none');
            }
        });

        let methodType = $('#item_receive_add_payment_method').find(':selected').data('string');
        if (methodType == "Bank") {
            $("#add_payment_item_receive_bankAccount").removeClass('d-none');
        } else {
            $("#add_payment_item_receive_bankAccount").addClass('d-none');
        }
    });
</script>