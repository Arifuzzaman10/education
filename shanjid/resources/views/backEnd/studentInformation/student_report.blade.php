@extends('backEnd.master')
@section('title') 
@lang('reports.student_report')
@endsection
@section('mainContent')
<input type="text" hidden value="{{ @$clas->class_name }}" id="cls">
<input type="text" hidden value="{{ @$clas->section_name->sectionName->section_name }}" id="sec">
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('reports.student_report') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('reports.reports')</a>
                <a href="#">@lang('reports.student_report')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30" >@lang('common.select_criteria')</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_report', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                               @if(moduleStatuscheck('University')) 
                               @includeIf('university::common.session_faculty_depart_academic_semester_level',['required' => ['US'], 'hide' => ['USUB']])
                               @else 
                                <div class="col-lg-3 mt-25">
                                    <select class="w-100 niceSelect bb form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                        <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class')</option>
                                        @foreach($classes as $class)
                                        <option value="{{$class->id}}"  {{isset($class_id)? ($class_id == $class->id? 'selected':''):''}}>{{$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-3 mt-25" id="select_section_div">
                                    <select class="w-100 niceSelect bb form-control{{ $errors->has('current_section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                        <option data-display="@lang('common.select_section')" value="">@lang('common.select_section')</option>
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
                                </div>
                                @endif

                                <div class="col-lg-3 mt-25">
                                    <select class="w-100 niceSelect bb form-control{{ $errors->has('current_section') ? ' is-invalid' : '' }}" name="type">
                                        <option data-display="@lang('reports.select_type')" value="">@lang('reports.select_type')</option>
                                        @foreach($types as $type)
                                        <option value="{{$type->id}}" {{isset($type_id)? ($type_id == $type->id? 'selected':''):''}}>{{$type->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-25">
                                    <select class="w-100 niceSelect bb form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender">
                                        <option data-display="@lang('reports.select_gender')" value="">@lang('reports.select_gender')</option>
                                        @foreach($genders as $gender)
                                        <option value="{{$gender->id}}" {{isset($gender_id)? ($gender_id == $gender->id? 'selected':''):''}}>{{$gender->base_setup_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
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
            
@if(isset($student_records))

 {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'method' => 'POST', 'enctype' => 'multipart/form-data'])}}

            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('reports.student_report')</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12 ">
                           
                            <table id="table_ids" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                    @if(session()->has('message-danger') != "")
                                    <tr>
                                        <td colspan="9">
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        @if(moduleStatusCheck('University'))
                                        <th>@lang('university::un.semester_label')</th>
                                        <th>@lang('university::un.department')</th>
                                        @else 
                                        <th>@lang('common.class')</th>
                                        <th>@lang('common.section')</th>
                                        @endif 
                                        <th>@lang('student.admission_no')</th>
                                        <th>@lang('common.name')</th>
                                        <th>@lang('student.father_name')</th>
                                        <th>@lang('common.date_of_birth')</th>
                                        <th>@lang('common.gender')</th>
                                        <th>@lang('common.type')</th>
                                        <th>@lang('common.phone')</th>
                                        <th>@lang('reports.nid_no')</th>
                                        <th>@lang('reports.Birth_Certificate_Number')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($student_records as $record)
                                    <tr>
                                        @if(moduleStatusCheck('University'))
                                        <td>{{@$record->UnSemesterLabel->name}}</td>
                                        <td> {{@$record->unDepartment->name}}</td>
                                        @else
                                        <td>{{@$record->class->class_name}}</td>
                                        <td> {{@$record->section->section_name}}</td>
                                        @endif
                                        <td>{{@$record->student->admission_no}}</td>
                                        <td>{{@$record->student->first_name.' '.@$record->student->last_name}}</td>
                                        <td>{{@$record->student->parents !=""?@$record->student->parents->fathers_name:""}}</td>
                                        <td>{{@$record->student->date_of_birth != ""? dateConvert(@$record->student->date_of_birth):''}}</td>
                                        <td>{{@$record->student->gender != ""? @$record->student->gender->base_setup_name:""}}</td>
                                        <td>{{@$record->student->category != ""? @$record->student->category->category_name:""}}</td>
                                        <td>{{@$record->student->mobile}}</td>
                                        <td>{{@$record->student->national_id_no}}</td>
                                        <td>{{@$record->student->local_id_no}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>

@endif

    </div>
</section>


@endsection
