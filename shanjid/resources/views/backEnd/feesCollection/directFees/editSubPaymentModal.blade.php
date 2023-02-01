<style type="text/css">
      #bank-area, #cheque-area{
          display: none;
      }
      .primary-input ~ label {
      top: -15px;
      }
  </style>
  
  <div class="container-fluid">
      {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'directFees.updateSubPaymentModal','method' => 'POST', 'enctype' => 'multipart/form-data']) }}
          <div class="row">
                <input type="hidden" name="sub_payment_id" value="{{$payment->id}}" >
              <div class="col-lg-12">
                  <div class="row mt-25">
                      <div class="col-lg-6" id="sibling_class_div">
                          <div class="input-effect">
                              <input oninput="numberMinZeroCheck(this)" class="primary-input form-control" type="text" max="{{$payment->paid_amount}}" name="amount" value="{{$payment->paid_amount}}" id="amount" required >
                              <label>@lang('fees.paid_amount') <span>*</span> </label>
                              <span class="focus-border"></span>
                              <span class="text-danger" role="alert" id="amount_error"></span>
                          </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="no-gutters input-right-icon">
                            <div class="col">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input date form-control{{ $errors->has('payment_date') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                         name="payment_date" value="{{date('m/d/Y', strtotime($payment->payment_date))}}" autocomplete="off">
                                        <label>@lang('fees.payment_date') <span> *</span></label>
                                        <span class="focus-border"></span>
                                    @if ($errors->has('payment_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('payment_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <button class="" type="button">
                                    <i class="ti-calendar" id="start-date-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                      
                  </div>
                  </div>
              </div>
              <div class="col-lg-12 text-center mt-40">
                  <div class="mt-40 d-flex justify-content-between">
                      <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
  
                      <button class="primary-btn fix-gr-bg submit" type="submit">@lang('common.save_information')</button>
                  </div>
              </div>
          </div>
      {{ Form::close() }}
  </div>

  <script>
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
</script>
  






  