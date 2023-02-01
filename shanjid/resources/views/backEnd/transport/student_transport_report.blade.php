@extends('backEnd.master')
@section('title')
@lang('transport.student_transport_report')
@endsection
@section('mainContent')
@php  @$setting = generalSetting();  if(!empty(@$setting->currency_symbol)){ @$currency = @$setting->currency_symbol; }else{ @$currency = '$'; }   @endphp 

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('transport.student_transport_report')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('transport.transport')</a>
                <a href="#">@lang('transport.student_transport_report')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('common.select_criteria')</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                   
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_transport_report', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                @if(moduleStatusCheck('University'))
                                @includeIf('university::common.session_faculty_depart_academic_semester_level',['required'=>['USN','UD','UA','US','USL','USEC'], 'hide' => ['USUB']])
                                @else 
                                <div class="col-lg-3 mt-30">
                                    <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                        <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class')*</option>
                                        @foreach($classes as $class)
                                        <option value="{{@$class->id}}"  {{isset($class_id)? (@$class_id == @$class->id? 'selected':''):''}}>{{@$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('class'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-3 mt-30" id="select_section_div">
                                    <select class="w-100 bb niceSelect form-control{{ $errors->has('section') ? ' is-invalid' : '' }} select_section" id="select_section" name="section">
                                        <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section') *</option>
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
                                <div class="col-lg-3 mt-25">
                                    <select class="w-100 bb niceSelect form-control{{ $errors->has('route') ? ' is-invalid' : '' }}" name="route">
                                        <option data-display="@lang('transport.select_route') *" value="">@lang('transport.select_route') *</option>
                                        @foreach($routes as $route)
                                            <option value="{{$route->id}}"  {{isset($route_id)? (@$route_id == @$route->id? 'selected':''):''}}>{{@$route->title}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('route'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('route') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-3 mt-25">
                                    <select class="w-100 bb niceSelect form-control{{ $errors->has('vehicle') ? ' is-invalid' : '' }}" name="vehicle">
                                        <option data-display="@lang('transport.select_vehicle') *" value="">@lang('transport.select_vehicle') *</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{$vehicle->id}}"  {{isset($vechile_id)? (@$vechile_id == @$vehicle->id? 'selected':''):''}}>{{@$vehicle->vehicle_no}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('vehicle'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('vehicle') }}</strong>
                                        </span>
                                    @endif
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
          
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-30">@lang('transport.student_transport_report')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                   
                                    <tr>
                                        @if(!moduleStatusCheck('University'))
                                        <th>@lang('common.class_Sec')</th>
                                        @endif 
                                        <th>@lang('student.admission_no')</th>
                                        <th>@lang('student.student_name')</th>
                                        <th>@lang('common.mobile')</th>
                                        <th>@lang('student.father_name')</th>
                                        <th>@lang('student.father_phone')</th>
                                        <th>@lang('transport.route_title')</th>
                                        <th>@lang('transport.vehicle_number')</th>
                                        <th>@lang('transport.driver_name')</th>
                                        <th>@lang('transport.driver_contact')</th>
                                        <th>@lang('transport.fare')({{generalSetting()->currency_symbol}})</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($students as $student)
                                    <tr>
                                        @if(!moduleStatusCheck('University'))
                                        <td>
                                            @if(isset($class_id))
                                            @php if(!empty($student->recordClass)){ echo $student->recordClass->class->class_name; }else { echo ''; } @endphp
                                            @if(isset($section_id))
                                            
                                            ({{$student->recordSection != ""? $student->recordSection->section->section_name:""}})
                                            @else   
                                            (@foreach ($student->recordClasses as $section)
                                            {{$section->section->section_name}} {{ !$loop->last ? ', ':'' }}
                                            @endforeach)
                                            @endif                                              
                                            
                                           @else  
                                           @foreach ($student->studentRecords as $record)
                                           {{__('common.class') }} : {{ $record->class->class_name}}
                                           ({{ $record->section->section_name}}) {{ !$loop->last ? ', ':'' }} <br>
                                            @endforeach
                                           @endif
                                          
                                        <input type="hidden" name="id[]" value="{{@$student->student_id}}">
                                    </td>
                                    @endif   
                                        <td>{{ @$student->admission_no}}</td>
                                        <td>{{ @$student->full_name}}</td>
                                        <td>{{ @$student->mobile}}</td>
                                        <td>{{ @$student->parents !=""?@$student->parents->fathers_name:""}}</td>
                                        <td>{{ @$student->parents !=""?@$student->parents->fathers_mobile:""}}</td>
                                        <td>{{ @$student->route !=""?@$student->route->title:""}}</td>
                                        <td>{{ @$student->vehicle !=""?@$student->vehicle->vehicle_no:""}}</td>
                                        <td>{{ @$student->vehicle !=""?@$student->vehicle->driver->full_name:""}}</td>
                                        <td>{{ @$student->vehicle !=""?@$student->vehicle->driver->mobile:""}}</td>
                                        <td>{{ @$student->vehicle !=""?@$student->route->far:""}}</td>
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

@endsection
