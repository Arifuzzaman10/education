@extends('backEnd.master')
@section('title') 
@lang('student.student_category')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('student.student_category')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('student.student_information')</a>
                <a href="#">@lang('student.student_category')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($student_type))
         @if(userPermission(72))
                       
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('student_category')}}" class="primary-btn small fix-gr-bg">
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
                            <h3 class="mb-30">@if(isset($student_type))
                                    @lang('student.edit_student_category')
                                @else
                                    @lang('student.add_student_category')
                                @endif
                             
                            </h3>
                        </div>
                        @if(isset($student_type))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_category_update',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @else
                         @if(userPermission(72))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student_category_store',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                      
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('category') ? ' is-invalid' : '' }}"
                                                type="text" name="category" autocomplete="off" value="{{isset($student_type)? $student_type->category_name:''}}">
                                            <input type="hidden" name="id" value="{{isset($student_type)? $student_type->id: ''}}">
                                            <label>@lang('common.type') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('category'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('category') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                 @php 
                                  $tooltip = "";
                                  if(userPermission(72)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($student_type))
                                                @lang('student.update_category')
                                            @else
                                                @lang('student.save_category')
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
                            <h3 class="mb-0">@lang('student.student_category_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                             
                                <tr>
                                    <th>@lang('common.id')</th>
                                    <th>@lang('student.category')</th>
                                    <th>@lang('common.actions')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($student_types as $student_type)
                                <tr>
                                    <td>{{$student_type->id}}</td>
                                    <td>{{$student_type->category_name}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(73))
                                                <a class="dropdown-item" href="{{route('student_category_edit', [$student_type->id])}}">@lang('common.edit')</a>
                                               @endif
                                                @if(userPermission(74))
                                                 <a class="dropdown-item" data-toggle="modal" data-target="#deleteStudentTypeModal{{$student_type->id}}"
                                                    href="#">@lang('common.delete')</a>
                                           
                                                </div>
                                                @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade admin-query" id="deleteStudentTypeModal{{$student_type->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('student.delete_category')</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                </div>

                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                    <a href="{{route('student_category_delete', [$student_type->id])}}"><button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button></a>
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
