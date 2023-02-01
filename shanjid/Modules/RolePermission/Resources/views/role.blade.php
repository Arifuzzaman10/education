@extends('backEnd.master')
@section('mainContent')


<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('rolepermission::role.role_permission') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('rolepermission::role.role_permission')</a>
                <a href="#">@lang('rolepermission::role.role')</a> 
            </div>
        </div>
    </div>
</section>


<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($role))
                                    @lang('rolepermission::role.edit_role')

                                @else
                                    @lang('rolepermission::role.add_role')

                                @endif
                              
                            </h3>
                        </div>
                        @if(isset($role))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'rolepermission/role-update',
                        'method' => 'POST']) }}
                        @else
                        @if(userPermission(418) )
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'rolepermission/role-store', 'method'
                        => 'POST']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row  mt-25">
                                    <div class="col-lg-12">
                                       
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                type="text" name="name" autocomplete="off" value="{{isset($role)? @$role->name: ''}}">
                                            <input type="hidden" name="id" value="{{isset($role)? @$role->id: ''}}">
                                            <label>@lang('common.name') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php 
                                    $tooltip = "";
                                    if(userPermission(418) ){
                                            $tooltip = "";
                                        }else{
                                            $tooltip = "You have no permission to add";
                                        }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{@$tooltip}}">
                                            <span class="ti-check"></span>
                                            {{!isset($role) ? 'save': 'update'}}
                                            
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
                            <h3 class="mb-0">@lang('rolepermission::role.role_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                              
                                <tr>
                                    <th width="30%">@lang('rolepermission::role.role')</th>
                                    <th width="40%">@lang('common.type')</th>
                                    <th width="30%">@lang('common.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{@$role->name}}</td>
                                    <td>{{@$role->type}}</td>
                                    <td>
                                        <div class="dropdown">
                                            @if(@$role->type != "System")
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            @endif

                                            <div class="dropdown-menu dropdown-menu-right">
                                                
                                                @if(userPermission(419))
                                                    <a class="dropdown-item" href="{{route('rolepermission/role-edit', [@$role->id])}}">@lang('common.edit')</a>
                                                @endif
                                                @if(userPermission(420))
                                                    <a class="dropdown-item deleteRole" data-toggle="modal" href="#" data-id="{{@$role->id}}" data-target="#deleteRole">@lang('common.delete')</a>
                                               @endif
                                            </div>
                                            @if(@$role->id != 1)
                                                @if(userPermission(541))
                                                    <a href="{{route('rolepermission/assign-permission', [@$role->id])}}" class=""   >
                                                        <button type="button" class="primary-btn small fix-gr-bg"> @lang('rolepermission::role.assign_permission') </button>
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
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

<div class="modal fade admin-query" id="deleteRole" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.delete_item')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                     {{ Form::open(['route' => 'rolepermission/role-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                     <input type="hidden" name="id" id="role_id">
                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                     {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
