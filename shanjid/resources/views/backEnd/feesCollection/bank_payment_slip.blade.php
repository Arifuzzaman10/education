@extends('backEnd.master')
@section('title') 
@lang('fees.bank_payment')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box up_breadcrumb">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('fees.bank_payment')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('fees.fees_collection')</a>
                <a href="#">@lang('fees.bank_payment')</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        
         <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="main-title mt_0_sm mt_0_md">
                        <h3 class="mb-30">@lang('common.select_criteria') </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'bank-payment-slip', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_studentA']) }}
                        @if(moduleStatusCheck('University'))
                        <div class="row">
                            @includeIf('university::common.session_faculty_depart_academic_semester_level',['required' => ['USN','UF', 'UD', 'UA', 'US', 'USL'], 'hide' => ['USUB']])
                            <div class="col-lg-3 col-md-3 mt-25">
                                <select class="niceSelect w-100 bb form-control{{ $errors->has('approve_status') ? ' is-invalid' : '' }}" name="approve_status">
                                    <option data-display="@lang('common.status')" value="">@lang('common.status')</option>
                                    <option value="0" {{isset($approve_status)? ($approve_status == 0? 'selected': ''):'' }}>@lang('common.pending')</option>
                                    <option value="1" {{isset($approve_status)? ($approve_status == 1? 'selected': ''):'' }}>@lang('common.approved')</option>
                                </select>
                                 @if ($errors->has('approve_status'))
                                <span class="invalid-feedback invalid-select" role="alert">
                                    <strong>{{ $errors->first('approve_status') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @else
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                <div class="col-lg-3 col-md-3 sm_mb_20 sm2_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                        <option data-display="@lang('common.select_class')" value="">@lang('common.select_class')</option>
                                        @foreach($classes as $class)
                                        <option value="{{$class->id}}" {{isset($class_id)? ($class_id == $class->id? 'selected': ''):'' }}>{{$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                     @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3" id="select_section_div">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                        <option data-display="@lang('common.select_section')" value="">@lang('common.select_section')</option>
                                        @if (isset($section_id))
                                            @foreach($sections as $section)
                                                <option value="{{$section->id}}" {{isset($section_id)? ($section_id == $section->id? 'selected': ''):'' }}>{{$section->section_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                    @if ($errors->has('section'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('section') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-3 col-md-3 mt-30-md">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input class="primary-input date form-control{{ $errors->has('payment_date') ? ' is-invalid' : '' }} {{isset($date)? 'read-only-input': ''}}" id="startDate" type="text"
                                                    name="payment_date" autocomplete="off" value="{{isset($date)? $date: ''}}">
                                                <label for="startDate">@lang('fees.payment_date')</label>
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
                                <div class="col-lg-3 col-md-3 sm_mb_20 sm2_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('approve_status') ? ' is-invalid' : '' }}" name="approve_status">
                                        <option data-display="@lang('common.status')" value="">@lang('common.status')</option>
                                        <option value="0" {{isset($approve_status)? ($approve_status == 0? 'selected': ''):'' }}>@lang('common.pending')</option>
                                        <option value="1" {{isset($approve_status)? ($approve_status == 1? 'selected': ''):'' }}>@lang('common.approved')</option>
                                    </select>
                                     @if ($errors->has('approve_status'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('approve_status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                            </div>
                        @endif 
                        <div class="row">
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-search pr-2"></span>
                                    @lang('common.search')
                                </button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            {{-- @if(isset($bank_slips)) --}}
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">  @lang('fees.bank_payment_list')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table " cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('student.student_name')</th>
                                        @if(moduleStatusCheck('University'))
                                        <th>@lang('university::un.installment')</th>
                                        @else
                                        <th>@lang('fees.fees_type')</th>
                                        @endif 
                                        <th>@lang('common.date')</th>
                                        <th>@lang('accounts.amount')</th>
                                        <th>@lang('accounts.bank')</th>
                                        <th>@lang('common.note')</th>
                                        <th>@lang('accounts.slip')</th>
                                        <th>@lang('common.status')</th>
                                        <th>@lang('common.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( isset($all_bank_slips))
                                    @foreach($all_bank_slips as $bank_slip)
                                    <tr>
                                        <td>{{@$bank_slip->studentInfo->full_name}}  </td>
                                        @if(moduleStatusCheck('University'))
                                         <td>{{$bank_slip->id}}</td>
                                        @else
                                        <td>{{@$bank_slip->feesType->name}}</td>
                                        @endif 
                                        <td  data-sort="{{strtotime(@$bank_slip->date)}}" >{{ !empty($bank_slip->date)? dateConvert(@$bank_slip->date):''}}</td>
                                        <td>{{generalSetting()->currency_symbol}} {{@$bank_slip->amount}}</td>
                                        <td>{{@$bank_slip->bank->bank_name}}</td>
                                        <td>{{@$bank_slip->note}}</td>
                                        
                                        <td>
                                            @if (!empty($bank_slip->slip))
                                                <a class="text-color" data-toggle="modal" data-target="#showCertificateModal{{ @$bank_slip->id}}"  href="#">@lang('common.view')</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if(@$bank_slip->approve_status== 0)
                                                <button class="primary-btn small bg-warning text-white border-0">@lang('common.pending')</button>
                                            @else
                                                <button class="primary-btn small bg-success text-white border-0  tr-bg">@lang('common.approved')</button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    @lang('common.select')
                                                </button>
                                                @if($bank_slip->approve_status == 0)
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="enableId({{$bank_slip->id}});" class="dropdown-item" href="#" data-toggle="modal" data-target="#enableStudentModal" data-id="{{$bank_slip->id}}"  >@lang('common.approve')</a>
                                                    <a onclick="rejectPayment({{$bank_slip->id}});" class="dropdown-item" href="#" data-toggle="modal" data-id="{{$bank_slip->id}}"  >@lang('accounts.reject')</a>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade admin-query" id="showCertificateModal{{ @$bank_slip->id}}">
                                        <div class="modal-dialog modal-dialog-centered large-modal">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('fees.view_slip')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body p-0 mt-30">
                                                    <div class="container student-certificate">
                                                        <div class="row justify-content-center">
                                                            <div class="col-lg-12 text-center">
                                                                @php
                                                                    $pdf = @$bank_slip->slip ? explode('.', @$bank_slip->slip) : ""." . "."";
                                                                    $for_pdf =  $pdf[1];
                                                                @endphp
                                                                @if (@$for_pdf=="pdf")
                                                                    <div class="mb-5">
                                                                        <a href="{{url(@$bank_slip->slip)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                                    </div>
                                                                @else
                                                                    <div class="mb-5">
                                                                        <img class="img-fluid" src="{{asset($bank_slip->slip)}}">
                                                                    </div>
                                                                @endif
                                                            </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    @endforeach

                                    @endif


                                    @if( isset($bank_slips))
                                    @foreach($bank_slips as $bank_slip)
                                    <tr>
                                        <td>{{@$bank_slip->studentInfo->full_name}}</td>
                                        @if(moduleStatusCheck('University'))
                                         <td>{{@$bank_slip->feesInstallment->installment->title}}</td>
                                        @else
                                        <td>{{@$bank_slip->feesType->name}}</td>
                                        @endif 
                                        <td  data-sort="{{strtotime(@$bank_slip->date)}}" >{{ !empty($bank_slip->date)? dateConvert(@$bank_slip->date):''}}</td>
                                        <td>{{generalSetting()->currency_symbol}} {{@$bank_slip->amount}}</td>
                                        <td>{{@$bank_slip->bank->bank_name}}</td>
                                        <td>{{@$bank_slip->note}}</td>
                                        
                                        <td>
                                            @if (!empty($bank_slip->slip))
                                                <a class="text-color" data-toggle="modal" data-target="#showCertificateModal{{ @$bank_slip->id}}"  href="#">@lang('common.view')</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if(@$bank_slip->approve_status== 0)
                                                <button class="primary-btn small bg-warning text-white border-0">@lang('common.pending')</button>
                                            @else
                                                <button class="primary-btn small bg-success text-white border-0  tr-bg">@lang('common.approved')</button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    @lang('common.select')
                                                </button>
                                                @if($bank_slip->approve_status == 0)
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="enableId({{$bank_slip->id}});" class="dropdown-item" href="#" data-toggle="modal" data-target="#enableStudentModal" data-id="{{$bank_slip->id}}"  >@lang('common.approve')</a>
                                                    <a onclick="rejectPayment({{$bank_slip->id}});" class="dropdown-item" href="#" data-toggle="modal" data-id="{{$bank_slip->id}}"  >@lang('accounts.reject')</a>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade admin-query" id="showCertificateModal{{ @$bank_slip->id}}">
                                        <div class="modal-dialog modal-dialog-centered large-modal">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('fees.view_slip')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body p-0 mt-30">
                                                    <div class="container student-certificate">
                                                        <div class="row justify-content-center">
                                                            <div class="col-lg-12 text-center">
                                                                @php
                                                                    $pdf = @$bank_slip->slip ? explode('.', @$bank_slip->slip) : ""." . "."";
                                                                    $for_pdf =  $pdf[1];
                                                                @endphp
                                                                @if (@$for_pdf=="pdf")
                                                                    <div class="mb-5">
                                                                        <a href="{{url(@$bank_slip->slip)}}" download>@lang('common.download') <span class="pl ti-download"></span></a>
                                                                    </div>
                                                                @else
                                                                    <div class="mb-5">
                                                                        <img class="img-fluid" src="{{asset($bank_slip->slip)}}">
                                                                    </div>
                                                                @endif
                                                            </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    @endforeach

                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}

        {{-- </div> --}}
    </div>
</section>

<div class="modal fade admin-query" id="enableStudentModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('fees.approve_payment')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('fees.are_you_sure_to_approve')</h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                     {{ Form::open(['route' => 'approve-fees-payment', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                  
                     <input type="hidden" name="class" value="{{@$class_id}}">
                     <input type="hidden" name="section" value="{{@$section_id}}">
                     <input type="hidden" name="payment_date" value="{{@$date}}">
                     <input type="hidden" name="id" value="" id="student_enable_i">
                    <button class="primary-btn fix-gr-bg" type="submit">@lang('fees.approve')</button>
                     {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</div>


<!-- modal start here  -->

<div class="modal fade admin-query" id="rejectPaymentModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('fees.bank_payment_reject') </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                        <h4>@lang('fees.are_you_sure_to_reject')</h4>
                    </div>
              {{ Form::open(['route' => 'reject-fees-payment', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                <div class="form-group">
                    <input type="hidden" name="id" id="showId">
                    <label><strong>@lang('fees.reject_note')</strong></label>
                    <textarea name="payment_reject_reason" class="form-control" rows="6"></textarea>
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
                <h4 class="modal-title">@lang('fees.reject_note')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>@lang('fees.reject_note')</strong></label>
                    <textarea readonly class="form-control" rows="4"></textarea>
                </div>
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn fix-gr-bg" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@if(! isset($all_bank_slips))
@section('script')  
@include('backEnd.partials.server_side_datatable')
<script>
//
// DataTables initialisation
//
$(document).ready(function() {
   $('.data-table').DataTable({
                 processing: true,
                 serverSide: true,
                 "ajax": $.fn.dataTable.pipeline( {
                       url: "{{url('bank-payment-slip-ajax')}}",
                       data: { 
                            academic_year: $('#academic_id').val(), 
                            class: $('#class').val(), 
                            section: $('#section').val(), 
                            roll_no: $('#roll').val(), 
                            name: $('#name').val()
                        },
                       pages: "{{generalSetting()->ss_page_load}}" // number of pages to cache
                       
                   } ),
                   columns: [
                       {data: 'student_info.full_name', name: 'student_name'},
                       {data: 'fees_type.name', name: 'fees_type'},
                       {data: 'date', name: 'date'},
                       {data: 'amount', name: 'amount'},
                       {data: 'note', name: 'note'},
                       {data: 'slip', name: 'slip'},
                       {data: 'status', name: 'status'},
                       {data: 'action', name: 'action',orderable: false, searchable: true},
                       
                    ],
                    bLengthChange: false,
                    bDestroy: true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: window.jsLang('quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>",
                        },
                    },
                    dom: "Bfrtip",
                    buttons: [{
                        extend: "copyHtml5",
                        text: '<i class="fa fa-files-o"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: window.jsLang('copy_table'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "excelHtml5",
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: window.jsLang('export_to_excel'),
                        title: $("#logo_title").val(),
                        margin: [10, 10, 10, 0],
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "csvHtml5",
                        text: '<i class="fa fa-file-text-o"></i>',
                        titleAttr: window.jsLang('export_to_csv'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: window.jsLang('export_to_pdf'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                        orientation: "landscape",
                        pageSize: "A4",
                        margin: [0, 0, 0, 12],
                        alignment: "center",
                        header: true,
                        customize: function(doc) {
                            doc.content[1].margin = [100, 0, 100, 0]; //left, top, right, bottom
                            doc.content.splice(1, 0, {
                                margin: [0, 0, 0, 12],
                                alignment: "center",
                                image: "data:image/png;base64," + $("#logo_img").val(),
                            });
                        },
                    },
                    {
                        extend: "print",
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: window.jsLang('print'),
                        title: $("#logo_title").val(),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "colvis",
                        text: '<i class="fa fa-columns"></i>',
                        postfixButtons: ["colvisRestore"],
                    },
                ],
                columnDefs: [{
                    visible: false,
                }, ],
                responsive: true,
            });
        } );
        </script>
@endsection
@endif
@push('script')
    <script>
        function rejectPayment(id){
            var modal = $('#rejectPaymentModal');
            modal.find('#showId').val(id)
            modal.modal('show');

        }
        function viewReason(id){
            var reason = $('.reason'+ id).data('reason');
            var modal = $('#showReasonModal');
            modal.find('textarea').val(reason)
            modal.modal('show');
        }
    </script>
@endpush