@extends('backEnd.master')
@section('mainContent')
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.manage') @lang('lang.student')</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.new') @lang('lang.registration')</a>
                <a href="#">@lang('lang.student_list')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('lang.select_criteria')</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"> 
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => 'parentregistration/saas-student-list', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'parent-registration']) }}
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                 <div class="col-lg-3">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('institution') ? ' is-invalid' : '' }}" name="institution" id="select-school">
                                        <option data-display="@lang('lang.select') @lang('lang.institution')" value="">@lang('lang.select') @lang('lang.institution') *</option>
                                        @foreach($institutions as $institution)
                                        <option value="{{ $institution->id }}">{{ $institution->school_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('institution'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('institution') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-3 mt-30-md" id="academic-year-div">

                                    <select class="niceSelect w-100 bb form-control" name="academic_year" id="select-academic-year">
                                        <option data-display="Select Academic Year" value="">@lang('lang.select') @lang('lang.academic_year')</option>

                                        
                                    </select>
                                       
                                </div>

                                <div class="col-lg-3 mt-30-md" id="class-div">
                                    <select class="w-100 niceSelect bb form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select-class" name="class">
                                        <option data-display="@lang('lang.select_class')" value="">@lang('lang.select_class')</option>
                                        
                                    </select>
                                    @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-3 mt-30-md" id="section-div">
                                    <select class="w-100 niceSelect bb form-control{{ $errors->has('current_section') ? ' is-invalid' : '' }}" id="select-section" name="section">
                                        <option data-display="@lang('lang.select_section')" value="">@lang('lang.select_section')</option>
                                    </select>
                                </div>
                            </div>
                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                        <span class="ti-search pr-2"></span>
                                        @lang('lang.search')
                                    </button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            
            @if ($students)
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('lang.student_list') ({{$students ? $students->count() : 0}})</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" >
                                <thead>
                                    @if(session()->has('message-success') != "" ||
                                    session()->get('message-danger') != "")
                                    <tr>
                                        <td colspan="10">
                                            @if(session()->has('message-success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('message-success') }}
                                            </div>
                                            @elseif(session()->has('message-danger'))
                                            <div class="alert alert-danger">
                                                {{ session()->get('message-danger') }}
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>@lang('lang.name')</th>
                                        <th>@lang('lang.class')(@lang('lang.sec'))</th>
                                        <th>@lang('lang.academic_year')</th>
                                        <th>@lang('lang.date_of_birth')</th>
                                        <th>@lang('lang.guardian_name')</th>
                                        <th>@lang('lang.guardian_mobile')</th>
                                        <th>@lang('lang.actions')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>{{$student->first_name.' '.$student->last_name}}</td>

                                        <td>{{$student->class->class_name}}({{$student->section->section_name}})</td>
                                        <td>{{$student->academicYear->year}}</td>
                                        <td  data-sort="{{strtotime($student->date_of_birth)}}" >
                                           
                                        {{$student->date_of_birth != ""? App\SmGeneralSettings::DateConvater($student->date_of_birth):''}}

                                        </td>
                                        <td>{{$student->guardian_name}}</td>
                                        <td>{{$student->guardian_mobile}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    @lang('lang.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">

                                                <a class="dropdown-item" href="{{url('parentregistration/student-view', [$student->id])}}"  data-id="{{$student->id}}"  >@lang('lang.view')</a>

                                                 <a onclick="deleteId({{$student->id}});" class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteStudentModal" data-id="{{$student->id}}"  >@lang('lang.approve')</a>

                                                 <a onclick="enableId({{$student->id}});" class="dropdown-item" href="#" data-toggle="modal" data-target="#enableStudentModal" data-id="{{$student->id}}"  >@lang('lang.delete')</a>
                                               
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

<div class="modal fade admin-query" id="deleteStudentModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('lang.student') @lang('lang.approve')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                
                <div class="text-center">
                    <h4>@lang('lang.are_you_sure_to_approve')</h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                     {{ Form::open(['url' => 'parentregistration/student-approve', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                <input type="hidden" name="id" value="{{$student->id}}" id="student_delete_i">  {{-- using js in main.js --}}
                        <button class="primary-btn fix-gr-bg" type="submit">@lang('lang.approve')</button>
                     {{ Form::close() }}
                </div>

            </div>

        </div>
    </div>
</div>

<div class="modal fade admin-query" id="enableStudentModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('lang.delete') @lang('lang.student')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('lang.are_you_sure_to_delete')</h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('lang.cancel')</button>
                     {{ Form::open(['url' => 'parentregistration/student-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                     <input type="hidden" name="id" value="" id="student_enable_i">  {{-- using js in main.js --}}
                    <button class="primary-btn fix-gr-bg" type="submit">@lang('lang.delete')</button>
                     {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
