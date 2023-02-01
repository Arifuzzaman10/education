@extends('backEnd.master')
@section('title')
@lang('rolepermission::role.login_permission')
@endsection
@section('mainContent')
<link rel="stylesheet" href="{{asset('public/backEnd/css/login_access_control.css')}}"/>
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('rolepermission::role.login_permission') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('rolepermission::role.role_permission')</a>
                <a href="#">@lang('rolepermission::role.login_permission')</a>
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
                <div class="row">
                    <div class="col-lg-12">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'login-access-control', 'enctype' => 'multipart/form-data', 'method' => 'POST']) }}
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12 mb-20">
                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" id="member_type">
                                            <option data-display=" @lang('common.select_role') *" value="">@lang('common.select_role') *</option>
                                            @foreach($roles as $value)
                                                <option value="{{@$value->id}}">{{@$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="forStudentWrapper col-lg-12">
                                        <div class="row">
                                            @if(moduleStatusCheck('University'))
                                            @includeIf('university::common.session_faculty_depart_academic_semester_level',['hide'=>['USUB','USN'], 'slb_mt'=>'mt-25', 'se_mt'=>'mt-0', 'mt'=>'mt-25'])
                                            @else 
                                                <div class="col-lg-6 mb-30">
                                                    <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                                        <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class')*</option>
                                                        @foreach($classes as $class)
                                                        <option value="{{@$class->id}}"  {{( old("class") == @$class->id ? "selected":"")}}>{{@$class->class_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-6 mb-30" id="select_section_div">
                                                    <select class="w-100 bb niceSelect form-control{{ $errors->has('section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                                        <option data-display="@lang('common.select_section')" value="">@lang('common.select_section') *</option>
                                                    </select>
                                                </div>
                                            @endif

                                        </div>
                                    </div>



                                    <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">

                                </div>

                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                        <span class="ti-search pr-2"></span>
                                        @lang('common.search')
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        @if(isset($students))
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-3">@lang('common.student_list') ({{@$students->count()}})</h3>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 table-responsive">
                            <table id="" class="display school-table school-table-style" cellspacing="0" width="100%">

                                <thead>
                                    <tr>
                                        <th>@lang('student.admission') </th>
                                        <th>@lang('student.roll')</th>
                                        <th>@lang('common.name')</th>
                                        <th>@lang('common.class')</th>

                                        <th>@lang('rolepermission::role.student_permission')</th>
                                        <th>@lang('rolepermission::role.student_password')</th>

                                        <th>@lang('rolepermission::role.parents_permission')</th>
                                        <th>@lang('rolepermission::role.parents_password')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($students as $student)
                                    <tr id="{{@$student->user_id}}">
                                        
                                        <td>
                                            <input type="hidden" id="id" value="{{@$student->user_id}}">
                                            <input type="hidden" id="role" value="{{@$role}}">
                                             {{@$student->admission_no}}
                                        </td>
                                        <td> {{@$student->roll_no}}</td>
                                        <td>{{@$student->first_name.' '.@$student->last_name}}  </td>
                                        <td>
                                            @foreach($student->studentRecords as $record)
                                            {{!empty(@$record->class)?@$record->class->class_name:''}} ({{!empty(@$record->section)?@$record->section->section_name:''}})
                                            @endforeach
                                            
                                        </td>
                                        <td>
                                            <input type="hidden" name="id" value="{{$student->user_id}}">
                                            <label class="switch">
                                                @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                     <input type="checkbox" disabled id="ch{{@$student->user_id}}" onclick="lol({{@$student->user_id}},{{@$role}})" class="switch-input11" {{@$student->user->access_status == 0? '':'checked'}} >
                                                        <span class="slider round" data-toggle="tooltip" title="Disabled For Demo"></span>
                                                        @else 
                                                        <input type="checkbox" id="ch{{@$student->user_id}}" onclick="lol({{@$student->user_id}},{{@$role}})" class="switch-input11" {{@$student->user->access_status == 0? '':'checked'}}>
                                                        <span class="slider round"></span>
                                                     @endif
                                            
                                            </label>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'reset-student-password', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                                <input type="hidden" name="id" value="{{@$student->user_id}}">
                                                <div class="row mt-10">
                                                    <div class="col-lg-6">
                                                        <div class="input-effect md_mb_20">
                                                            <input class="primary-input read-only-input" type="text" name="new_password" required="true" minlength="6">
                                                            <label>@lang('common.password')</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo "> 
                                                            <button class="primary-btn small tr-bg icon-only mt-10" style="pointer-events: none;" type="button" ><span class="ti-save"> </button>
                                                        </span>
                                                    
                                                        @else 
        
                                                        <button type="submit" class="primary-btn small tr-bg icon-only mt-10"  data-toggle="tooltip" title="@lang('rolepermission::role.update_password')" >
                                                            <span class="ti-save"></span>
                                                        </button>
        
                                                        @endif

                                                        <button data-toggle="tooltip" title="Reset Password as Default" type="button" class="primary-btn small tr-bg icon-only mt-10" onclick="changePassword({{@$student->user_id}},{{@$role}})" >
                                                            <span class="ti-reload"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            {{ Form::close() }}
                                        </td>
                                        <td>

                                            <input type="hidden" name="ParentID" value="{{@$student->parents->user_id}}" id="ParentID">
                                           
                                            <label class="switch">
                                                @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                    <input type="checkbox" disabled class="parent-login-disable" {{@$student->parents->parent_user->access_status == 0? '':'checked'}}>
                                                     <span class="slider round" data-toggle="tooltip" title="Disabled For Demo"></span>
                                                    @else 

                                                    <input type="checkbox" class="parent-login-disable" {{@$student->parents->parent_user->access_status == 0? '':'checked'}}>
                                                     <span class="slider round"></span>

                                                @endif
                                            </label>

                                        </td>
                                        <td style="white-space: nowrap;">
                                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'reset-student-password', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                                <input type="hidden" name="id" value="{{@$student->parents->user_id}}">
                                                <div class="row mt-10">
                                                    <div class="col-lg-6">
                                                        <div class="input-effect md_mb_20">
                                                            <input class="primary-input read-only-input" type="text" name="new_password" required="true" minlength="6">
                                                            <label>@lang('common.password')</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                         @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo "> 
                                                    <button class="primary-btn small tr-bg icon-only mt-10" style="pointer-events: none;" type="button" ><span class="ti-save"> </button>
                                                </span>
                                            
                                                @else 

                                                <button type="submit" class="primary-btn small tr-bg icon-only mt-10"  data-toggle="tooltip" title="@lang('rolepermission::role.update_password')" >
                                                    <span class="ti-save"></span>
                                                </button>

                                                @endif
                                                        <button data-toggle="tooltip" title="Reset Password as Default" type="button" class="primary-btn small tr-bg icon-only mt-10"
                                                        onclick="changePassword({{@$student->parents->user_id}},{{@$role}})" >
                                                            <span class="ti-reload"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            {{ Form::close() }}
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

        @if(isset($staffs))
             <div class="row mt-40">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4 no-gutters">
                    <div class="main-title">
                        <h3 class="mb-0">@lang('hr.staff_list')</h3>
                    </div>
                </div>
            </div>

         <div class="row">
                <div class="col-lg-12">
                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>@lang('hr.staff_no')</th>
                                <th>@lang('common.name')</th>
                                <th>@lang('common.role')</th>
                                <th>@lang('common.email')</th>
                                <th>@lang('rolepermission::role.login_permission')</th>
                                <th>@lang('common.password')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($staffs as $value)
                            <tr id="{{@$value->user_id}}">
                                <input type="hidden" id="id" value="{{@$value->user_id}}">
                                <input type="hidden" id="role" value="{{@$role}}">
                                <td>{{@$value->staff_no}}</td>
                                <td>{{@$value->first_name}}&nbsp;{{@$value->last_name}}</td>
                                <td>{{!empty(@$value->roles->name)?@$value->roles->name:''}}</td>
                                <td>{{@$value->email}}</td>
                                <td>
                                    @php
                                        if(@$value->staff_user->access_status == 0){
                                                $permission_id=422;
                                        }else{
                                                $permission_id=423;
                                        }
                                    @endphp
                                    @if(userPermission($permission_id))
                                    <label class="switch">
                                        @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                            <input type="checkbox" disabled class="switch-input" {{@$value->staff_user->access_status == 0? '':'checked'}}>
                                            <span class="slider round" data-toggle="tooltip" title="Disabled For Demo"></span>
                                            @else 
                                            <input type="checkbox" class="switch-input" {{@$value->staff_user->access_status == 0? '':'checked'}}>
                                            <span class="slider round"></span>
                                            @endif
                                    </label>
                                    @endif
                                </td>
                                <td style="white-space: nowrap;">
                                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'reset-student-password', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                                        <input type="hidden" name="id" value="{{$value->user_id}}">
                                        <div class="row mt-10">
                                            <div class="col-lg-6">
                                                <div class="input-effect md_mb_20">
                                                    <input class="primary-input read-only-input" type="text" name="new_password" required="true" minlength="6">
                                                    <label>@lang('common.password')</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo "> 
                                                    <button class="primary-btn small tr-bg icon-only mt-10" style="pointer-events: none;" type="button" ><span class="ti-save"> </button>
                                                </span>
                                            
                                                @else 

                                                <button type="submit" class="primary-btn small tr-bg icon-only mt-10"  data-toggle="tooltip" title="@lang('rolepermission::role.update_password')" >
                                                    <span class="ti-save"></span>
                                                </button>

                                                @endif

                                                <button data-toggle="tooltip" title="Reset Password as Default" type="button" class="primary-btn small tr-bg icon-only mt-10"
                                                onclick="changePassword({{@$value->user_id}},{{@$role}})" >
                                                    <span class="ti-reload"></span>
                                                </button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
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

        @if(isset($parents))
            <div class="row mt-40">


                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">@lang('common.parents_list')</h3>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <table id="table_id" class="display school-table" cellspacing="0" width="100%">
                                <thead>
                                   
                                    <tr>
                                        <th>@lang('student.guardian_phone') </th>
                                        <th>@lang('student.father_name') </th>
                                        <th>@lang('student.father_phone') </th>
                                        <th>@lang('student.mother_name') </th>
                                        <th>@lang('student.mother_phone') </th>
                                        <th>@lang('rolepermission::role.login_permission')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($parents as $parent)
                                    <tr id="{{@$parent->user_id}}">
                                        <input type="hidden" id="id" value="{{@$parent->user_id}}">
                                        <input type="hidden" id="role" value="{{@$role}}">
                                        <td>{{@$parent->guardians_mobile}}</td>
                                        <td>{{@$parent->fathers_name}}</td>
                                        <td>{{@$parent->fathers_mobile}}</td>
                                        <td>{{@$parent->mothers_name}}</td>
                                        <td>{{@$parent->mothers_mobile}}</td>
                                        <td>
                                            @php
                                                if(@$value->staff_user->access_status == 0){
                                                    $permission_id=422;
                                                }else{
                                                    $permission_id=423;
                                                }
                                            @endphp
                                            @if(userPermission($permission_id))
                                            <label class="switch">
                                              <input type="checkbox" class="switch-input" {{@$parent->parent_user->access_status == 0? '':'checked'}}>
                                              <span class="slider round"></span>
                                            </label>
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
</div>
</div>
</div>
</section>



@endsection
