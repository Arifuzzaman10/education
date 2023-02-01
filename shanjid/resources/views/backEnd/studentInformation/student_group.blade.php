@extends('backEnd.master')
@section('title') 
@lang('student.student_group')
@endsection

@section('mainContent')
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('student.student_group')</h1>
            <div class="bc-pages">
                <a href="{{url('admin-dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('student.student_information')</a>
                <a href="#">@lang('student.student_group')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($student_group))
         @if(userPermission(77))
                       
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('student_group')}}" class="primary-btn small fix-gr-bg">
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
                            <h3 class="mb-30">@if(isset($student_group))
                                    @lang('student.edit_student_group')
                                @else
                                    @lang('student.add_student_group')
                                @endif
                             
                            </h3>
                        </div>
                        @if(isset($student_group))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_group_update',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @else
                          @if(userPermission(77))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_group_store',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                       
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('group') ? ' is-invalid' : '' }}"
                                                type="text" name="group" autocomplete="off" value="{{isset($student_group)? $student_group->group: old('group')}}">
                                            <input type="hidden" name="id" value="{{isset($student_group)? $student_group->id: ''}}">
                                            <label>@lang('student.group') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('group'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('group') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                @php 
                                  $tooltip = "";
                                  if(userPermission(77)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($student_group))
                                                @lang('student.update_group')
                                            @else
                                                @lang('student.save_group')
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
                            <h3 class="mb-0">@lang('student.student_group_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                               
                                <tr>
                                    <th>@lang('student.group')</th>
                                    <th>@lang('student.students')</th>
                                    <th>@lang('common.actions')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($student_groups as $student_group)
                                <tr>
                                    <td>{{$student_group->group}}</td>
                                    <td>{{@$student_group->students_count}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(79))
                                                <a class="dropdown-item" href="{{route('student_group_edit', [$student_group->id])}}">@lang('common.edit')</a>
                                               @endif
                                               @if(userPermission(80))
                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteStudentGroupModal{{$student_group->id}}"
                                                    href="#">@lang('common.delete')</a>
                                            @endif
                                                </div>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade admin-query" id="deleteStudentGroupModal{{$student_group->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('student.delete_group')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                    <a href="{{route('student_group_delete', [$student_group->id])}}"><button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button></a>
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
