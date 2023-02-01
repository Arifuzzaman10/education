@extends('backEnd.master')
@section('title') 
@lang('reports.student_login_info')
@endsection
@section('mainContent')
<input type="text" hidden value="{{ @$clas->class_name }}" id="cls">
<input type="text" hidden value="{{ @$clas->section_name->sectionName->section_name }}" id="sec">
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('reports.student_login_info')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('reports.reports')</a>
                <a href="#">@lang('reports.student_login_info')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('common.select_criteria') </h3>
                    </div>
                </div>
            </div>
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_login_search', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            <div class="row">
                <div class="col-lg-12">
                <div class="white-box">
                    <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                @if(moduleStatuscheck('University'))
                               @includeIf('university::common.session_faculty_depart_academic_semester_level',['required' => ['US'], 'hide' => ['USUB']])
                               @else
                                <div class="col-lg-6 mt-30-md col-md-6">
                                    <select class="niceSelect w-100 bb form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                        <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class') *</option>
                                        @foreach($classes as $class)
                                        <option value="{{$class->id}}"  {{isset($class_id)? ($class->id == $class_id? 'selected':''): ''}}>{{$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 mt-30-md col-md-6" id="select_section_div">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                        <option data-display="@lang('reports.select_current_section')" value="">@lang('reports.select_current_section')</option>
                                        @if(isset($class_id))
                                        @foreach ($class->classSection as $section)
                                        <option value="{{ $section->sectionName->id }}" {{ old('section')==$section->sectionName->id ? 'selected' : '' }} >
                                            {{ $section->sectionName->section_name }}</option>
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
                                @endif

                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                        <span class="ti-search pr-2"></span>
                                        @lang('common.search')
                                    </button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            {{ Form::close() }}
            @if(isset($student_records))
            <div class="row mt-40"> 
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('reports.manage_login')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id_s" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                   
                                    <tr>
                                        <th>@lang('common.sl')</th>
                                        <th>@lang('student.admission_no')</th>
                                        <th>@lang('student.student_name')</th>
                                        <th>@lang('reports.email_&_password')</</th>                                       
                                        <th>@lang('reports.parent_email_&_password') </th>
                                        
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $count=1;
                                    @endphp
                                    @foreach($student_records as $record)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{@$record->student->admission_no}}</td>
                                        <td>{{@$record->student->first_name.' '.@$record->student->last_name}}</td>
                                        <td>
                                            @if(@$record->student->user)
                                            {{@$record->student->user !=""? @$record->student->user->email:""}}
                                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'reset-student-password', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                            <input type="hidden" name="id" value="{{@$record->student->user_id}}">
                                            <div class="row mt-10">
                                                <div class="col-lg-6">
                                                    <div class="input-effect md_mb_20">
                                                        <input class="primary-input read-only-input"  type="text" name="new_password" required="true" minlength="6">
                                                        <label>@lang('reports.reset_password')</label>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6">

                                                    @if(userPermission(380))

                                                   
                                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                                       
                                                        @lang('reports.update')
                                                    </button>
                                               @endif
                                                </div>
                                            </div>
                                             {{ Form::close() }}
                                                @endif
                                        </td>

                                        <td>
                                            @if(@$record->student->parents->parent_user)

                                            {{@$record->student->parents->parent_user->email}}
                                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'reset-student-password', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                            <input type="hidden" name="id" value="{{@$record->student->parents->parent_user->id}}">
                                            <div class="row mt-10">
                                                <div class="col-lg-6">
                                                    <div class="input-effect md_mb_20">
                                                        <input class="primary-input read-only-input" type="text" name="new_password" required="true" minlength="6">
                                                        <label>@lang('reports.reset_password')</label>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                                        
                                                        @lang('common.update')
                                                    </button>
                                                </div>
                                            </div>
                                             {{ Form::close() }}
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
    </div>
</section>

@endsection
