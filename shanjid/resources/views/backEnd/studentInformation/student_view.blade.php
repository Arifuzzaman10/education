@extends('backEnd.master')
@push('css')
<style>
.school-table-up-style tr td {
    padding: 8px 6px 8px 0px !important;
    font-size: 12px !important;
}
.school-table-style {
    padding: 0px !important;
}
</style>
@endpush

@section('title') 
@lang('student.student_details')
@endsection

@section('mainContent')

    @php
        function showTimelineDocName($data){
            $name = explode('/', $data);
            $number = count($name);
            return $name[$number-1];
        }
        function showDocumentName($data){
            $name = explode('/', $data);
            $number = count($name);
            return $name[$number-1];
        }
    @endphp
@php  $setting = app('school_info');  if(!empty($setting->currency_symbol)){ $currency = $setting->currency_symbol; }else{ $currency = '$'; }   @endphp

    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('student.student_details')</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="{{route('student_list')}}">@lang('student.student_list')</a>
                    <a href="#">@lang('student.student_details')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    @if (moduleStatusCheck('University'))
                        @includeIf('university::promote.inc.student_profile',['student_detail'=>$student_detail->defaultClass])
                    @else
                        @includeIf('backEnd.studentInformation.inc.student_profile')
                    @endif
                   
                </div>
            
               @php
                   $type = isset($type) ? $type : null;
               @endphp
 
                <!-- Start Student Details -->
                <div class="col-lg-9 student-details up_admin_visitor">
                    <ul class="nav nav-tabs tabs_scroll_nav" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{$type == '' && Session::get('studentDocuments') == '' ? 'active':''}} " href="#studentProfile" role="tab" data-toggle="tab">@lang('student.profile')</a>
                        </li>
                   
                        @if(generalSetting()->fees_status == 0)
                       
                            <li class="nav-item">
                                <a class="nav-link" href="#studentFees" role="tab" data-toggle="tab">@lang('fees.fees')</a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" href="#leaves" role="tab" data-toggle="tab">@lang('leave.leave')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#studentExam" role="tab" data-toggle="tab">@lang('exam.exam')</a>
                        </li>
                        @if (moduleStatusCheck('University'))
                            <li class="nav-item">
                                <a class="nav-link" href="#studentExamTranscript" role="tab" data-toggle="tab">@lang('university::un.transcript')</a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link {{Session::get('studentDocuments') == 'active'? 'active':''}}" href="#studentDocuments" role="tab" data-toggle="tab">@lang('student.document')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{Session::get('studentRecord') == 'active'? 'active':''}} " href="#studentRecord" role="tab" data-toggle="tab">@lang('student.record')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{$type == 'studentTimeline' ? 'active':''}} " href="#studentTimeline" role="tab" data-toggle="tab">@lang('student.timeline')</a>
                        </li>
                        @if(generalSetting()->result_type == 'mark')
                        <li class="nav-item">
                            <a class="nav-link {{$type == 'mark' ? 'active':''}} " href="#mark" role="tab" data-toggle="tab">@lang('exam.marksheet')</a>
                        </li>
                        @endif

                        @if(moduleStatusCheck('University'))
                        <li class="nav-item">
                            <a class="nav-link {{$type == 'assign_subject' ? 'active':''}} " href="#studentSubject" role="tab" data-toggle="tab">@lang('university::un.subject')</a>
                        </li>
                        @endif

                        <li class="nav-item edit-button">
                            @if(userPermission(66))
                                <a href="{{route('student_edit', [@$student_detail->id])}}"
                                class="primary-btn small fix-gr-bg">@lang('common.edit')
                                </a>
                            @endif
                        </li>
                    </ul>


                    <!-- Tab panes -->
                    <div class="tab-content">

                        <!-- Start Profile Tab -->
                            @include('backEnd.studentInformation.inc._profile_tab')
                        <!-- End Profile Tab -->

                        <!-- Start Fees Tab -->
                            @include('backEnd.studentInformation.inc._fees_tab')
                        <!-- End Fees Tab -->

                        <!-- Start leave Tab -->
                            @include('backEnd.studentInformation.inc._leave_tab')                       
                        <!-- End leave Tab -->
                        
                        <!-- Start Exam Tab -->
                            @include('backEnd.studentInformation.inc._exam_tab')
                        <!-- End Exam Tab -->

                        @if(moduleStatusCheck('University'))
                            <div role="tabpanel" class="tab-pane fade" id="studentExamTranscript">
                                @includeIf('university::exam.partials._examTabView')
                            </div>
                        @endif

                        <!-- Start Documents Tab -->
                        @include('backEnd.studentInformation.inc._document_tab')

                        <!-- Add Document modal form end-->
                        <!-- delete document modal -->

                        <!-- delete document modal -->
                        <!-- Start reocrd Tab -->
                        
                        @include('backEnd.studentInformation.inc._record_tab')

                        <!-- End record Tab -->
                        
                        @include('backEnd.studentInformation.inc._timeline_tab')
                        {{-- start marksheet tab  --}}
                        @if(generalSetting()->result_type == 'mark')
                        <div role="tabpanel" class="tab-pane fade {{Session::get('mark') == 'active'? 'show active':''}}" id="mark">
                            <div class="white-box">
                                @foreach($student_detail->studentRecords as $record)
                                    @includeIf('backend.studentInformation.inc.finalMarkSheet')
                                @endforeach
                            </div>
                        </div>
                        @endif 
                        {{-- end marksheet tab  --}}

                        <!-- Start Timeline Tab -->
                        @if(moduleStatusCheck('University'))
                            <div role="tabpanel" class="tab-pane fade {{ $type == 'assign_subject'? 'show active':''}}" id="studentSubject">
                                @include('backEnd.studentInformation.inc.subject_list')
                            </div>
                        @endif
                        <!-- End Timeline Tab -->
                    </div>
                </div>
                <!-- End Student Details -->
            </div>
        </div>
    </section>

    <!-- timeline form modal start-->
    <div class="modal fade admin-query" id="add_timeline_madal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('student.add_timeline')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_timeline_store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'document_upload']) }}
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="hidden" name="student_id" value="{{$student_detail->id}}">
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{" type="text" name="title" value="" id="title" maxlength="200">
                                            <label>@lang('student.title') <span>*</span> </label>
                                            <span class="focus-border"></span>
                                            <span class=" text-danger" role="alert" id="amount_error">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-30">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input date form-control" readonly id="startDate" type="text" name="date">
                                            <label>@lang('common.date')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-30">
                                <div class="input-effect">
                                    <textarea class="primary-input form-control" cols="0" rows="3" name="description" id="Description"></textarea>
                                    <label>@lang('common.description')<span></span> </label>
                                    <span class="focus-border textarea"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-40">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input" type="text" id="placeholderFileFourName" placeholder="Document" disabled>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_4">@lang('common.browse')</label>
                                            <input type="file" class="d-none" name="document_file_4" id="document_file_4">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-30">
                                <input type="checkbox" id="currentAddressCheck" class="common-checkbox" name="visible_to_student" value="1">
                                <label for="currentAddressCheck">@lang('student.visible_to_this_person')</label>
                            </div>

                            <div class="col-lg-12 text-center mt-40">
                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                    <button class="primary-btn fix-gr-bg submit" type="submit">@lang('common.save')</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- timeline form modal end-->
    <!-- assign class form modal start-->
    <div class="modal fade admin-query" id="assignClass">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> 
                    @if(moduleStatusCheck('University')) 
                        @lang('university::un.assign_faculty_department')
                    @else 
                        @lang('student.assign_class') 
                    @endif
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student.record.store','method' => 'POST']) }}
                      
                           
                            <input type="hidden" name="student_id" value="{{ $student_detail->id }}">
                            @if(moduleStatusCheck('University'))
                                @includeIf('university::common.session_faculty_depart_academic_semester_level',['div'=>'col-lg-12','mt' => 'mt-0', 'row'=>1, 'required' => ['USN','UF', 'UD', 'UA', 'US', 'USL'],'hide' => ['USUB']])
                            @else 
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('session') ? ' is-invalid' : '' }}" name="session" id="academic_year">
                                            <option data-display="@lang('common.academic_year') *" value="">@lang('common.academic_year') *</option>
                                            @foreach($sessions as $session)
                                            <option value="{{$session->id}}" {{old('session') == $session->id? 'selected': ''}}>{{$session->year}}[{{$session->title}}]</option>
                                            @endforeach
                                        </select>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('session'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('session') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="input-effect sm2_mb_20 md_mb_20" id="class-div">
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('class') ? ' is-invalid' : '' }}" name="class" id="classSelectStudent">
                                            <option data-display="@lang('common.class') *" value="">@lang('common.class') *</option>
                                        </select>
                                        <div class="pull-right loader loader_style" id="select_class_loader">
                                            <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                        </div>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('class'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-25">    
                                <div class="col-lg-12">
                                    <div class="input-effect sm2_mb_20 md_mb_20" id="sectionStudentDiv">
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('section') ? ' is-invalid' : '' }}" name="section" id="sectionSelectStudent">
                                           <option data-display="@lang('common.section') *" value="">@lang('common.section') *</option>
                                        </select>
                                        <div class="pull-right loader loader_style" id="select_section_loader">
                                            <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                        </div>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('section'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('section') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(generalSetting()->multiple_roll==1)
                            <div class="row mt-25">
                                <div class="col-lg-12">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <input oninput="numberCheck(this)" class="primary-input" type="text" id="roll_number" name="roll_number"  value="{{old('roll_number')}}">
                                        <label> {{ moduleStatusCheck('Lead')==true ? __('lead::lead.id_number') : __('student.roll') }}
                                             @if(is_required('roll_number')==true) <span> *</span> @endif</label>
                                        <span class="focus-border"></span>
                                        <span class="text-danger" id="roll-error" role="alert">
                                            <strong></strong>
                                        </span>
                                        @if ($errors->has('roll_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('roll_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row  mt-25">
                                <div class="col-lg-12">
                                    <label for="is_default">@lang('student.is_default')</label>
                                    <div class="d-flex radio-btn-flex mt-10">
                                        
                                        <div class="mr-30">
                                            <input type="radio" name="is_default" id="isDefaultYes" value="1" class="common-radio relationButton" >
                                            <label for="isDefaultYes">@lang('common.yes')</label>
                                        </div>
                                        <div class="mr-30">
                                            <input type="radio" name="is_default" id="isDefaultNo" value="0" class="common-radio relationButton" checked>
                                            <label for="isDefaultNo">@lang('common.no')</label>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center mt-20">
                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg"
                                            data-dismiss="modal">@lang('admin.cancel')</button>
                                    <button class="primary-btn fix-gr-bg submit" id="save_button_query"
                                            type="submit">@lang('admin.save')</button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- assign class form modal end-->

<script>
    function deleteDoc(id,doc){
        var modal = $('#delete-doc');
         modal.find('input[name=student_id]').val(id)
         modal.find('input[name=doc_id]').val(doc)
         modal.modal('show');
    }
</script>

@endsection
