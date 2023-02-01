@extends('backEnd.master')
@section('title')
    @lang('lang.virtual_class') @lang('lang.reports')
@endsection

@section('css')
<style>
    .propertiesname{
        text-transform: uppercase;
    }.
    .recurrence-section-hide {
       display: none!important
    }
    </style>
@endsection

@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.virtual_class') @lang('lang.reports') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.virtual_class')</a>
                <a href="#"> @lang('lang.reports') </a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-10">
                <h3 class="mb-30">
                    @lang('lang.virtual_class') @lang('lang.reports')
                </h3>
            </div>
        </div>
        <div class="row mb-20">
            <div class="col-lg-12">
                <div class="white-box">
                    <form action="{{ route('zoom.virtual.class.reports.show') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-2 mt-30-md">
                                    <select class="w-100 niceSelect bb form-control {{ $errors->has('class_id') ? ' is-invalid' : '' }}" id="select_class" name="class_id">
                                        <option data-display="@lang('lang.select_class') *" value="">@lang('lang.select_class')</option>
                                        @foreach($classes as $class)
                                            @if (isset($class_id) )
                                                <option value="{{$class->id}}" {{ $class_id == $class->id? 'selected':'' }}>{{$class->class_name}}</option>
                                            @else
                                                <option value="{{$class->id}}" >{{$class->class_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 mt-30-md" id="select_section_div">
                                    <select class="w-100 niceSelect bb form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }}" id="select_section" name="section_id">
                                        <option data-display="@lang('lang.select_section')" value="">@lang('lang.select_section')</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                </div>
                                @if(Auth::user()->role_id == 1)
                                    <div class="col-lg-2 mt-30-md">
                                        <select class="w-100 niceSelect bb form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }}" name="teachser_ids">
                                            <option data-display="@lang('lang.select_teacher')" value="">@lang('lang.select_teacher')</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{$teacher->id }}" {{ isset($teachser_ids) == $teacher->id? 'selected':'' }} >{{$teacher->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-lg-3 mt-30-md">
                                    <input data-display="@lang('lang.from_date')" placeholder="@lang('lang.from_date')" class="primary-input date form-control" type="text" name="from_time" value="{{ isset($from_time) ? Carbon\Carbon::parse($from_time)->format('m/d/Y') : '' }}">
                                </div>
                                <div class="col-lg-3 mt-30-md">
                                    <input data-display="@lang('lang.to_date')" placeholder="@lang('lang.to_date')" class="primary-input date form-control" type="text" name="to_time" value="{{ isset($to_time) ? Carbon\Carbon::parse($to_time)->format('m/d/Y') : '' }}">
                                </div>
                                @php
                                    $tooltip = "";
                                        if(userPermission(566))
                                        {
                                            $tooltip = "";
                                        }else{
                                            $tooltip = "You have no permission to search";
                                        }
                                @endphp
                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg" data-toggle="tooltip" title="{{$tooltip}}">
                                        <span class="ti-search pr-2"></span>
                                        @lang('lang.search')
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area" style="display:  {{ isset($meetings) ? 'block' : 'none'  }} ">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <table id="default_table2" class="display school-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4)
                                        <th>@lang('lang.class')</th>
                                        <th>@lang('lang.class_section')</th>
                                    @endif
                                    <th>@lang('lang.meeting_id')</th>
                                    <th>@lang('lang.password')</th>
                                    <th>@lang('lang.topic')</th>
                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4)
                                        <th>@lang('lang.teachers')</th>
                                    @endif
                                    <th>@lang('lang.date')</th>
                                    <th>@lang('lang.time')</th>
                                    <th>@lang('lang.duration')</th>
                                </tr>
                        </thead>

                        <tbody>
                            @if (isset($meetings))
                                @foreach($meetings as $key => $meeting )
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4)
                                        <td>{{ $meeting->class->class_name }}</td>
                                        <td>{{ $meeting->section->section_name }}</td>
                                    @endif
                                    <td>{{ $meeting->meeting_id }}</td>
                                    <td>{{ $meeting->password }}</td>
                                    <td>{{ $meeting->topic }}  </td>
                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 4)
                                        <td>{{ $meeting->teachersName }}</td>
                                    @endif
                                    <td>{{ $meeting->date_of_meeting }}</td>
                                    <td>{{ $meeting->time_of_meeting }}</td>
                                    <td>{{ $meeting->meeting_duration }} Min</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            </div>

        </div>
    </div>
</section>
@endsection
