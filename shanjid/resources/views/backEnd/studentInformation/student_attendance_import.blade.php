@extends('backEnd.master')
@section('title') 
@lang('student.student_attendance_import')
@endsection

@section('mainContent')
    <section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('student.student_attendance')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('student.student_attendance')</a>
                    <a href="#">@lang('student.student_attendance_import')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="main-title">
                        <h3>@lang('common.select_criteria')</h3>
                    </div>
                </div>

                <div class="offset-lg-3 col-lg-3 text-right mb-20">
                    <a href="{{url('/public/backEnd/bulkxl/student_attendance.xlsx')}}">
                        <button class="primary-btn tr-bg text-uppercase bord-rad">
                            @lang('student.download_sample_file')
                            <span class="pl ti-download"></span>
                        </button>
                    </a>
                </div>
            </div>
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student-attendance-bulk-store',
                            'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'student_form']) }}
            <div class="row">
                <div class="col-lg-12">
                   
                    <div class="white-box">
                        <div class="">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-title">
                                        <div class="box-body">


                                        </div>
                                    </div>
                                </div>
                            </div>


                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                            @if(moduleStatusCheck('University'))
                            <div class="row mb-40 mt-30">
                                @includeIf('university::common.session_faculty_depart_academic_semester_level',['mt'=>'mt-30','hide'=>['USUB'], 'required'=>['UA', 'UF', 'UD', 'US', 'USL','USEC']])
                            </div>
                            @else
                            <div class="row mb-40 mt-30">
                                <div class="col-lg-6 col-md-6 col-sm-12 sm_mb_20 sm2_mb_20">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('class') ? ' is-invalid' : '' }}"
                                            id="select_class" name="class">
                                        <option data-display="@lang('common.select_class') *"
                                                value="">@lang('common.select_class') *
                                        </option>
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
                                <div class="col-lg-6 col-md-6 col-sm-12" id="select_section_div">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('section') ? ' is-invalid' : '' }}"
                                            id="select_section" name="section">
                                        <option data-display="@lang('common.select_section') *"
                                                value="">@lang('common.select_section') *
                                        </option>
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
                            </div>
                            @endif
                            <div class="row mb-40 mt-30">

                                <div class="col-lg-6 mt-30-md">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input class="primary-input date form-control read-only-input has-content"
                                                       id="startDate" type="text" name="attendance_date"
                                                       autocomplete="off" value="{{date('m/d/Y')}}">
                                                <label for="startDate">{{ __('hr.attendance_date') }} *</label>
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
                                <div class="col-lg-6">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input class="primary-input form-control {{ $errors->has('file') ? ' is-invalid' : '' }}"
                                                       type="text" id="placeholderPhoto"
                                                       placeholder="@lang('student.excel_file') (xlsx, csv) *"
                                                       readonly>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('file'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('file') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="primary-btn small fix-gr-bg"
                                                       for="photo">@lang('common.browse')</label>
                                                <input type="file" class="d-none" name="file" id="photo">
                                            </button>
                                        </div>
                                    </div>
                                </div>
 
                            </div>
                                                                                                                             
                            <div class="row mt-40">
                                <div class="col-lg-12 text-center">
                                    <button class="primary-btn fix-gr-bg">
                                        <span class="ti-check"></span>
                                        @lang('student.import_attendance')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </section>
@endsection
