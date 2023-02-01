@extends('backEnd.master')
@section('title')
@lang('common.academic_year')
@endsection
@section('mainContent')

<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('common.academic_year')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('system_settings.system_settings')</a>
                <a href="#">@lang('common.academic_year')</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($academic_year))
            @if(userPermission(433))
            <div class="row">
                <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                    <a href="{{route('academic-year')}}" class="primary-btn small fix-gr-bg">
                        <span class="ti-plus pr-2"></span>
                        @lang('common.add')
                    </a>
                </div>
            </div>
            @endif
        @endif
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($academic_year))
                                    @lang('system_settings.edit_academic_year')
                                @else
                                    @lang('system_settings.add_academic_year')
                                @endif
                               
                            </h3>
                        </div>
                        @if(isset($academic_year))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('academic-year-update',@$academic_year->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                        @if(userPermission(433))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'academic-year',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('year') ? ' is-invalid' : '' }}"
                                                type="text" name="year" autocomplete="off" value="{{isset($academic_year)? @$academic_year->year:''}}">
                                            <input type="hidden" name="id" value="{{isset($academic_year)? @$academic_year->id: ''}}">
                                            <label>@lang('common.year') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('year'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('year') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="row mt-40">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                type="text" name="title" autocomplete="off" value="{{isset($academic_year)? @$academic_year->title:old('academic_year')}}">
                                            <input type="hidden" name="id" value="{{isset($academic_year)? @$academic_year->id: ''}}">
                                            <label> @lang('system_settings.year_title')<span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-gutters input-right-icon mt-40">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input date form-control{{ $errors->has('starting_date') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                                placeholder=" @lang('system_settings.starting_date') *" name="starting_date" value="{{isset($academic_year)? date('m/d/Y',strtotime($academic_year->starting_date)): date('01/01/Y')}}">

                                            <label>@lang('system_settings.starting_date')<span class="focus-border"></span>
                                            @if ($errors->has('starting_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('starting_date') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row no-gutters input-right-icon mt-40">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input date form-control{{ $errors->has('ending_date') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                                placeholder="@lang('system_settings.ending_date')*" name="ending_date" value="{{isset($academic_year)? date('m/d/Y',strtotime($academic_year->ending_date)): date('12/31/Y')}}">

                                            <label>@lang('system_settings.ending_date')<span>*</span></label>
                                                <span class="focus-border"></span>
                                            @if ($errors->has('ending_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('ending_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                @php
                                if (isset($academic_year)) {
                                    $copy_with_academic_year=explode(',',@$academic_year->copy_with_academic_year);
                                }
                                @endphp
                                <div class="row no-gutters input-right-icon mt-40">
                                    <label for="checkbox" class="mb-2">@lang('system_settings.copy_with_academic_year')</label>
                                    <select multiple id="e1" name="copy_with_academic_year[]" style="width:300px">
                                        <option value="App\SmClass"  @if (isset($academic_year)) @if (in_array("App\SmClass", @$copy_with_academic_year)) selected @endif @endif >@lang('common.class') </option>
                                        <option value="App\SmSection" @if (isset($academic_year)) @if (in_array("App\SmSection", @$copy_with_academic_year)) selected @endif @endif >@lang('common.section')</option>
                                        <option value="App\SmSubject" @if (isset($academic_year)) @if (in_array("App\SmSubject", @$copy_with_academic_year)) selected @endif @endif >@lang('common.subject')</option>
                                        <option value="App\SmExamType" @if (isset($academic_year)) @if (in_array("App\SmExamType", @$copy_with_academic_year)) selected @endif @endif >@lang('exam.exam_type') </option>
                                        <option value="App\SmStudentCategory" @if (isset($academic_year)) @if (in_array("App\SmStudentCategory", @$copy_with_academic_year)) selected @endif @endif >@lang('student.student_category')</option>
                                        <option value="App\SmFeesGroup" @if (isset($academic_year)) @if (in_array("App\SmFeesGroup", @$copy_with_academic_year)) selected @endif @endif >@lang('fees.fees_group')</option>
                                        <option value="App\SmLeaveType" @if (isset($academic_year)) @if (in_array("App\SmLeaveType", @$copy_with_academic_year)) selected @endif @endif >@lang('leave.leave_type')</option>
                                    </select>
                                    <div class="">
                                    <input type="checkbox" id="checkbox" class="common-checkbox">
                                    <label for="checkbox" class="mt-3">@lang('common.select_all') </label>
                                    </div>
                                </div>

                                @php
                                    $tooltip = "";
                                    if(userPermission(433)){
                                            $tooltip = "";
                                        }else{
                                            $tooltip = "You have no permission to add";
                                        }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{@$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($academic_year))
                                                @lang('common.update')
                                            @else
                                                @lang('common.save')
                                            @endif

                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-4 no-gutters">
                        <div class="main-title">
                            <h3 class="mb-0"> @lang('system_settings.academic_year_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                               
                                <tr>
                                    <th>@lang('common.year')</th>
                                    <th>@lang('common.title')</th>
                                    <th>@lang('system_settings.starting_date')</th>
                                    <th>@lang('system_settings.ending_date')</th>
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach(academicYears() as $academic_year)
                                <tr>
                                    <td>{{@$academic_year->year}}</td>
                                    <td>{{@$academic_year->title}}</td>
                                    <td  data-sort="{{strtotime(@$academic_year->starting_date)}}" >
                                        {{@$academic_year->starting_date != ""? dateConvert(@$academic_year->starting_date):''}}

                                    </td>
                                    <td  data-sort="{{strtotime(@$academic_year->ending_date)}}" >
                                       {{@$academic_year->ending_date != ""? dateConvert(@$academic_year->ending_date):''}}

                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(434))
                                                <a class="dropdown-item" href="{{route('academic-year-edit', [@$academic_year->id])}}">@lang('common.edit')</a>
                                                @endif
                                                @if(userPermission(435))
                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteAcademicYearModal{{@$academic_year->id}}"
                                                    href="#">@lang('common.delete')</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                               <!--  -->

                                <div class="modal fade admin-query" id="deleteAcademicYearModal{{@$academic_year->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('system_settings.delete_academic_year')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                    <h5 class="text-danger">( @lang('system_settings.academic_year_delete_confirmation') )</h5>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>

                                                    {{ Form::open(['route' => array('academic-year-delete',@$academic_year->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                 <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                                                 {{ Form::close() }}

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
