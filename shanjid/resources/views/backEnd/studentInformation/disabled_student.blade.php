@extends('backEnd.master')

@section('title') 
{{@$pt}}
@endsection

@section('mainContent')
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>{{@$pt}}</h1>
            <div class="bc-pages">
                <a href="{{url('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('student.student_information')</a>
                <a href="#">{{@$pt}}</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_admin_visitor full_wide_table">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('common.select_criteria') </h3>
                    </div>
                </div>
            </div>
            
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'disabled_student', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            <div class="row">
                <div class="col-lg-12">
                <div class="white-box">
                    <div class="row">
                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                        @if(moduleStatusCheck('University'))
                       
                            @includeIf('university::common.session_faculty_depart_academic_semester_level',['hide'=>['USUB']])
                            <div class="col-lg-3 mt-25">
                                <div class="input-effect sm2_mb_20 md_mb_20">
                                    <input class="primary-input" type="text" name="name" value="{{isset($name)? $name: ''}}">
                                    <label>@lang('student.search_by_name')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-25">
                                <div class="input-effect md_mb_20">
                                    <input class="primary-input" type="text" name="roll_no" value="{{isset($roll_no)? $roll_no: ''}}">
                                    <label>@lang('student.search_by_roll_no')</label>
                                    <span class="focus-border"></span>
                                </div>
                            </div>
                        @else 
                        <div class="col-lg-3 mt-30-md mt-30-md2 md_mb_20">
                            <select class="niceSelect w-100 bb form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                <option data-display="@lang('student.select_class') *" value="">@lang('student.select_class') *</option>
                                @foreach($classes as $class)
                                <option value="{{$class->id}}" {{isset($class_id)? ($class->id == $class_id? 'selected':''): ''}}>{{$class->class_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('class'))
                            <span class="invalid-feedback invalid-select" role="alert">
                                <strong>{{ $errors->first('class') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-3 mt-30-md mt-30-md2 md_mb_20" id="select_section_div">
                            <select class="niceSelect w-100 bb form-control{{ $errors->has('section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                <option data-display="@lang('student.select_section')" value="">@lang('student.select_section')</option>
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
                        <div class="col-lg-3">
                            <div class="input-effect sm2_mb_20 md_mb_20">
                                <input class="primary-input" type="text" name="name" value="{{isset($name)? $name: ''}}">
                                <label>@lang('student.search_by_name')</label>
                                <span class="focus-border"></span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="input-effect md_mb_20">
                                <input class="primary-input" type="text" name="roll_no" value="{{isset($roll_no)? $roll_no: ''}}">
                                <label>@lang('student.search_by_roll_no')</label>
                                <span class="focus-border"></span>
                            </div>
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

            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">{{@$pt}} </h3>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                  
                                    <tr>
                                        <th>@lang('student.admission_no')</th>
                                        <th>@lang('student.roll_no')</th>
                                        <th>@lang('student.name')</th>
                                        <th>@lang('common.class')</th>
                                        @if(generalSetting()->with_guardian)
                                        <th>@lang('student.father_name')</th>
                                        @endif
                                        <th>@lang('common.date_of_birth')</th>
                                        <th>@lang('common.gender')</th>
                                        <th>@lang('common.type')</th>
                                        <th>@lang('common.phone')</th>
                                        <th>@lang('common.actions')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        <td>{{$student->admission_no}}</td>
                                        <td>{{$student->roll_no}}</td>
                                        <td>{{$student->first_name.' '.$student->last_name}}</td>
                                        <td>
                                            @php
                                                $class_sec=[];
                                                foreach ($student->studentRecords as $classSec) {
                                                    $class_sec[]=$classSec->class->class_name.'('. $classSec->section->section_name .'), ' ;
                                                }
                                                if (request()->class) {
                                                    $sections = [];
                                                    $class =  $student->recordClass ? $student->recordClass->class->class_name : '';
                                                    if (request()->section) {
                                                        $sections [] = $student->recordSection != "" ? $student->recordSection->section->section_name:"";
                                                    } else {
                                                        foreach ($student->recordClasses as $section) {
                                                            $sections [] = $section->section->section_name;
                                                        }
                                                    }
                                                    echo  $class .'('.implode(', ', $sections).'), ';
                                                } else{
                                                    echo implode(', ', $class_sec);
                                                }
                                            @endphp
                                        </td>
                                        {{-- <td>{{$student->class !=""?$student->class->class_name:""}}</td> --}}
                                        @if(generalSetting()->with_guardian)
                                        <td>{{$student->parents !=""?$student->parents->fathers_name:""}}</td>
                                        @endif
                                        <td  data-sort="{{strtotime($student->date_of_birth)}}" >
                                           {{$student->date_of_birth != ""? dateConvert($student->date_of_birth):''}} 
                                        </td>
                                        <td>{{$student->gender != ""? $student->gender->base_setup_name :''}}</td>
                                        <td>{{$student->category != ""? $student->category->category_name:''}}</td>
                                        <td>{{$student->mobile}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                    @lang('common.select')
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="{{route('student_view', [$student->id])}}">@lang('common.view')</a> 
                                                   
                                                    @if(userPermission(86))
                                                    <a onclick="deleteId({{$student->id}});" class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteStudentModal" data-id="{{$student->id}}"  >@lang('common.delete')</a>
                                                    @endif
                                                    <a onclick="enableId({{$student->id}});" class="dropdown-item" href="#" data-toggle="modal" data-target="#enableStudentModal" data-id="{{$student->id}}"  >@lang('common.enable')</a>
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
    </div>
</section>

<div class="modal fade admin-query" id="deleteStudentModal" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation Required</h4>
                {{-- <h4 class="modal-title">@lang('student.delete') @lang('student.student')</h4> --}}
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    {{-- <h4>@lang('student.are_you_sure_to_delete')</h4> --}}
                    <h4 class="text-danger">You are going to remove {{@$student->first_name.' '.@$student->last_name}}. Removed data CANNOT be restored! Are you ABSOLUTELY Sure!</h4>
                    {{-- <div class="alert alert-warning">@lang('student.student_delete_note')</div> --}}
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                     {{ Form::open(['route' => 'disable_student_delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                     <input type="hidden" name="id" value="" id="student_delete_i">  {{-- using js in main.js --}}
                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
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
                <h4 class="modal-title">@lang('student.enable_student')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('student.are_you_sure_to_enable')</h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                     {{ Form::open(['route' => 'enable_student', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                     <input type="hidden" name="id" value="" id="student_enable_i">  {{-- using js in main.js --}}
                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.enable')</button>
                     {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</div>



@endsection
