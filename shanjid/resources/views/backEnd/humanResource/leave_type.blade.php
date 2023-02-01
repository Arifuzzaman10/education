@extends('backEnd.master')
@section('title')
@lang('leave.leave_type')
@endsection
@section('mainContent')


<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('leave.leave_type')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('leave.leave')</a>
                <a href="#">@lang('leave.leave_type')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($leave_type))
        @if(userPermission(204))
                
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('leave-type')}}" class="primary-btn small fix-gr-bg">
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
                            <h3 class="mb-30">@if(isset($leave_type))
                                    @lang('leave.edit_leave_type')
                                @else
                                    @lang('leave.add_leave_type')
                                @endif 
                                
                            </h3>
                        </div>
                @if(isset($leave_type))
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('leave-type-update',$leave_type->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                @else
                 @if(userPermission(204))
                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'leave-type',
                'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                @endif
                @endif
                <div class="white-box">
                    <div class="add-visitor">
                        <div class="row">
                            <div class="col-lg-12">                               
                                <div class="input-effect">
                                    <input class="primary-input form-control{{ $errors->has('type') ? ' is-invalid' : '' }}"
                                    type="text" name="type" autocomplete="off" value="{{isset($leave_type)? $leave_type->type:Request::old('type')}}">
                                    <label>@lang('leave.type_name') <span>*</span> </label>
                                    <input type="hidden" name="id" value="{{isset($leave_type)? $leave_type->id: ''}}">

                                    <span class="focus-border"></span>
                                    @if ($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                              
                            </div>
                        </div>
                          @php 
                              $tooltip = "";
                              if(userPermission(204)){
                                    $tooltip = "";
                                }else{
                                    $tooltip = "You have no permission to add";
                                }
                            @endphp
                        <div class="row mt-40">
                            <div class="col-lg-12 text-center">
                                <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                    <span class="ti-check"></span>

                                    @if(isset($leave_type))
                                        @lang('leave.update_type')
                                    @else
                                        @lang('leave.save_type')
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
                            <h3 class="mb-0">@lang('leave.leave_type_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                    <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                        <thead>
                            
                            <tr>
                                <th>@lang('common.type')</th>
                              
                                <th>@lang('common.action')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($leave_types as $leave_type)
                            <tr>
                                <td>{{$leave_type->type}}</td>
                               
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            @lang('common.select')
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if(userPermission(205))

                                            <a class="dropdown-item" href="{{route('leave-type-edit', [$leave_type->id
                                                ])}}">@lang('common.edit')</a>
                                               @endif
                                               @if(userPermission(206))

                                               <a class="dropdown-item" data-toggle="modal" data-target="#deleteLeaveTypeModal{{$leave_type->id}}"
                                                    href="#">@lang('common.delete')</a>
                                               @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class="modal fade admin-query" id="deleteLeaveTypeModal{{$leave_type->id}}" >
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('leave.delete_leave_type')</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                    </div>

                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                        {{ Form::open(['route' => array('leave-type-delete',$leave_type->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
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
