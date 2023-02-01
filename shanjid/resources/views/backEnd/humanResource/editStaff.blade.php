@extends('backEnd.master')
@section('title')
    @lang('hr.edit_staff')
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/backEnd/') }}/css/croppie.css">
@endsection
@section('mainContent')
    <style type="text/css">
        .form-control:disabled {
            background-color: #FFFFFF;
        }

    </style>
    <input type="text" hidden id="urlStaff" value="{{ route('staffProfileUpdate', $editData->id) }}">
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('hr.edit_staff')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="{{route('staff_directory')}}">@lang('hr.staff_list')</a>
                    <a href="{{route('editStaff', $editData->id)}}">@lang('hr.edit_staff')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('hr.edit_staff')</h3>
                    </div>
                </div>
            </div>
            @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'admin-dashboard', 'method' => 'GET', 'enctype' => 'multipart/form-data']) }}
            @else
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'staffUpdate', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-title">
                                        <h4>@lang('hr.basic_info')</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <hr>
                                </div>
                            </div>

                            <input type="hidden" name="staff_id" value="{{ @$editData->id }}" id="_id">
                            <div class="row mb-30 mt-20">
                                @if (in_array('staff_no', $has_permission))
                                    <div class="col-lg-3">
                                        <div class="input-effect">
                                            <input
                                                class="primary-input form-control{{ $errors->has('staff_no') ? ' is-invalid' : '' }}"
                                                type="text" name="staff_no" readonly value="@if (isset($editData)){{ $editData->staff_no }} @endif">
                                            <span class="focus-border"></span>
                                            <label>@lang('hr.staff_number')
                                                {{ in_array('staff_no', $is_required) ? '*' : '' }}</label>
                                            @if ($errors->has('staff_no'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('staff_no') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if (in_array('role', $has_permission))
                                    <div class="col-lg-3">
                                        <div class="input-effect">
                                            <select
                                                class="niceSelect w-100 bb form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}"
                                                name="role_id" id="role_id">
                                                @if ($editData->role_id != 1)
                                                    <option
                                                        data-display="@lang('hr.role') {{ in_array('role', $is_required) ? '*' : '' }}"
                                                        value="">@lang('common.select')
                                                        {{ in_array('role', $is_required) ? '*' : '' }}</option>

                                                    @foreach ($roles as $key => $value)
                                                        <option value="{{ $value->id }}" @if (isset($editData))
                                                            @if ($editData->role_id == $value->id)
                                                                selected
                                                            @endif
                                                        @endif
                                                        >{{ $value->name }}</option>
                                                    @endforeach
                                                @else

                                                    <option value="1">Superadmin</option>

                                                @endif
                                            </select>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('role_id'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('role_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if (in_array('department', $has_permission))
                                    <div class="col-lg-3">
                                        <div class="input-effect">
                                            <select
                                                class="niceSelect w-100 bb form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}"
                                                name="department_id" id="department_id">
                                                <option
                                                    data-display="@lang('hr.department') {{ in_array('department', $is_required) ? '*' : '' }}"
                                                    value="">@lang('common.select')
                                                    {{ in_array('department', $is_required) ? '*' : '' }}</option>
                                                @foreach ($departments as $key => $value)
                                                    <option value="{{ $value->id }}" @if (isset($editData))
                                                        @if ($editData->department_id == $value->id)
                                                            selected
                                                        @endif
                                                @endif
                                                >{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('department_id'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('department_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif 
                                @if (in_array('designation', $has_permission))   
                                    <div class="col-lg-3">
                                        <div class="input-effect">
                                            <select
                                                class="niceSelect w-100 bb form-control{{ $errors->has('designation_id') ? ' is-invalid' : '' }}"
                                                name="designation_id" id="designation_id">
                                                <option
                                                    data-display="@lang('hr.designation') {{ in_array('designation', $is_required) ? '*' : '' }}"
                                                    value="">@lang('common.select')
                                                    {{ in_array('designation', $is_required) ? '*' : '' }}</option>
                                                @foreach ($designations as $key => $value)
                                                    <option value="{{ $value->id }}" @if (isset($editData))
                                                        @if ($editData->designation_id == $value->id)
                                                            selected
                                                        @endif
                                                @endif
                                                >{{ $value->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('designation_id'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('designation_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-30">
                                @if (in_array('first_name', $has_permission))     
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                            type="text" name="first_name" value="@if (isset($editData)){{ $editData->first_name }} @endif">
                                        <span class="focus-border"></span>
                                        <label>@lang('hr.first_name') {{ in_array('first_name', $is_required) ? '*' : '' }}</label>
                                        @if ($errors->has('first_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if (in_array('last_name', $has_permission))  
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                            type="text" name="last_name" value="@if (isset($editData)){{ $editData->last_name }}@endif">
                                        <span class="focus-border"></span>
                                        <label>@lang('hr.last_name') {{ in_array('last_name', $is_required) ? '*' : '' }}</label>
                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if (in_array('fathers_name', $has_permission))  
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input form-control{{ $errors->has('fathers_name') ? ' is-invalid' : '' }}"
                                            type="text" name="fathers_name" value="@if (isset($editData)){{ $editData->fathers_name }}@endif">
                                        <span class="focus-border"></span>
                                        <label>@lang('student.father_name')
                                            {{ in_array('fathers_name', $is_required) ? '*' : '' }}</label>
                                        @if ($errors->has('fathers_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fathers_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                                @if (in_array('mothers_name', $has_permission))  
                                <div class="col-lg-3">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input form-control{{ $errors->has('mothers_name') ? ' is-invalid' : '' }}"
                                            type="text" name="mothers_name" value="@if (isset($editData)){{ $editData->mothers_name }}@endif">
                                        <span class="focus-border"></span>
                                        <label>@lang('student.mother_name')
                                            {{ in_array('mothers_name', $is_required) ? '*' : '' }}</label>
                                        @if ($errors->has('mothers_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('mothers_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @endif 
                               
                            </div>
                    <div class="row mb-30">
                        @if (in_array('email', $has_permission)) 
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input oninput="emailCheck(this)"
                                    class="primary-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    type="email" name="email" value="@if (isset($editData)){{ $editData->email }}@endif">
                                <span class="focus-border"></span>
                                <label>@lang('common.email') {{ in_array('email', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif 
                        @if (in_array('gender', $has_permission)) 
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <select
                                    class="niceSelect w-100 bb form-control{{ $errors->has('gender_id') ? ' is-invalid' : '' }}"
                                    name="gender_id">
                                    <option
                                        data-display="@lang('common.gender') {{ in_array('gender', $is_required) ? '*' : '' }}"
                                        value="">@lang('common.gender') {{ in_array('gender', $is_required) ? '*' : '' }}
                                    </option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->id }}" @if (isset($editData))
                                            @if ($editData->gender_id == $gender->id)
                                                selected
                                            @endif
                                    @endif
                                    >{{ $gender->base_setup_name }}</option>
                                    @endforeach
                                </select>
                                <span class="focus-border"></span>
                                @if ($errors->has('gender_id'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('gender_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif 
                        @if (in_array('date_of_birth', $has_permission)) 
                        <div class="col-lg-3">
                            <div class="no-gutters input-right-icon">
                                <div class="col">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input date form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}"
                                            id="startDate" type="text" name="date_of_birth"
                                            value="{{ date('m/d/Y', strtotime($editData->date_of_birth)) }}">
                                        <span class="focus-border"></span>
                                        <label>@lang('common.date_of_birth')
                                            {{ in_array('date_of_birth', $is_required) ? '*' : '' }}</label>
                                        @if ($errors->has('date_of_birth'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('date_of_birth') }}</strong>
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
                        </div>
                        @endif 
                        @if (in_array('date_of_joining', $has_permission)) 
                        <div class="col-lg-3">
                            <div class="no-gutters input-right-icon">
                                <div class="col">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input date form-control{{ $errors->has('date_of_joining') ? ' is-invalid' : '' }}"
                                            id="date_of_joining" type="text" name="date_of_joining"
                                            value="{{ date('m/d/Y', strtotime($editData->date_of_joining)) }} ">
                                        <span class="focus-border"></span>
                                        <label>@lang('hr.date_of_joining')
                                            {{ in_array('date_of_joining', $is_required) ? '*' : '' }}</label>
                                        @if ($errors->has('date_of_joining'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('date_of_joining') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="" type="button">
                                        <i class="ti-calendar" id="date_of_joining"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row mb-30">
                        @if (in_array('mobile', $has_permission)) 
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input oninput="phoneCheck(this)"
                                    class="primary-input form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                    type="text" name="mobile" value="@if (isset($editData)){{ $editData->mobile }}@endif">
                                <span class="focus-border"></span>
                                <label>@lang('common.mobile') {{ in_array('mobile', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if (in_array('marital_status', $has_permission)) 
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <select class="niceSelect w-100 bb form-control" name="marital_status">
                                    <option
                                        data-display="@lang('hr.marital_status') {{ in_array('marital_status', $is_required) ? '*' : '' }}"
                                        value="">@lang('hr.marital_status')
                                        {{ in_array('marital_status', $is_required) ? '*' : '' }}</option>
                                    <option value="married" {{ $editData->marital_status == 'married' ? 'selected' : '' }}>
                                        @lang('hr.married')</option>
                                    <option value="unmarried"
                                        {{ $editData->marital_status == 'unmarried' ? 'selected' : '' }}>@lang('hr.unmarried')
                                    </option>

                                </select>
                                <span class="focus-border"></span>
                            </div>
                        </div>
                        @endif
                        @if (in_array('emergency_mobile', $has_permission)) 
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input oninput="phoneCheck(this)"
                                    class="primary-input form-control{{ $errors->has('emergency_mobile') ? ' is-invalid' : '' }}"
                                    type="text" name="emergency_mobile" value="@if (isset($editData)){{ $editData->emergency_mobile }} @endif">
                                <span class="focus-border"></span>
                                <label>@lang('hr.emergency_mobile')
                                    {{ in_array('emergency_mobile', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('emergency_mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('emergency_mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if (in_array('driving_license', $has_permission)) 
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('driving_license') ? ' is-invalid' : '' }}"
                                    type="text" name="driving_license" value="{{ $editData->driving_license }}">
                                <span class="focus-border"></span>
                                <label>@lang('hr.driving_license')
                                    {{ in_array('driving_license', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('driving_license'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('driving_license') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    

                    <div class="row mb-20">
                        @if (in_array('staff_photo', $has_permission))
                            <div class="col-lg-6">
                                <div class="row no-gutters input-right-icon mb-20">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input
                                                class="primary-input form-control {{ $errors->has('staff_photo') ? ' is-invalid' : '' }}"
                                                id="placeholderStaffsName" type="text"
                                                placeholder="{{ $editData->staff_photo != '' ? getFilePath3($editData->staff_photo) : (in_array('staff_photo', $is_required) ? trans('hr.staff_photo') . '*' : trans('hr.staff_photo')) }}"
                                                readonly>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('staff_photo'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('staff_photo') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="primary-btn-small-input" type="button" id="pic">
                                            <label class="primary-btn small fix-gr-bg"
                                                for="staff_photo">@lang('common.browse')</label>
                                            <input type="file" class="d-none form-control" name="staff_photo"
                                                id="staff_photo">
                                        </button>

                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>


                    <div class="row mb-30">
                        @if (in_array('current_address', $has_permission))
                            <div class="col-lg-6">
                                <div class="input-effect">
                                    <textarea class="primary-input form-control" cols="0" rows="4" name="current_address"
                                        id="current_address">@if (isset($editData)){{ $editData->current_address }}@endif</textarea>
                                    <label>@lang('hr.current_address')
                                        {{ in_array('current_address', $is_required) ? '*' : '' }}</label>
                                    <span class="focus-border textarea "></span>
                                    @if ($errors->has('current_address'))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->first('current_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                       
                        @if (in_array('permanent_address', $has_permission)) 
                        <div class="col-lg-6">
                            <div class="input-effect">
                                <textarea class="primary-input form-control" cols="0" rows="4" name="permanent_address"
                                    id="permanent_address">@if (isset($editData)){{ $editData->permanent_address }}@endif</textarea>
                                <span class="focus-border textarea"></span>
                                <label>@lang('hr.permanent_address')
                                    {{ in_array('permanent_address', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('permanent_address'))
                                    <span class="danger text-danger">
                                        <strong>{{ $errors->first('permanent_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row mb-30">
                        @if (in_array('qualifications', $has_permission)) 
                        <div class="col-lg-6">
                            <div class="input-effect">
                                <textarea class="primary-input form-control" cols="0" rows="4" name="qualification"
                                    id="qualification">@if (isset($editData)){{ $editData->qualification }}@endif</textarea>
                                <span class="focus-border textarea"></span>
                                <label>@lang('hr.qualifications')
                                    {{ in_array('qualifications', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('qualification'))
                                    <span class="danger text-danger">
                                        <strong>{{ $errors->first('qualification') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if (in_array('experience', $has_permission)) 
                        <div class="col-lg-6">
                            <div class="input-effect">
                                <textarea class="primary-input form-control" cols="0" rows="4" name="experience"
                                    id="experience">@if (isset($editData)){{ $editData->experience }}@endif
                                        </textarea>
                                <span class="focus-border textarea"></span>
                                <label>@lang('hr.experience') {{ in_array('experience', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('experience'))
                                    <span class="danger text-danger">
                                        <strong>{{ $errors->first('experience') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    @if(moduleStatusCheck('Lms'))

                    <div class="row mb-30">
                       
                        @if (in_array('staff_bio', $has_permission)) 
                        <div class="col-lg-12">
                            <div class="input-effect">
                                <textarea class="primary-input form-control" cols="0" rows="6" name="staff_bio"
                                    id="staff_bio">@if (isset($editData)){{ $editData->staff_bio }}@endif
                                        </textarea>
                                <span class="focus-border textarea"></span>
                                <label>@lang('staff.staff_bio')
                                    {{ in_array('staff_bio', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('staff_bio'))
                                    <span class="danger text-danger">
                                        <strong>{{ $errors->first('staff_bio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                       
                    </div>
                    @endif


                    <div class="row mt-40">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h4>@lang('hr.payroll_details')</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-lg-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row mb-30 mt-20">
                        @if (in_array('epf_no', $has_permission)) 
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('epf_no') ? ' is-invalid' : '' }}"
                                    type="text" name="epf_no" value="{{ $editData->epf_no }}">
                                <span class="focus-border"></span>
                                <label>@lang('hr.epf_no') {{ in_array('epf_no', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('epf_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('epf_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if (in_array('basic_salary', $has_permission)) 
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input oninput="numberCheckWithDot(this)"
                                    class="primary-input form-control{{ $errors->has('basic_salary') ? ' is-invalid' : '' }}"
                                    type="text" name="basic_salary" value="{{ $editData->basic_salary }}">
                                <span class="focus-border"></span>
                                <label>@lang('hr.basic_salary')
                                    {{ in_array('basic_salary', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('basic_salary'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('basic_salary') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if (in_array('contract_type', $has_permission))
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <select class="niceSelect w-100 bb form-control" name="contract_type">
                                    <option
                                        data-display="@lang('common.select') {{ in_array('contract_type', $is_required) ? '*' : '' }}"
                                        value="">@lang('common.select')
                                        {{ in_array('contract_type', $is_required) ? '*' : '' }}</option>
                                    <option value="permanent" @if (isset($editData))
                                        @if ($editData->contract_type == 'permanent')
                                            selected
                                        @endif
                                        @endif
                                        >@lang('hr.permanent')
                                    </option>
                                    <option value="contract" @if (isset($editData))
                                        @if ($editData->contract_type == 'contract')
                                            selected
                                        @endif
                                        @endif
                                        > @lang('hr.contract')
                                    </option>
                                </select>
                                <span class="focus-border"></span>

                            </div>
                        </div>
                        @endif
                        @if (in_array('location', $has_permission))
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('location') ? ' is-invalid' : '' }}"
                                    type="text" name="location" value="{{ $editData->location }}">
                                <span class="focus-border"></span>
                                <label>@lang('hr.location') {{ in_array('location', $is_required) ? '*' : '' }}</label>
                                @if ($errors->has('location'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                       
                    </div>
                    <div class="row mt-40 mt-20">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h4>@lang('hr.location')</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row mb-20">
                        @if (in_array('bank_account_name', $has_permission))
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('bank_account_name') ? ' is-invalid' : '' }}"
                                    type="text" name="bank_account_name" value="{{ $editData->bank_account_name }}">
                                <span class="focus-border"></span>
                                <label>@lang('hr.bank_account_name')
                                    {{ in_array('bank_account_name', $is_required) ? '*' : '' }}</label>
                            </div>
                        </div>
                        @endif
                        @if (in_array('bank_account_no', $has_permission))
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('bank_account_no') ? ' is-invalid' : '' }}"
                                    type="text" name="bank_account_no" value="{{ $editData->bank_account_no }}">
                                <span class="focus-border"></span>
                                <label>@lang('accounts.account_no')
                                    {{ in_array('bank_account_no', $is_required) ? '*' : '' }}</label>
                            </div>
                        </div>
                        @endif
                        @if (in_array('bank_name', $has_permission))
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('bank_name') ? ' is-invalid' : '' }}"
                                    type="text" name="bank_name" value="{{ $editData->bank_name }}">
                                <span class="focus-border"></span>
                                <label>@lang('accounts.bank_name')
                                    {{ in_array('bank_name', $is_required) ? '*' : '' }}</label>
                            </div>
                        </div>
                        @endif
                        @if (in_array('bank_brach', $has_permission))
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('bank_brach') ? ' is-invalid' : '' }}"
                                    type="text" name="bank_brach" value="{{ $editData->bank_brach }}">
                                <span class="focus-border"></span>
                                <label>@lang('hr.branch_name')
                                    {{ in_array('bank_brach', $is_required) ? '*' : '' }}</label>
                            </div>
                        </div>
                        @endif
                      
                    </div>

                    <div class="row mt-40 mt-20">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h4>@lang('hr.social_links_details')</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row mb-20">
                        @if (in_array('facebook', $has_permission))
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('facebook_url') ? ' is-invalid' : '' }}"
                                    type="text" name="facebook_url" value="{{ $editData->facebook_url }}">
                                <span class="focus-border"></span>
                                <label>@lang('hr.facebook_url')
                                    {{ in_array('facebook', $is_required) ? '*' : '' }}</label>
                            </div>
                        </div>
                        @endif
                        @if (in_array('twitter', $has_permission))
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('twiteer_url') ? ' is-invalid' : '' }}"
                                    type="text" name="twiteer_url" value="{{ $editData->twiteer_url }}">
                                <span class="focus-border"></span>
                                <label>@lang('hr.twitter_url') {{ in_array('twitter', $is_required) ? '*' : '' }}</label>
                            </div>
                        </div>
                        @endif
                        @if (in_array('linkedin', $has_permission))
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('linkedin_url') ? ' is-invalid' : '' }}"
                                    type="text" name="linkedin_url" value="{{ $editData->linkedin_url }}">
                                <span class="focus-border"></span>
                                <label>@lang('hr.linkedin_url')
                                    {{ in_array('linkedin', $is_required) ? '*' : '' }}</label>
                            </div>
                        </div>
                        @endif
                        @if (in_array('instagram', $has_permission))
                        <div class="col-lg-3">
                            <div class="input-effect">
                                <input
                                    class="primary-input form-control{{ $errors->has('instragram_url') ? ' is-invalid' : '' }}"
                                    type="text" name="instragram_url" value="{{ $editData->instragram_url }}">
                                <span class="focus-border"></span>
                                <label>@lang('hr.instragram_url')
                                    {{ in_array('instagram', $is_required) ? '*' : '' }}</label>
                            </div>
                        </div>
                        @endif
                        

                    </div>

                    <div class="row mt-40 mt-20">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h4>@lang('hr.document_info')</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row mb-20">
                        @if (in_array('resume', $has_permission))
                        <div class="col-lg-4">
                            <div class="row no-gutters input-right-icon mb-20">
                                <div class="col">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input form-control {{ $errors->has('resume') ? ' is-invalid' : '' }}"
                                            type="text"
                                            placeholder="{{ isset($editData->resume) && $editData->resume != '' ? getFilePath3($editData->resume) : (in_array('resume', $is_required) ? trans('hr.resume') . '*' : trans('hr.resume')) }}"
                                            readonly id="placeholderResume">
                                        <span class="focus-border"></span>
                                        @if ($errors->has('resume'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('resume') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                            for="resume">@lang('common.browse')</label>
                                        <input type="file" class="d-none form-control" name="resume" id="resume">
                                    </button>

                                </div>
                            </div>
                        </div>
                        @endif
                        @if (in_array('joining_letter', $has_permission))
                        <div class="col-lg-4">
                            <div class="row no-gutters input-right-icon mb-20">
                                <div class="col">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input form-control {{ $errors->has('joining_letter') ? ' is-invalid' : '' }}"
                                            type="text"
                                            placeholder="{{ isset($editData->joining_letter) && $editData->joining_letter != '' ? getFilePath3($editData->joining_letter) : (in_array('joining_letter', $is_required) ? trans('hr.joining_letter') . '*' : trans('hr.joining_letter')) }}"
                                            readonly id="placeholderJoiningLetter">
                                        <span class="focus-border"></span>
                                        @if ($errors->has('joining_letter'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('joining_letter') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                            for="joining_letter">@lang('common.browse')</label>
                                        <input type="file" class="d-none form-control" name="joining_letter"
                                            id="joining_letter">
                                    </button>

                                </div>
                            </div>
                        </div>
                        @endif
                        @if (in_array('other_documents', $has_permission))
                        <div class="col-lg-4">
                            <div class="row no-gutters input-right-icon mb-20">
                                <div class="col">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input form-control {{ $errors->has('other_document') ? ' is-invalid' : '' }}"
                                            type="text"
                                            placeholder="{{ isset($editData->other_document) && $editData->other_document != '' ? getFilePath3($editData->joining_letter) : (in_array('other_documents', $is_required) ? trans('hr.other_documents') . '*' : trans('hr.other_documents')) }}"
                                            readonly id="placeholderOthersDocument">
                                        <span class="focus-border"></span>
                                        @if ($errors->has('other_document'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('other_document') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                            for="other_document">@lang('common.browse')</label>
                                        <input type="file" class="d-none form-control" name="other_document"
                                            id="other_document">
                                    </button>

                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    {{-- Custom Field Start --}}
                    <div class="row mt-40">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h4>@lang('hr.custom_field')</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <hr>
                        </div>
                    </div>
                    @if (in_array('custom_fields', $has_permission))
                        @include('backEnd.studentInformation._custom_field')
                    @endif

                    {{-- Custom Field End --}}


                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            @if (Illuminate\Support\Facades\Config::get('app.app_sync'))
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo ">
                                    <button class="primary-btn small fix-gr-bg  demo_view" style="pointer-events: none;"
                                        type="button"> @lang('hr.update_staff')</button></span>
                            @else
                                <button class="primary-btn fix-gr-bg submit">
                                    <span class="ti-check"></span>
                                    @lang('hr.update_staff')
                                </button>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        {{ Form::close() }}
        </div>
    </section>


    <div class="modal" id="LogoPic">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">@lang('hr.crop_image_and_upload')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="resize"></div>
                    <button class="btn rotate float-lef" data-deg="90">
                        <i class="ti-back-right"></i></button>
                    <button class="btn rotate float-right" data-deg="-90">
                        <i class="ti-back-left"></i></button>
                    <hr>
                    <a href="javascript:;" class="primary-btn fix-gr-bg pull-right" id="upload_logo">@lang('hr.crop')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('public/backEnd/') }}/js/croppie.js"></script>
    <script src="{{ asset('public/backEnd/') }}/js/editStaff.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '.cutom-photo', function() {
                let v = $(this).val();
                let v1 = $(this).data("id");
                console.log(v, v1);
                getFileName(v, v1);
            });

            function getFileName(value, placeholder) {
                if (value) {
                    var startIndex = (value.indexOf('\\') >= 0 ? value.lastIndexOf('\\') : value.lastIndexOf('/'));
                    var filename = value.substring(startIndex);
                    if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                        filename = filename.substring(1);
                    }
                    $(placeholder).attr('placeholder', '');
                    $(placeholder).attr('placeholder', filename);
                }
            }
        })
    </script>
@endsection
