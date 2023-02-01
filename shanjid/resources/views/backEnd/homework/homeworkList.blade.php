@extends('backEnd.master')
@section('title')
@lang('homework.homework_list')
@endsection
@section('mainContent')
@php
    $DATE_FORMAT = systemDateFormat();   
@endphp
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('homework.homework_list')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('homework.home_work')</a>
                <a href="#">@lang('homework.homework_list')</a>
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
            <div class="col-lg-4 text-md-right text-left col-md-6 mb-30-lg">
                <a href="{{route('add-homeworks')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('homework.add_homework')
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'homework-list', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                    @if(moduleStatusCheck('University'))
                    <div class="row">
                        @includeIf('university::common.session_faculty_depart_academic_semester_level',['subject'=>true])
                    </div>
                    @else 

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('class_id') ? ' is-invalid' : '' }}" name="class_id"  id="class_subject">
                                    <option data-display="@lang('common.select_class') *" value="">@lang('common.select')</option>
                                        @foreach($classes as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->class_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('class_id'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-effect" id="select_class_subject_div">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('subject_id') ? ' is-invalid' : '' }} select_class_subject" name="subject_id" id="select_class_subject">
                                        <option data-display="@lang('common.select_subjects')" value="">@lang('common.subject')</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_subject_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                
                                    <span class="focus-border"></span>
                                    @if ($errors->has('subject_id'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('subject_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-effect" id="m_select_subject_section_div">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }} m_select_subject_section" name="section_id" id="m_select_subject_section">
                                        <option data-display="@lang('common.select_section')" value="">@lang('common.section')</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('section_id'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('section_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        
                           
                        </div>
                    @endif  
                    
                    <div class="col-lg-12 mt-20 text-right">
                        <button type="submit" class="primary-btn small fix-gr-bg">
                            <span class="ti-search pr-2"></span>
                            @lang('common.search')
                        </button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    @if (@$homeworkLists)                                
    <div class="row mt-40">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4 no-gutters">
                    <div class="main-title">
                        <h3 class="mb-0">@lang('homework.homework_list')</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                @if(moduleStatusCheck('University'))
                                <th>@lang('university::un.semester_label')</th>
                                <th>@lang('university::un.department')</th>
                                @else
                                    <th>@lang('common.class')</th>
                                    <th>@lang('common.section')</th>
                                @endif
                                
                                <th>@lang('homework.subject')</th>
                                <th>@lang('homework.marks')</th>
                                <th>@lang('homework.home_work_date')</th>
                                <th>@lang('homework.submission_date')</th>
                                <th>@lang('homework.evaluation_date')</th>
                                <th>@lang('homework.created_by')</th>
                                <th>@lang('common.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(@$homeworkLists as $value)
                            <tr>
                                @if(moduleStatusCheck('University'))
                                <td> {{@$value->semesterLabel->name}} ({{@$value->unSession->name}})</td>
                                <td> {{@$value->unSemester->name}}</td>
                                @else 
                                <td>{{$value->classes  !=""?$value->classes->class_name:""}}</td>
                                <td>{{$value->sections !=""?$value->sections->section_name:""}}</td>
                                @endif 
                                <td>{{$value->subjects !=""?$value->subjects->subject_name:""}}</td>
                                <td>{{$value->marks}}</td>
                                <td data-sort="{{strtotime($value->homework_date)}}">
                                    {{$value->homework_date != ""? date_format(date_create($value->homework_date), $DATE_FORMAT):''}}
                                </td>
                                <td data-sort="{{strtotime($value->submission_date)}}">
                                    {{$value->submission_date != ""? date_format(date_create($value->submission_date), $DATE_FORMAT):''}}
                                </td>
                                <td  data-sort="{{strtotime($value->evaluation_date)}}" >
                                @if(!empty($value->evaluation_date))
                                {{$value->evaluation_date != ""? date_format(date_create($value->evaluation_date), $DATE_FORMAT):''}}
                                @endif
                                </td>
                                <td>{{$value->users !=""? $value->users->full_name:""}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            @lang('common.select')
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                          @if(userPermission(281))
                                            @if(moduleStatusCheck('University'))
                                            <a class="dropdown-item" title="Evaluation Homework" 
                                            href="{{route('university.unevaluation-homework',[$value->un_semester_label_id,$value->id])}}">
                                            @lang('homework.evaluation')
                                            </a>
                                            @else
                                            <a class="dropdown-item" title="Evaluation Homework" 
                                                    href="{{route('evaluation-homework',[@$value->class_id,@$value->section_id,@$value->id])}}">
                                                    @lang('homework.evaluation')
                                            </a>
                                            @endif
                                         @endif
                                          @if(userPermission(282))
                                           <a class="dropdown-item" href="{{route('homework_edit', [$value->id])}}">@lang('common.edit')</a>
                                           @endif
                                            @if(userPermission(283))
                                            <a onclick="GlobaldeleteId();" class="dropdown-item"  data-url="{{route('homework_delete',$value->id)}}"  href="#">@lang('common.delete')</a>
                                        @endif
                                        </div>
                                    </div>
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
