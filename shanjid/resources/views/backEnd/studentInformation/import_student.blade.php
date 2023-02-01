@extends('backEnd.master')
@section('title') 
@lang('student.student_import')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('student.student_import')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('student.student_admission')</a>
                <a href="#">@lang('student.student_import')</a>
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
                <a href="{{url('/public/backEnd/bulksample/students.xlsx')}}">
                    <button class="primary-btn tr-bg text-uppercase bord-rad">
                        @lang('student.download_sample_file')
                        <span class="pl ti-download"></span>
                    </button>
                </a>
            </div>
        </div>

    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_bulk_store',
                        'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'student_form']) }}
        <div class="row">
            <div class="col-lg-12">
               

                <div class="white-box">
                    <div class="">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="main-title">
                                    <div class="box-body">      
                                        <br>           
                                        1. @lang('student.point1')<br>
                                        2. @lang('student.point2')<br>
                                        3. @lang('student.point3')<br>
                                        4. @lang('student.point4')<br>
                                        
                                        5. @lang('student.point6')(
                                        @foreach($genders as $gender)
                                            {{$gender->id.'='.$gender->base_setup_name.','}}

                                        @endforeach


                                        ).<br>
                                        6. @lang('student.point7')(
                                        @foreach($blood_groups as $blood_group)
                                            {{$blood_group->id.'='.$blood_group->base_setup_name.','}}

                                        @endforeach
                                        ).<br>
                                        7. @lang('student.point8')(
                                        @foreach($religions as $religion)
                                            {{$religion->id.'='.$religion->base_setup_name.','}}

                                        @endforeach
                                        ).<br>
                                        8. For relation with guardian (F=Father, M=Mother, O=Other)<br>
                                        9. Please follow this date format(2020-06-15) for Date of birth & Admission date<br>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                        <div class="row mb-40 mt-30">

                            @if(moduleStatusCheck('University'))
                                @includeIf('university::common.session_faculty_depart_academic_semester_level',['hide'=>['USUB'], 'required' => ['US', 'UD', 'USN', 'USL', 'UA', 'USEC']])
                                <div class="col-lg-3 mt-25">
                                    <div class="row no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="input-effect">
                                                <input class="primary-input form-control {{ $errors->has('file') ? ' is-invalid' : '' }}" type="text" id="placeholderPhoto" placeholder="Excel file"
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
                                                <label class="primary-btn small fix-gr-bg" for="photo">@lang('common.browse')</label>
                                                <input type="file" class="d-none" name="file" id="photo">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @else
                            <div class="col-lg-3">
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

                            <div class="col-lg-3">
                                <div class="input-effect" id="class-div">
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
                            <div class="col-lg-3">
                                <div class="input-effect" id="sectionStudentDiv">
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
                            <div class="col-lg-3">
                                <div class="row no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input form-control {{ $errors->has('file') ? ' is-invalid' : '' }}" type="text" id="placeholderPhoto" placeholder="Excel file"
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
                                            <label class="primary-btn small fix-gr-bg" for="photo">@lang('common.browse')</label>
                                            <input type="file" class="d-none" name="file" id="photo">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif
                          
                                
                        </div>

                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                                <button class="primary-btn fix-gr-bg">
                                    <span class="ti-check"></span>
                                    @lang('student.save_bulk_students')
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
