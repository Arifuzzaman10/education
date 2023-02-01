@extends('backEnd.master')
@section('title')
@lang('reports.previous_record') 
@endsection
@section('mainContent')
<input type="text" hidden value="{{ @$clas->class_name }}" id="cls">
<input type="text" hidden value="{{ @$sec->section_name }}" id="sec">
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('reports.previous_record') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard') </a>
                <a href="#">@lang('reports.reports')</a>
                <a href="{{route('previous-record')}}">@lang('reports.previous_record')  </a> 
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="main-title">
                    <h3 class="mb-30">@lang('common.select_criteria') </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
               
                <div class="white-box">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'previous-record', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                              <div class="col-lg-4 col-md-4 sm_mb_20 sm2_mb_20">
                                    <select class="niceSelect w-100 bb promote_session form-control{{ $errors->has('promote_session') ? ' is-invalid' : '' }}" name="promote_session" id="promote_session">
                                        <option data-display="@lang('common.select_academic_year') *" value="">@lang('common.select_academic_year') *</option>
                                        @foreach(academicYears() as $session)
                                            <option value="{{$session->id}}" {{isset($year)? ($session->id == $year? 'selected':''):''}}>{{$session->year}} - [ {{$session->title }}]</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('promote_session'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('promote_session') }}</strong>
                                    </span>
                                    @endif
                                    <span class="text-danger d-none" role="alert" id="promote_session_error">
                                        <strong>@lang('reports.the_session_is_required')</strong>
                                    </span>
                                </div>

                                              
                                <div class="col-lg-4 col-md-4 sm_mb_20 sm2_mb_20" id="select_class_div">
                                    <select class="niceSelect w-100 bb" id="select_class" name="promote_class" id="select_class">
                                        <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class')</option>
                                    </select>
                                    @if ($errors->has('promote_class'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('promote_class') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-lg-4 col-md-4 sm_mb_20 sm2_mb_20" id="select_section_div">
                                    <select class="niceSelect w-100 bb" id="select_section" name="promote_section">
                                        <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section')</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                    @if ($errors->has('promote_section'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('promote_section') }}</strong>
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
        @if (isset($students))
        <div class="row mt-40">
                

            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0">@lang('common.student_list') ( {{ isset($students) ? $students->count() : 0 }})</h3>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <table id="table_id_tt" class="display school-table" cellspacing="0" width="100%">
                            <thead>                               
                                <tr>
                                    <th>@lang('student.admission_no')</th>
                                    <th>@lang('student.roll_no')</th>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('common.class')</th>
                                    <th>@lang('student.father_name')</th>
                                    <th>@lang('common.date_of_birth')</th>
                                    <th>@lang('common.gender')</th>
                                    <th>@lang('common.type')</th>
                                    <th>@lang('common.phone')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($students as $data)
                                    @php
                                        $studentInfo=json_decode($data->student_info);
                                    @endphp
                                <tr>
                                    <td>{{$data->admission_number}}</td>
                                    <td>{{$data->previous_roll_number }}</td>
                                    <td>{{$studentInfo->full_name}}</td>
                                    <td>{{$class->class_name}} ( {{$section->section_name}} )</td>
                                    <td>{{@$data->student->parents->fathers_name }}</td>
                                    <td >{{ dateConvert(@$data->student->date_of_birth)}}</td>
                                    <td>{{@$data->student->gender->base_setup_name }}</td>
                                    <td>{{@$data->student->category->category_name}}</td>
                                    <td>{{@$data->student->mobile }}</td>                               
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

@endsection('mainContent')
