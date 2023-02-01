@php
    $setting = generalSetting();
    if(isset($setting->copyright_text)){
    $copyright_text = $setting->copyright_text;
    }else{
    $copyright_text = 'Copyright 2019 All rights reserved by Codethemes';
    }
@endphp

</div>
</div>
@if(moduleStatusCheck('Lead')==true)
    @foreach ($reminders as $item)
    <div id="fullCalReminderModal_{{ $item->id }}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modalTitle" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span> <span class="sr-only">@lang('common.close')</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                @include('lead::lead_calender', ['event' => $item])
                </div>
                <div class="modal-footer">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.close')</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif
@if(config('app.app_sync'))
    <a target="_blank" href="https://1.envato.market/9WVoZ3" class="float_button"> <i class="ti-shopping-cart-full"></i>
        <h3>Purchase InfixEdu</h3>
    </a>
@endif
<div class="has-modal modal fade" id="showDetaildModal">
    <div class="modal-dialog modal-dialog-centered" id="modalSize">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="showDetaildModalTile">@lang('system_settings.new_client_information')</h4>
                <button type="button" class="close icons" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="showDetaildModalBody">

            </div>
        </div>
    </div>
</div>
<!--  Start Modal Area -->
<div class="modal fade invoice-details" id="showDetaildModalInvoice">
    <div class="modal-dialog large-modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.add_invoice')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="showDetaildModalBodyInvoice">
            </div>
        </div>
    </div>
</div>
<!--================Footer Area ================= -->
<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                @if(Auth::check())
                    <p>{!! $copyright_text !!} </p>
                @else
                    <p>{!! $copyright_text !!} </p>
                @endif
            </div>
        </div>
    </div>
</footer>

<!-- ================End Footer Area ================= -->

<script>
    window.jsLang = function(key, replace) {
        let translation = true

        let json_file = $.parseJSON(window._translations[window._locale]['json'])
        translation = json_file[key]
            ? json_file[key]
            : key


        $.each(replace, (value, key) => {
            translation = translation.replace(':' + key, value)
        })

        return translation
    }
</script>

<script src="{{asset('public/backEnd/')}}/vendors/js/jquery-ui.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/jquery.data-tables.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/dataTables.buttons.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/buttons.flash.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/jszip.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/pdfmake.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/vfs_fonts.js"></script>
<script src="{{asset('public/backEnd/js/vfs_fonts.js')}}"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/buttons.html5.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/buttons.print.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/dataTables.rowReorder.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/dataTables.responsive.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/buttons.colVis.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/popper.js"></script>
{{--<script src="{{asset('public/backEnd/')}}/vendors/js/bootstrap.min.js">--}}
{{--</script>--}}
<script src="{{asset('public/backEnd/js/metisMenu.js')}}"></script>
<script src="{{asset('public/backEnd/')}}/css/rtl/bootstrap.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/nice-select.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/jquery.magnific-popup.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/fastselect.standalone.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/raphael-min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/morris.min.js"></script>
<script type="text/javascript" src="{{asset('public/backEnd/')}}/vendors/js/toastr.min.js"></script>
<script type="text/javascript" src="{{asset('public/backEnd/')}}/vendors/js/moment.min.js"></script>
{{-- <script src="{{ asset('public/backEnd/vendors/editor/ckeditor/ckeditor.js') }}"></script> --}}
<script src="{{asset('public/backEnd/')}}/vendors/js/bootstrap_datetimepicker.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="{{asset('public/backEnd/')}}/vendors/js/fullcalendar.min.js"></script>
<script src="{{asset('public/backEnd/vendors/js/fullcalendar-locale-all.js')}}"></script>
<script type="text/javascript" src="{{asset('public/backEnd/')}}/js/jquery.validate.min.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/select2/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/js/main.js"></script>
<script src="{{asset('public/backEnd/')}}/js/lesson_plan.js"></script>
<script src="{{asset('public/backEnd/')}}/js/custom.js"></script>
<script src="{{asset('public/')}}/js/registration_custom.js"></script>
<script src="{{asset('public/backEnd/')}}/js/developer.js"></script>
<script src="{{asset('public/backEnd/')}}/vendors/js/daterangepicker.min.js"></script>
<script>
    pdfMake.fonts = {
        DejaVuSans: {
            normal: 'DejaVuSans.ttf',
            bold: 'DejaVuSans-Bold.ttf',
            italics: 'DejaVuSans-Oblique.ttf',
            bolditalics: 'DejaVuSans-BoldOblique.ttf'
        }
    };



        ;(function($){
        $.fn.datepicker.dates[_locale] = new Object({
            "days" : {!! json_encode(__('calender.days')) !!},
            "daysShort": {!! json_encode(__('calender.daysShort')) !!},
            "daysMin": {!! json_encode(__('calender.daysMin')) !!},
            "months": {!! json_encode(__('calender.months')) !!},
            "monthsShort": {!! json_encode(__('calender.monthsShort')) !!},
            "today": {!! json_encode(__('calender.today')) !!},
            "clear": {!! json_encode(__('calender.clear')) !!}
        })
    }(jQuery));

