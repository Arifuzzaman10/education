@extends('backEnd.master')
@section('title')
@lang('exam.exam_attendance')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('exam.exam_attendance') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('exam.examination')</a>
                <a href="#">@lang('exam.exam_attendance')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
            <div class="row mb-20">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="main-title sm_mb_20">
                        <h3 class="mb-0">@lang('common.select_criteria') </h3>
                    </div>
                </div>

                @if(userPermission(221))
                    <div class="col-lg-6 text-right col-md-6 text_xs_left col-sm-6">
                        <a href="{{route('exam_attendance_create')}}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus pr-2"></span>
                            @lang('exam.attendance_create')
                        </a>
                    </div>
                @endif
       
            </div>
            <div class="row">
                <div class="col-lg-12">
                
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'route' => 'exam_attendance', 'method' => 'POST', 'id' => 'search_student']) }}
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                                @if(moduleStatusCheck('University'))
                                    <div class="col-lg-12">
                                        <div class="row">
                                            @includeIf('university::common.session_faculty_depart_academic_semester_level',
                                            ['required' => 
                                                ['USN', 'UD', 'UA', 'US', 'USL', 'USEC'],'hide'=> ['USUB']
                                            ])

                                            <div class="col-lg-3 mt-30" id="select_exam_typ_subject_div">
                                                {{ Form::select('exam_type',[""=>__('exam.select_exam').'*'], null , ['class' => 'niceSelect w-100 bb form-control'. ($errors->has('exam_type') ? ' is-invalid' : ''), 'id'=>'select_exam_typ_subject']) }}
                                                <span class="focus-border"></span>
                                                <div class="pull-right loader loader_style" id="select_exam_type_loader">
                                                    <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                                </div>
                                                @if ($errors->has('exam_type'))
                                                    <span class="invalid-feedback custom-error-message" role="alert">
                                                        {{ @$errors->first('exam_type') }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="col-lg-3 mt-30" id="select_un_exam_type_subject_div">
                                                {{ Form::select('subject_id',[""=>__('exam.select_subject').'*'], null , ['class' => 'niceSelect w-100 bb form-control'. ($errors->has('subject_id') ? ' is-invalid' : ''), 'id'=>'select_un_exam_type_subject']) }}
                                                <span class="focus-border"></span>
                                                <div class="pull-right loader loader_style" id="select_exam_subject_loader">
                                                    <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                                </div>
                                                @if ($errors->has('subject_id'))
                                                    <span class="invalid-feedback custom-error-message" role="alert">
                                                        {{ @$errors->first('subject_id') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-3 mt-30-md">
                                        <select class="w-100 bb niceSelect form-control{{ $errors->has('exam') ? ' is-invalid' : '' }}" name="exam">
                                            <option data-display="@lang('exam.select_exam') *" value="">@lang('exam.select_exam') *</option>
                                            @foreach($exams as $exam)
                                                <option value="{{@$exam->id}}">{{@$exam->title}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('exam'))
                                            <span class="invalid-feedback invalid-select" role="alert">
                                                <strong>{{ $errors->first('exam') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    {{-- <div class="col-lg-3 mt-30-md">
                                        <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                            <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class') *</option>
                                            @foreach($classes as $class)
                                            <option value="{{ @$class->id}}"  {{( old('class') == @$class->id ? "selected":"")}}>{{ @$class->class_name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('class'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-3 mt-30-md" id="select_section_div">
                                        <select class="w-100 bb niceSelect form-control{{ $errors->has('section') ? ' is-invalid' : '' }} select_section" id="select_section" name="section">
                                            <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section') *</option>
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
                                    <div class="col-lg-3 mt-30-md" id="select_subject_div">
                                        <select class="w-100 bb niceSelect form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" id="select_subject" name="subject">
                                            <option data-display="@lang('common.select_subjects') *" value="">@lang('common.select_subjects')*</option>
                                        </select>
                                        <div class="pull-right loader loader_style" id="select_subject_loader">
                                            <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                        </div>
                                        @if ($errors->has('subject'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('subject') }}</strong>
                                        </span>
                                        @endif
                                    </div> --}}

                                    <div class="col-lg-3 mt-30-md">
                                        <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="class_subject" name="class">
                                            <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class') *</option>
                                            @foreach($classes as $class)
                                            <option value="{{$class->id}}" {{isset($class_id)? ($class_id == $class->id? 'selected':''):''}}>{{$class->class_name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('class'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    
                                    <div class="col-lg-3 mt-30-md" id="select_class_subject_div">
                                        <select class="w-100 bb niceSelect form-control{{ $errors->has('subject') ? ' is-invalid' : '' }} select_class_subject" id="select_class_subject" name="subject">
                                            <option data-display="@lang('common.select_subject') *" value="">@lang('common.select_subject') *</option>
                                        </select>
                                        <div class="pull-right loader loader_style" id="select_class_subject_loader">
                                            <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                        </div>
                                        @if ($errors->has('subject'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('subject') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <div class="col-lg-3 mt-30-md" id="m_select_subject_section_div">
                                        <select class="w-100 bb niceSelect form-control{{ $errors->has('section') ? ' is-invalid' : '' }} m_select_subject_section" id="m_select_subject_section" name="section">
                                            <option data-display="@lang('common.select_section') " value=" ">@lang('common.select_section') </option>
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

                                @endif

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
        @if(isset($exam_attendance_childs))
            @if(moduleStatusCheck('University'))
                <div class="row mt-40">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 no-gutters mb-30">
                                <div class="main-title">
                                    <h3>@lang('exam.exam_attendance') | <strong>@lang('exam.subject')</strong>: {{$subjectName->subject_name}}</h3>
                                    @includeIf('university::exam._university_info')
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="table_id_table" class="display school-table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="20%">@lang('student.admission_no')</th>
                                            <th width="20%">@lang('student.student_name')</th>
                                            <th width="20%">@lang('student.roll_no')</th>
                                            <th width="20%">@lang('exam.attendance')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($exam_attendance_childs as $student)
                                            <tr>
                                                <td>{{@$student->studentInfo !=""?@$student->studentInfo->admission_no:""}}<input type="hidden" name="id[]" value="{{@$student->student_id}}"></td>
                                                <td>{{@$student->studentInfo !=""?@$student->studentInfo->first_name.' '.@$student->studentInfo->last_name:""}}</td>
                                                <td>{{@$student->studentInfo !=""?@$student->studentInfo->roll_no:""}}</td>
                                                <td>
                                                    @if(@$student->attendance_type == 'P')
                                                    <button class="primary-btn small bg-success text-white border-0">@lang('student.present')</button>
                                                    @else
                                                    <button class="primary-btn small bg-danger text-white border-0">@lang('student.absent')</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row mt-40">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-30">@lang('exam.exam_attendance')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="table_id_table" class="display school-table" cellspacing="0" width="100%">
                                    <thead>
                                    
                                        <tr>
                                            <th width="20%">@lang('student.admission_no')</th>
                                            <th width="20%">@lang('student.student_name')</th>
                                            <th width="20%">@lang('common.class_Sec')</th>
                                            <th width="20%">@lang('student.roll_no')</th>
                                            <th width="20%">@lang('exam.attendance')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($exam_attendance_childs as $student)
                                        <tr>
                                            <td>{{@$student->studentInfo !=""?@$student->studentInfo->admission_no:""}}<input type="hidden" name="id[]" value="{{@$student->student_id}}"></td>
                                            <td>{{@$student->studentInfo !=""?@$student->studentInfo->first_name.' '.@$student->studentInfo->last_name:""}}</td>
                                            <td>{{@$student->studentRecord !=""?@$student->studentRecord->class->class_name.'('.@$student->studentRecord->section->section_name.')':""}}</td>
                                            <td>{{@$student->studentInfo !=""?@$student->studentInfo->roll_no:""}}</td>
                                            <td>
                                                @if(@$student->attendance_type == 'P')
                                                <button class="primary-btn small bg-success text-white border-0">@lang('student.present')</button>
                                                @else
                                                <button class="primary-btn small bg-danger text-white border-0">@lang('student.absent')</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
        </div>
    </section>

@endsection
