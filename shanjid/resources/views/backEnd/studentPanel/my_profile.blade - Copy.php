@extends('backEnd.master')
    @section('title')
        @lang('student.my_profile')
    @endsection
@section('mainContent')
@push('css')
<style>
    .student-details .nav-tabs {
        margin-left: 10px;
    }
</style>
@endpush

<section class="student-details">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-3 mb-30">
                <!-- Start Student Meta Information -->
                <div class="main-title">
                    <h3 class="mb-20">@lang('student.my_profile') </h3>
                </div>
                <div class="student-meta-box">
                    <div class="student-meta-top"></div>
                    <img class="student-meta-img img-100" src="{{file_exists(@$student_detail->student_photo) ? asset($student_detail->student_photo) : asset('public/uploads/staff/demo/staff.jpg') }}" alt="">
                    <div class="white-box radius-t-y-0">
                        <div class="single-meta mt-10">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    @lang('student.student_name')
                                </div>
                                <div class="value">
                                    {{@$student_detail->first_name.' '.@$student_detail->last_name}}
                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    @lang('student.admission_number')
                                </div>
                                <div class="value">
                                    {{@$student_detail->admission_no}}
                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    @lang('student.roll_number')
                                </div>
                                <div class="value">
                                     {{@$student_detail->roll_no}}
                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    Class
                                </div>
                                <div class="value">
                                   {{@$student_detail->class != ""? @$student_detail->class->class_name:''}} ({{@$student_detail->session_id != ""? @$academic_year->year:''}})
                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    @lang('common.section')
                                </div>
                                <div class="value">
                                    {{@$student_detail->section != ""? @$student_detail->section->section_name:""}}
                                </div>
                            </div>
                        </div>
                        <div class="single-meta">
                            <div class="d-flex justify-content-between">
                                <div class="name">
                                    @lang('common.gender') 
                                </div>
                                <div class="value">
                                    {{@$student_detail->gender!= ""? @$student_detail->gender->base_setup_name:""}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Student Meta Information -->

                <!-- Start Siblings Meta Information -->
                <div class="main-title mt-40">
                    <h3 class="mb-20">@lang('student.sibling_information') </h3>
                </div>
                @foreach($siblings as $sibling)
                    @if(@$sibling->id != @$student_detail->id)
                    <div class="student-meta-box mb-20">
                        <div class="student-meta-top siblings-meta-top"></div>
                        <img class="student-meta-img img-100" src="{{asset(@$sibling->student_photo)}}" alt="">
                        <div class="white-box radius-t-y-0">
                            <div class="single-meta mt-10">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('student.sibling_name')
                                    </div>
                                    <div class="value">
                                        {{@$sibling->full_name}}
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('student.admission_number') 
                                    </div>
                                    <div class="value">
                                        {{@$sibling->admission_no}}
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('student.roll_number') 
                                    </div>
                                    <div class="value">
                                        {{@$sibling->roll_no}}
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('common.class')
                                    </div>
                                    <div class="value">
                                    {{@$sibling->class !=""?@$sibling->class->class_name:""}}
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('common.section') 
                                    </div>
                                    <div class="value">
                                        {{@$sibling->section !=""?@$sibling->section->section_name:""}}
                                    </div>
                                </div>
                            </div>
                            <div class="single-meta">
                                <div class="d-flex justify-content-between">
                                    <div class="name">
                                        @lang('common.gender') 
                                    </div>
                                    <div class="value">
                                        {{@$sibling->gender !=""?@$sibling->gender->base_setup_name:""}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                <!-- End Siblings Meta Information -->
            </div>

            <!-- Start Student Details -->
            <div class="col-lg-9">
                <ul class="nav nav-tabs tabs_scroll_nav" role="tablist">
                    @if(userPermission(12))
                        <li class="nav-item">
                            <a class="nav-link @if (Session::get('studentDocuments') != 'active' && Session::get('studentTimeline') != 'active') active @endif" href="#studentProfile" role="tab" data-toggle="tab"> @lang('student.profile') </a>
                        </li>
                    @endif
                    @if(generalSetting()->fees_status == 0)
                        @if(userPermission(13))
                            <li class="nav-item">
                                <a class="nav-link" href="#studentFees" role="tab" data-toggle="tab">@lang('fees.fees')</a>
                            </li>
                        @endif
                    @endif
                    @if(userPermission(40))
                        <li class="nav-item">
                            <a class="nav-link" href="#leaves" role="tab" data-toggle="tab">@lang('leave.leave')</a>
                        </li>
                    @endif
                    @if(userPermission(14))
                        <li class="nav-item">
                            <a class="nav-link" href="#studentExam" role="tab" data-toggle="tab">@lang('exam.exam')</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="#studentOnlineExam" role="tab" data-toggle="tab">@lang('exam.online_exam')</a>
                    </li>
                    @if(userPermission(15))
                        <li class="nav-item">
                            <a class="nav-link {{Session::get('studentDocuments') == 'active'? 'active':''}}" href="#studentDocuments" role="tab" data-toggle="tab">@lang('student.documents')</a>
                        </li>
                    @endif
                    @if(userPermission(19))
                        <li class="nav-item">
                            <a class="nav-link {{Session::get('studentTimeline') == 'active'? 'active':''}} " href="#studentTimeline" role="tab" data-toggle="tab">@lang('student.timeline')</a>
                        </li>
                    @endif

                    @if(moduleStatusCheck('Wallet'))
                        @if (userPermission(1124))
                            <li class="nav-item">
                                <a class="nav-link {{Session::get('studentWallet') == 'active'? 'active':''}} " href="#studentWallet" role="tab" data-toggle="tab"> @lang('wallet::wallet.wallet')</a>
                            </li>
                        @endif
                    @endif


                    <li class="nav-item edit-button">
                	    <a href="{{route('update-my-profile',$student_detail->id)}}" class="primary-btn small fix-gr-bg pull-right">@lang('common.edit')</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Start Profile Tab -->
                        <div role="tabpanel" class="tab-pane fade @if (Session::get('studentDocuments') != 'active' && Session::get('studentTimeline') != 'active') show active @endif" id="studentProfile">
                            <div class="white-box">
                                <h4 class="stu-sub-head">@lang('student.personal_info')</h4>
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('student.admission_date')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">                                                                                
                                            {{@$student_detail->admission_date != ""? dateConvert(@$student_detail->admission_date):''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('common.date_of_birth')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">                                                                                        
                                                {{@$student_detail->date_of_birth != ""? dateConvert(@$student_detail->date_of_birth):''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('common.type')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{@$student_detail->category != ""? @$student_detail->category->catgeory_name:""}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('student.religion') 
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{@$student_detail->religion != ""? @$student_detail->religion->base_setup_name:""}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('common.phone_number') 
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{@$student_detail->mobile}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                    @lang('common.email_address') 
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{@$student_detail->email}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('student.present_address')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{@$student_detail->current_address}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="">
                                                @lang('student.permanent_address')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-7">
                                            <div class="">
                                                {{@$student_detail->permanent_address}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Start Parent Part -->
                                <h4 class="stu-sub-head mt-40">@lang('student.parent_/_guardian_details')</h4>
                                <div class="d-flex">
                                    <div class="mr-20 mt-20">
                                        <img class="student-meta-img img-100" src="{{@$student_detail->parents != ""? asset(@$student_detail->parents->fathers_photo):""}}" alt="">
                                    </div>
                                    <div class="w-100">
                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('student.father_name')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""? @$student_detail->parents->fathers_name:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('student.occupation')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""? @$student_detail->parents->fathers_occupation:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('common.phone_number')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""? @$student_detail->parents->fathers_mobile:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <div class="mr-20 mt-20">
                                        <img class="student-meta-img img-100" src="{{@$student_detail->parents != ""? asset(@$student_detail->parents->mothers_photo):""}}" alt="">
                                    </div>
                                    <div class="w-100">
                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('student.mother_name')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""? @$student_detail->parents->mothers_name:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                            @lang('student.occupation')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""?@$student_detail->parents->mothers_occupation:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                            @lang('common.phone_number')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""?@$student_detail->parents->mothers_mobile:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <div class="mr-20 mt-20">
                                        <img class="student-meta-img img-100" src="{{@$student_detail->parents != ""?asset(@$student_detail->parents->guardians_photo):""}}" alt="">
                                    </div>
                                    <div class="w-100">
                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('student.guardian_name')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""?@$student_detail->parents->guardians_mobile:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('common.email_address')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""?@$student_detail->parents->guardians_email:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('common.phone_number')
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""?@$student_detail->parents->guardians_phone:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('student.relation_with_guardian') 
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""?@$student_detail->parents->guardians_relation:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('student.occupation') 
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""?@$student_detail->parents->guardians_occupation:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="single-info">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="">
                                                        @lang('student.guardian_address') 
                                                    </div>
                                                </div>

                                                <div class="col-lg-8 col-md-7">
                                                    <div class="">
                                                        {{@$student_detail->parents != ""?@$student_detail->parents->guardians_address:""}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Parent Part -->

                                <!-- Start Transport Part -->
                                <h4 class="stu-sub-head mt-40">@lang('student.transport_and_dormitory_details')</h4>
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('common.route')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{@$student_detail->route != ""? @$student_detail->route->title: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('transport.vehicle_number')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{@$student_detail->vehicle != ""? @$student_detail->vehicle->vehicle_no: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('transport.driver_name')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{@$student_detail->vehicle != ""? @$driver->full_name: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('transport.driver_phone_number')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{@$student_detail->vehicle != ""? @$driver->mobile: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('dormitory.dormitory_name')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{@$student_detail->dormitory != ""? @$student_detail->dormitory->dormitory_name: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Transport Part -->

                                <!-- Start Other Information Part -->
                                <h4 class="stu-sub-head mt-40">@lang('student.information_other')</h4>
                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('student.blood_group')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{@$student_detail->bloodGroup != ""? @$student_detail->bloodGroup->base_setup_name: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('student.height')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->height)? @$student_detail->height: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('student.weight')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->weight)? @$student_detail->weight: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('student.previous_school_details')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->previous_school_details)? @$student_detail->previous_school_details: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('student.national_identification_number')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->national_id_no)? @$student_detail->national_id_no: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('student.local_identification_number')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->local_id_no)? @$student_detail->local_id_no: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('accounts.bank_account_number')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->bank_account_no)? @$student_detail->bank_account_no: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('accounts.bank_name')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->bank_name)? @$student_detail->bank_name: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="single-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-md-5">
                                            <div class="">
                                                @lang('student.ifsc_code')
                                            </div>
                                        </div>

                                        <div class="col-lg-7 col-md-6">
                                            <div class="">
                                                {{isset($student_detail->ifsc_code)? @$student_detail->ifsc_code: ''}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Custom field start --}}
                                    @include('backEnd.customField._coutom_field_show')
                                {{-- Custom field end --}}
                                <!-- End Other Information Part -->
                            </div>
                        </div>
                    <!-- End Profile Tab -->

                    <!-- Start Fees Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="studentFees">
                            <div class="table-responsive">
                                <table  class="display school-table school-table-style table_not_fixed" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th> @lang('fees.fees_group')</th>
                                        <th>@lang('fees.fees_code')</th>
                                        <th>@lang('fees.due_date')</th>
                                        <th>@lang('common.status')</th>
                                        <th>@lang('fees.amount') ({{generalSetting()->currency_symbol}})</th>
                                        <th>@lang('fees.payment_id')</th>
                                        <th>@lang('fees.mode')</th>
                                        <th>@lang('common.date')</th>
                                        <th>@lang('fees.discount') ({{generalSetting()->currency_symbol}})</th>
                                        <th>@lang('fees.fine')({{generalSetting()->currency_symbol}})</th>
                                        <th>@lang('fees.paid') ({{generalSetting()->currency_symbol}})</th>
                                        <th>@lang('fees.balance')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        @$grand_total = 0;
                                        @$total_fine = 0;
                                        @$total_discount = 0;
                                        @$total_paid = 0;
                                        @$total_grand_paid = 0;
                                        @$total_balance = 0;
                                    @endphp
                                    @foreach($fees_assigneds as $fees_assigned)
                                        @php
                                            @$grand_total += @$fees_assigned->feesGroupMaster->amount;
                                        
                                            
                                        @endphp

                                        @php
                                            @$discount_amount = $fees_assigned->applied_discount;
                                            @$total_discount += @$discount_amount;
                                            @$student_id = @$fees_assigned->student_id;
                                        @endphp
                                        @php
                                            @$paid = App\SmFeesAssign::discountSum(@$fees_assigned->student_id, @$fees_assigned->feesGroupMaster->feesTypes->id, 'amount');
                                            @$total_grand_paid += @$paid;
                                        @endphp
                                        @php
                                            @$fine = App\SmFeesAssign::discountSum(@$fees_assigned->student_id, @$fees_assigned->feesGroupMaster->feesTypes->id, 'fine');
                                            @$total_fine += @$fine;
                                        @endphp
                                            
                                        @php
                                            @$total_paid = @$discount_amount + @$paid;
                                        @endphp
                                    <tr>
                                        <td>{{@$fees_assigned->feesGroupMaster->feesGroups !=""?@$fees_assigned->feesGroupMaster->feesGroups->name:""}}</td>
                                        <td>{{@$fees_assigned->feesGroupMaster->feesTypes!=""?@$fees_assigned->feesGroupMaster->feesTypes->name:""}}</td>
                                        <td>
                                            @if(!empty(@$fees_assigned->feesGroupMaster))                                                                            
                                            {{@$fees_assigned->feesGroupMaster->date != ""? dateConvert(@$fees_assigned->feesGroupMaster->date):''}}
                                            @endif
                                        </td>
                                        @php
                                        $total_payable_amount=$fees_assigned->fees_amount;
                                            $rest_amount = $fees_assigned->feesGroupMaster->amount - $total_paid;
                                            $balance_amount=number_format($rest_amount+$fine, 2, '.', '');
                                            $total_balance +=  $balance_amount;
                                    @endphp
                                    <td>
                                        
                                        @if($balance_amount ==0)
                                            <button class="primary-btn small bg-success text-white border-0">@lang('fees.paid')</button>
                                        @elseif($paid != 0)
                                            <button class="primary-btn small bg-warning text-white border-0">@lang('fees.partial')</button>
                                        @elseif($paid == 0)
                                            <button class="primary-btn small bg-danger text-white border-0">@lang('fees.unpaid')</button>
                                        @endif
                                        
                                    </td>
                                        <td>
                                            @php
                                            echo number_format($fees_assigned->feesGroupMaster->amount, 2, '.', '');
                                        @endphp
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> {{@$discount_amount}} </td>
                                        <td>{{@$fine}}</td>
                                        <td>{{@$paid}}</td>
                                        <td>
                                            @php 
                                                echo @$balance_amount;
                                            @endphp
                                        </td>
                                    </tr>
                                        @php 
                                            @$payments = App\SmFeesAssign::feesPayment(@$fees_assigned->feesGroupMaster->feesTypes->id, @$fees_assigned->student_id);
                                            $i = 0;
                                        @endphp

                                        @foreach($payments as $payment)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><img src="{{asset('public/backEnd/img/table-arrow.png')}}"></td>
                                            <td>
                                                @php
                                                    @$created_by = App\User::find(@$payment->created_by);
                                                @endphp
                                                @if(@$created_by != "")
                                                <a href="#" data-toggle="tooltip" data-placement="right" title="{{'Collected By: '.@$created_by->full_name}}">{{@$payment->fees_type_id.'/'.@$payment->id}}</a></td>
                                                @endif
                                            <td>
                                                {{$payment->payment_mode}}
                                            </td>
                                            <td class="nowrap">                                                                                
                                            {{@$payment->payment_date != ""? dateConvert(@$payment->payment_date):''}}
                                            </td>
                                            <td>
                                                {{@$payment->discount_amount}}
                                            </td>
                                            <td>
                                                {{@$payment->fine}}
                                                @if($payment->fine!=0)
                                                @if (strlen($payment->fine_title) > 14)
                                                <spna class="text-danger nowrap" title="{{$payment->fine_title}}">
                                                    ({{substr($payment->fine_title, 0, 15) . '...'}})
                                                </spna>
                                                @else
                                                @if ($payment->fine_title=='')
                                                {{$payment->fine_title}}
                                                @else
                                                <spna class="text-danger nowrap">
                                                    ({{$payment->fine_title}})
                                                </spna>
                                                @endif
                                                @endif
                                                @endif
                                            </td>
                                            <td>
                                                {{@$payment->amount}}
                                            </td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>@lang('fees.grand_total') ({{@generalSetting()->currency_symbol}})</th>
                                        <th></th>
                                        <th>{{@$grand_total}}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{@$total_discount}}</th>
                                        <th>{{@$total_fine}}</th>
                                        <th>{{@$total_grand_paid}}</th>
                                        <th>{{number_format($total_balance, 2, '.', '')}} </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                        </div>
                    <!-- End Profile Tab -->
                    <!-- Start leave Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="leaves">
                            <div class="white-box">
                                <div class="row mt-30">
                                    <div class="col-lg-12">
                                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>@lang('leave.leave_type')</th>
                                                    <th>@lang('leave.leave_from') </th>
                                                    <th>@lang('leave.leave_to')</th>
                                                    <th>@lang('leave.apply_date')</th>
                                                    <th>@lang('common.status')</th>
                                                    <th>@lang('common.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $diff = ''; @endphp
                                                @if(count($leave_details)>0)
                                                @foreach($leave_details as $value)
                                                <tr>
                                                    <td>{{@$value->leaveType->type}}</td>
                                                    <td>{{$value->leave_from != ""? dateConvert($value->leave_from):''}}</td>
                                                    <td>{{$value->leave_to != ""? dateConvert($value->leave_to):''}}</td>
                                                    <td>{{$value->apply_date != ""? dateConvert($value->apply_date):''}}</td>
                                                    <td>
                                                        @if($value->approve_status == 'P')
                                                        <button class="primary-btn small bg-warning text-white border-0"> @lang('common.pending')</button>
                                                        @endif

                                                        @if($value->approve_status == 'A')
                                                        <button class="primary-btn small bg-success text-white border-0"> @lang('common.approved')</button>
                                                        @endif

                                                        @if($value->approve_status == 'C')
                                                        <button class="primary-btn small bg-danger text-white border-0"> @lang('common.cancelled')</button>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <a class="modalLink" data-modal-size="modal-md" title="@lang('common.view_leave_details')" href="{{url('view-leave-details-apply', $value->id)}}"><button class="primary-btn small tr-bg"> @lang('common.view') </button></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else 
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>@lang('leave.not_leaves_data')</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @endif 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- End leave Tab -->
                    
                    <!-- Start Exam Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="studentExam">
                            @php
                                $today = date('Y-m-d H:i:s');
                                $exam_count= count($exam_terms); 
                            @endphp
                            @if($exam_count > 1)
                            <div class="white-box no-search no-paginate no-table-info mb-2">
                            <table class="display school-table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>
                                                @lang('common.subject')
                                            </th>
                                            <th>
                                                @lang('exam.full_marks')
                                            </th>
                                            <th>
                                                @lang('exam.passing_marks')
                                            </th>
                                            <th>
                                                @lang('exam.obtained_marks')
                                            </th>
                                            <th>
                                                @lang('exam.results')
                                            </th>
                                        </tr>
                                    </thead>
                            </table>
                            </div>
                            @endif
                            <div class="white-box no-search no-paginate no-table-info mb-2">
                                @foreach($exam_terms as $exam)
                                @php
                                    $get_results = App\SmStudent::getExamResult(@$exam->id, @$student_detail);
                                @endphp
                                @if($get_results)
                                <div class="main-title">
                                    <h3 class="mb-0">{{@$exam->title}}</h3>
                                </div>
                                @php
                                    $grand_total = 0;
                                    $grand_total_marks = 0;
                                    $result = 0;
                                    $temp_grade=[];
                                    $total_gpa_point = 0;
                                    $total_subject = count($get_results);
                                    $optional_subject = 0;
                                    $optional_gpa = 0;
                                @endphp
                                    @isset($exam->examSettings->publish_date)
                                        @if($exam->examSettings->publish_date <=  $today)
                                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            @lang('common.date')
                                                        </th>
                                                        <th>
                                                            @lang('exam.subject_full_marks'))
                                                        </th>
                                                        <th>
                                                            @lang('exam.obtained_marks')
                                                        </th>
                                                        <th>
                                                            @lang('exam.grade')
                                                        </th>
                                                        <th>
                                                            @lang('exam.gpa')
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($get_results as $mark)
                                                    @php
                                                        if((!is_null($optional_subject_setup)) && (!is_null($student_optional_subject))){
                                                            if($mark->subject_id != @$student_optional_subject->subject_id){
                                                                $temp_grade[]=$mark->total_gpa_grade;
                                                            }
                                                        }else{
                                                            $temp_grade[]=$mark->total_gpa_grade;
                                                        }
                                                        $total_gpa_point += $mark->total_gpa_point;
                                                        if(! is_null(@$student_optional_subject)){
                                                            if(@$student_optional_subject->subject_id == $mark->subject->id && $mark->total_gpa_point  < @$optional_subject_setup->gpa_above ){
                                                                $total_gpa_point = $total_gpa_point - $mark->total_gpa_point;
                                                            }
                                                        }
                                                        $temp_gpa[]=$mark->total_gpa_point;
                                                        $get_subject_marks =  subjectFullMark ($mark->exam_type_id, $mark->subject_id );
                                                        
                                                        $subject_marks = App\SmStudent::fullMarksBySubject($exam->id, $mark->subject_id);
                                                        $schedule_by_subject = App\SmStudent::scheduleBySubject($exam->id, $mark->subject_id, @$student_detail);
                                                        $result_subject = 0;
                                                        $grand_total_marks += $get_subject_marks;
                                                        if(@$mark->is_absent == 0){
                                                            $grand_total += @$mark->total_marks;
                                                            if($mark->marks < $subject_marks->pass_mark){
                                                                $result_subject++;
                                                                $result++;
                                                            }
                                                        }else{
                                                            $result_subject++;
                                                            $result++;
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            {{ !empty($schedule_by_subject->date)? dateConvert($schedule_by_subject->date):''}}
                                                        </td>
                                                        <td>
                                                            {{@$mark->subject->subject_name}} ({{ @subjectFullMark($mark->exam_type_id, $mark->subject_id )}})
                                                            {{-- @if (@$optional_subject_setup!='' && @$student_optional_subject!='')
                                                                @if ($student_optional_subject->subject_id==$mark->subject->id)
                                                                    <small>(@lang('common.optional'))</small>
                                                                @endif
                                                            @endif --}}
                                                        </td>
                                                        <td>
                                                            {{@$mark->total_marks}}
                                                        </td>
                                                        <td>
                                                            {{@$mark->total_gpa_grade}}
                                                        </td>
                                                        <td>
                                                            {{number_format(@$mark->total_gpa_point, 2, '.', '')}}
                                                            {{-- @php
                                                                if (@$student_optional_subject!='') {
                                                                    
                                                                    if (@$student_optional_subject->subject_id == $mark->subject->id) {
                                                                
                                                                        $optional_subject = 1;
                                                                    if ($mark->total_gpa_point > @$optional_subject_setup->gpa_above) {
                                                                        $optional_gpa = @$optional_subject_setup->gpa_above;
                                                                    echo "GPA Above ".@$optional_subject_setup->gpa_above;
                                                                    echo "<hr>";
                                                                    echo $mark->total_gpa_point  - @$optional_subject_setup->gpa_above;
                                                                    } else {
                                                                        echo "GPA Above ".@$optional_subject_setup->gpa_above;
                                                                        echo "<hr>";
                                                                        echo "0";
                                                                    }
                                                                }
                                                            }
                                                            @endphp --}}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                
                                                </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>
                                                            @lang('exam.grand_total'): {{$grand_total}}/{{$grand_total_marks}}
                                                        </th>
                                                        <th>@lang('exam.grade'): 
                                                        @php
                                                            if(in_array($failgpaname->grade_name,$temp_grade)){
                                                                echo $failgpaname->grade_name;
                                                                }else {
                                                                    $final_gpa_point = ($total_gpa_point- $optional_gpa) /  ($total_subject - $optional_subject);
                                                                    $average_grade=0;
                                                                    $average_grade_max=0;
                                                                    if($result == 0 && $grand_total_marks != 0){
                                                                        $gpa_point=number_format($final_gpa_point, 2, '.', '');
                                                                        if($gpa_point >= $maxgpa){
                                                                            $average_grade_max = App\SmMarksGrade::where('school_id',Auth::user()->school_id)
                                                                            ->where('academic_id', getAcademicId() )
                                                                            ->where('from', '<=', $maxgpa )
                                                                            ->where('up', '>=', $maxgpa )
                                                                            ->first('grade_name');

                                                                            echo  @$average_grade_max->grade_name;
                                                                        } else {
                                                                            $average_grade = App\SmMarksGrade::where('school_id',Auth::user()->school_id)
                                                                            ->where('academic_id', getAcademicId() )
                                                                            ->where('from', '<=', $final_gpa_point )
                                                                            ->where('up', '>=', $final_gpa_point )
                                                                            ->first('grade_name');
                                                                            echo  @$average_grade->grade_name;  
                                                                        }
                                                                }else{
                                                                    echo $failgpaname->grade_name;
                                                                }
                                                            }
                                                            @endphp
                                                        </th>
                                                        <th> 
                                                            @lang('exam.gpa')
                                                            @php
                                                                $final_gpa_point = 0;
                                                                $final_gpa_point = ($total_gpa_point - $optional_gpa)/  ($total_subject - $optional_subject);
                                                                $float_final_gpa_point=number_format($final_gpa_point,2);
                                                                if($float_final_gpa_point >= $maxgpa){
                                                                    echo $maxgpa;
                                                                }else {
                                                                    echo $float_final_gpa_point;
                                                                }
                                                            @endphp
                                                        </th>
                                                    </tr>
                                                    </tfoot>
                                            </table>
                                        @endif
                                    @endisset
                                @endif
                                @endforeach
                            </div>
                        </div>
                    <!-- End Exam Tab -->

                    <!-- Start Online Exam Tab -->
                        <div role="tabpanel" class="tab-pane fade" id="studentOnlineExam">
                            @php
                                $exam_count= count($exam_terms); 
                            @endphp
                            @if($result_views->count()<1)
                                <div class="white-box no-search no-paginate no-table-info mb-2">
                                <table class="display school-table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>@lang('common.title')</th>
                                                <th>@lang('common.time')</th>
                                                <th>@lang('exam.total_marks')</th>
                                                <th>@lang('exam.obtained_marks') </th>
                                                <th>@lang('reports.result')</th>
                                                <th>@lang('common.status')</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                </table>
                                </div>
                            @endif

                            <div class="white-box no-search no-paginate no-table-info mb-2">
                                @if ($result_views->count()<1)
                                    <h4 class="text-center">@lang('exam.result_not_publish_yet')</h4>
                                @endif
                                {{-- @foreach($result_views as $exam) --}}
                                <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                                    <thead> 
                                        <tr>
                                            <th>@lang('common.title')</th>
                                            <th>@lang('common.time')</th>
                                            <th>@lang('exam.total_marks')</th>
                                            <th>@lang('exam.obtained_marks') </th>
                                            <th>@lang('reports.result')</th>
                                            <th>@lang('common.status')</th>
                                        </tr>
                                    </thead>
        
                                    <tbody>
                                        @foreach($result_views as $result_view)
                                        
                                            <tr>
                                                <td>{{$result_view->onlineExam !=""?@$result_view->onlineExam->title:""}}</td>
                                                <td  data-sort="{{strtotime(@$result_view->onlineExam->date)}}" >
                                                    @if(!empty(@$result_view->onlineExam))
                                                    {{@$result_view->onlineExam->date != ""? dateConvert(@$result_view->onlineExam->date):''}}
        
        
                                                        <br> @lang('common.time'): {{@$result_view->onlineExam->start_time.' - '.@$result_view->onlineExam->end_time}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php 
                                                    $total_marks = 0;
                                                    foreach($result_view->onlineExam->assignQuestions as $assignQuestion){
                                                        @$total_marks = $total_marks + @$assignQuestion->questionBank->marks;
                                                    }
                                                    echo @$total_marks;
                                                    @endphp
                                                </td>
                                                <td>{{@$result_view->total_marks}}</td>
                                                <td>
                                                    @php
                                                        @$result = @$result_view->total_marks * 100 / @$total_marks;
                                                        if(@$result >= @$result_view->onlineExam->percentage){
                                                            echo "Pass";  
                                                        }else{
                                                            echo "Fail";
                                                        }
                                                    @endphp
                                                </td>
                                                
                                                <td>
                                                @php
                                                    $startTime = strtotime($result_view->onlineExam->date . ' ' . $result_view->onlineExam->start_time);
                                                    $endTime = strtotime($result_view->onlineExam->date . ' ' . $result_view->onlineExam->end_time);
                                                    $now = date('h:i:s');
                                                    $now =  strtotime("now");
                                                @endphp
                                                @if($now >= $endTime)
                                                <a class="btn btn-success modalLink" data-modal-size="modal-lg" title="Answer Script"  href="{{route('student_answer_script', [@$result_view->online_exam_id, @$result_view->student_id])}}" >@lang('exam.answer_script')</a>
                                                        
                                                @else
                                                    <span class="btn primary-btn small  fix-gr-bg" style="background:blue">@lang('exam.Wait_Till_Exam_Finish')</span>
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- @endforeach --}}
                            </div>
                        </div>
                    <!-- End Online Exam Tab -->
                  
                    <!-- Start Documents Tab -->
                        <div role="tabpanel" class="tab-pane fade {{Session::get('studentDocuments') == 'active'? 'show active':''}}" id="studentDocuments">
                            <div class="white-box">
                                <div class="text-right mb-20">
                                    @if(userPermission(16))
                                        <button type="button" data-toggle="modal" data-target="#add_document_madal" class="primary-btn tr-bg text-uppercase bord-rad">
                                            @lang('student.upload_document')
                                            <span class="pl ti-upload"></span>
                                        </button>
                                    @endif
                                </div>
                                <table id="" class="table simple-table table-responsive school-table" cellspacing="0">
                                    <thead class="d-block">
                                        <tr class="d-flex">
                                            <th class="col-2">@lang('student.document_title')</th>
                                            <th class="col-6">@lang('common.name')</th>
                                            <th class="col-4">@lang('common.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="d-block">
                                        @if($student_detail->document_file_1 != "")
                                        <tr class="d-flex">
                                            <td class="col-2">{{$student_detail->document_title_1}} </td>
                                            <td class="col-6">{{showDocument(@$student_detail->document_file_1)}}</td>
                                            <td class="col-4 d-flex align-items-center">
                                                @if(userPermission(17))
                                                    <button class="primary-btn tr-bg text-uppercase bord-rad">
                                                        <a href="{{asset($student_detail->document_file_1)}}" download>@lang('common.download')</a>
                                                        <span class="pl ti-download"></span>
                                                    </button>
                                                @endif
                                                @if(userPermission(18))
                                                <a class="primary-btn icon-only fix-gr-bg" onclick="deleteDoc({{$student_detail->id}},1)" data-id="1"  href="#">
                                                        <span class="ti-trash"></span>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @if($student_detail->document_file_2 != "")
                                        <tr class="d-flex">
                                            <td class="col-2">{{$student_detail->document_title_2}}</td>
                                            <td class="col-6">{{showDocument(@$student_detail->document_file_2)}}</td>
                                            <td class="col-4 d-flex align-items-center">
                                                @if(userPermission(17))
                                                    <button class="primary-btn tr-bg text-uppercase bord-rad mr-1">
                                                        <a href="{{asset($student_detail->document_file_2)}}" download>@lang('common.download')</a>
                                                        <span class="pl ti-download"></span>
                                                    </button>
                                                @endif
                                                @if(userPermission(18))
                                                    <a class="primary-btn icon-only fix-gr-bg" onclick="deleteDoc({{$student_detail->id}},2)" data-id="2"  href="#">
                                                        <span class="ti-trash"></span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @if($student_detail->document_file_3 != "")
                                        <tr class="d-flex">
                                            <td class="col-2">{{$student_detail->document_title_3}}</td>
                                            <td class="col-6">{{showDocument(@$student_detail->document_file_3)}}</td>
                                            <td class="col-4 d-flex align-items-center">
                                                @if(userPermission(17))
                                                    <button class="primary-btn tr-bg text-uppercase bord-rad mr-1">
                                                        <a href="{{asset($student_detail->document_file_3)}}" download>@lang('common.download')</a>
                                                        <span class="pl ti-download"></span>
                                                    </button>
                                                @endif
                                                @if(userPermission(18))
                                                    <a class="primary-btn icon-only fix-gr-bg" onclick="deleteDoc({{$student_detail->id}},3)" data-id="3"  href="#">
                                                        <span class="ti-trash"></span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @if($student_detail->document_file_4 != "")
                                        <tr class="d-flex">
                                            <td class="col-2">{{$student_detail->document_title_4}}</td>
                                            <td class="col-6">{{showDocument(@$student_detail->document_file_4)}}</td>
                                            <td class="col-4 d-flex align-items-center">
                                                @if(userPermission(17))
                                                    <button class="primary-btn tr-bg text-uppercase bord-rad mr-1">
                                                        <a href="{{asset($student_detail->document_file_4)}}" download>@lang('common.download')</a>
                                                        <span class="pl ti-download"></span>
                                                    </button>
                                                @endif
                                                @if(userPermission(18))
                                                    <a class="primary-btn icon-only fix-gr-bg" onclick="deleteDoc({{$student_detail->id}},4)"  data-id="4"  href="#">
                                                        <span class="ti-trash"></span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        <div class="modal fade admin-query" id="delete-doc" >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('common.delete')</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                            <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                        </div>

                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <form action="{{route('student_document_delete')}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="student_id" >
                                                                <input type="hidden" name="doc_id">
                                                                <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                                <button type="submit" class="primary-btn fix-gr-bg">@lang('common.delete')</button>
                                                                
                                                            </form>
                                                            
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        @foreach($documents as $document)
                                        <tr class="d-flex">
                                            <td class="col-2">{{@$document->title}}</td>
                                            <td class="col-6">{{showDocument(@$document->file)}}</td>
                                            <td class="col-4">
                                                @if(userPermission(17))
                                                    <a class="primary-btn tr-bg text-uppercase bord-rad" href="{{route('student-download-document',showDocument(@$document->file))}}">
                                                        Download<span class="pl ti-download"></span>
                                                    </a>
                                                @endif
                                                @if(@$document->type=='stu')
                                                    @if(userPermission(18))
                                                        <a class="primary-btn icon-only fix-gr-bg" data-toggle="modal" data-target="#deleteDocumentModal{{@$document->id}}"  href="#">
                                                            <span class="ti-trash"></span>
                                                        </a>
                                                    @endif
                                                @else
                                                    <a></a>
                                                @endif
                                            </td>
                                        </tr>

                                        <div class="modal fade admin-query" id="deleteDocumentModal{{@$document->id}}" >
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">@lang('common.delete')</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="text-center">
                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                        </div>

                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                            <a class="primary-btn fix-gr-bg" href="{{route('delete_document', [@$document->id])}}">
                                                            @lang('common.delete')</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <!-- End Documents Tab -->

                    <!-- Add Document modal form start-->
                        <div class="modal fade admin-query" id="add_document_madal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">@lang('student.upload_document')</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                    <div class="container-fluid">
                                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_upload_document', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'name' => 'document_upload']) }}
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="hidden" name="student_id" value="{{@$student_detail->id}}">
                                                        <div class="row mt-25">
                                                            <div class="col-lg-12">
                                                                <div class="input-effect">
                                                                    <input class="primary-input form-control{" type="text" name="title" value="" id="title">
                                                                    <label>Title <span>*</span> </label>
                                                                    <span class="focus-border"></span>
                                                                    
                                                                    <span class=" text-danger" role="alert" id="amount_error">
                                                                        
                                                                    </span>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mt-30">
                                                        <div class="row no-gutters input-right-icon">
                                                            <div class="col">
                                                                <div class="input-effect">
                                                                    <input class="primary-input" type="text" id="placeholderPhoto" placeholder="Document"
                                                                        disabled>
                                                                    <span class="focus-border"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <button class="primary-btn-small-input" type="button">
                                                                    <label class="primary-btn small fix-gr-bg" for="photo">browse</label>
                                                                    <input type="file" class="d-none" name="photo" id="photo">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- <div class="col-lg-12 text-center mt-40">
                                                        <button class="primary-btn fix-gr-bg" id="save_button_sibling" type="button">
                                                            <span class="ti-check"></span>
                                                            save information
                                                        </button>
                                                    </div> -->
                                                    <div class="col-lg-12 text-center mt-40">
                                                        <div class="mt-40 d-flex justify-content-between">
                                                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>

                                                            <button class="primary-btn fix-gr-bg" type="submit">save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- Add Document modal form end-->

                    <!-- Start Timeline Tab -->
                        <div role="tabpanel" class="tab-pane fade {{Session::get('studentTimeline') == 'active'? 'show active':''}}" id="studentTimeline">
                            <div class="white-box">
                                @foreach($timelines as $timeline)
                                <div class="student-activities">
                                    <div class="single-activity">
                                        <h4 class="title text-uppercase">                                                                            
                                        {{@$timeline->date != ""? dateConvert(@$timeline->date):''}}
                                        </h4>
                                        <div class="sub-activity-box d-flex">
                                            <h6 class="time text-uppercase">{{date('h:i A', strtotime(@$timeline->date))}}</h6>
                                            <div class="sub-activity">
                                                <h5 class="subtitle text-uppercase"> {{@$timeline->title}}</h5>
                                                <p>
                                                    {{@$timeline->description}}
                                                </p>
                                            </div>

                                            <div class="close-activity">
                                                @if(@$timeline->file != "")
                                                <a href="{{route('download-timeline-doc',showDocument(@$timeline->file))}}" class="primary-btn tr-bg text-uppercase bord-rad">
                                                    @lang('common.download')<span class="pl ti-download"></span>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    <!-- End Timeline Tab -->

                    @if(moduleStatusCheck('Wallet'))
                        <div role="tabpanel" class="tab-pane fade {{Session::get('studentWallet') == 'active'? 'show active':''}}" id="studentWallet">
                            <div class="white-box">
                                @include('wallet::_addWallet')
                            </div>
                        </div>
                    @endif
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
                                <input type="hidden" name="student_id" value="{{@$student_detail->id}}">
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{" type="text" name="title" value="" id="title">
                                            <label>Title <span>*</span> </label>
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
                                            <input class="primary-input date form-control" id="startDate" type="text"
                                                 name="date">
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
                                    <label>Description<span></span> </label>
                                    <span class="focus-border textarea"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-30">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input" type="text" id="placeholderFileFourName" placeholder="Document"
                                                disabled>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="primary-btn small fix-gr-bg" for="document_file_4">browse</label>
                                            <input type="file" class="d-none" name="document_file_4" id="document_file_4">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-30">
                                
                                <input type="checkbox" id="currentAddressCheck" class="common-checkbox" name="visible_to_student" value="1">
                                <label for="currentAddressCheck">@lang('student.visible_to_this_person')</label>
                            </div>


                            <!-- <div class="col-lg-12 text-center mt-40">
                                <button class="primary-btn fix-gr-bg" id="save_button_sibling" type="button">
                                    <span class="ti-check"></span>
                                    save information
                                </button>
                            </div> -->
                            <div class="col-lg-12 text-center mt-40">
                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>

                                    <button class="primary-btn fix-gr-bg" type="submit">save</button>
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


<script>
    // data table responsive problem tab
    $(document).ready(function () {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust()
    .responsive.recalc();
    });
    });

    function deleteDoc(id,doc){
        var modal = $('#delete-doc');
         modal.find('input[name=student_id]').val(id)
         modal.find('input[name=doc_id]').val(doc)
         modal.modal('show');
    }
</script>
@endsection