</script>
<script src="{{asset('public/backEnd/')}}/vendors/editor/summernote-bs4.js"></script>
<script src="{{url('Modules\Wallet\Resources\assets\js\wallet.js')}}"></script>

<script src="{{asset('public/backEnd/')}}/js/lesson_plan.js"></script>
{{-- <script src="{{asset('public/backEnd/')}}/saas/js1/custom.js"></script> --}}

<script type="text/javascript">
    //$('table').parent().addClass('table-responsive pt-4');
    // for select2 multiple dropdown in send email/Sms in Individual Tab
    $("#selectStaffss").select2();
    $("#checkbox").click(function() {
        if ($("#checkbox").is(':checked')) {
            $("#selectStaffss > option").prop("selected", "selected");
            $("#selectStaffss").trigger("change");
        } else {
            $("#selectStaffss > option").removeAttr("selected");
            $("#selectStaffss").trigger("change");
        }
    });

    // for select2 multiple dropdown in send email/Sms in Class tab
    $("#selectSectionss").select2();
    $("#checkbox_section").click(function() {
        if ($("#checkbox_section").is(':checked')) {
            $("#selectSectionss > option").prop("selected", "selected");
            $("#selectSectionss").trigger("change");
        } else {
            $("#selectSectionss > option").removeAttr("selected");
            $("#selectSectionss").trigger("change");
        }
    });
       // for select2 multiple dropdown in send email/Sms in Class tab
    $("#selectSectionssLms").select2();
    $("#checkbox_section").click(function() {
        if ($("#checkbox_section").is(':checked')) {
            $("#selectSectionssLms > option").prop("selected", "selected");
            $("#selectSectionssLms").trigger("change");
        } else {
            $("#selectSectionssLms > option").removeAttr("selected");
            $("#selectSectionssLms").trigger("change");
        }
    });

</script>
<script>
    $('.close_modal').on('click', function() {
        $('.custom_notification').removeClass('open_notification');
    });
    $('.notification_icon').on('click', function() {
        $('.custom_notification').addClass('open_notification');
    });
    $(document).click(function(event) {
        if (!$(event.target).closest(".custom_notification").length) {
            $("body").find(".custom_notification").removeClass("open_notification");
        }
    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : (event.keyCode);
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script src="{{asset('public/backEnd/')}}/js/search.js"></script>
{{-- <script src="{{asset('public/landing/js/toastr.js')}}"></script> --}}

{!! Toastr::message() !!}

{{--@if(request()->route()->getPrefix() == '/chat')--}}
<script src="{{ asset('public/js/app.js') }}"></script>
<script src="{{ asset('public/chat/js/custom.js') }}"></script>
{{--@endif--}}

{{-- <script src="{{asset('Modules/Saas/Resources/assets/saas/')}}/js/main.js"></script> --}}
{{-- <script src="{{asset('Modules/Saas/Resources/assets/saas/')}}/js/saas.js"></script> --}}
{{-- <script src="{{asset('Modules/Saas/Resources/assets/saas/')}}/js/developer.js"></script>
<script src="{{asset('Modules/Saas/Resources/assets/saas/')}}/js/search.js"></script> --}}
@yield('script')
@stack('script')
@stack('scripts')
@if(moduleStatusCheck('Lead')==true)

    @foreach ($reminders as $item)
        @php
        $reminder_date_time=Carbon::parse($item->date_time)->format('Y-m-d').' '.$item->time;
        @endphp
    <script>
        setInterval(() => {
            let id = {{ $item->id }};
            let reminder_date = '{{ $reminder_date_time }}';
            let current_time = moment().format('YYYY-MM-DD HH:mm:ss');

            let current_time_integer = Date.parse(current_time);
            let reminder_integer = Date.parse(reminder_date);
            if(current_time_integer==reminder_integer) {
                $('#fullCalReminderModal_'+id).modal('show');
            }
        }, 1000);
    </script>
    @endforeach
@endif

</body>

</html>