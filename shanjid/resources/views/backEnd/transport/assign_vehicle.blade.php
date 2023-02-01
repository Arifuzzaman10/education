@extends('backEnd.master')
@section('title')
@lang('transport.assign_vehicle')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-25 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('transport.assign_vehicle')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('transport.transport')</a>
                <a href="#">@lang('transport.assign_vehicle')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($assign_vehicle))
         @if(userPermission(358) )

        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('assign-vehicle')}}" class="primary-btn small fix-gr-bg">
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
                            <h3 class="mb-30">@if(isset($assign_vehicle))
                                    @lang('transport.edit_assign_vehicle')
                                @else
                                    @lang('transport.add_assign_vehicle')
                                @endif
                               
                            </h3>
                        </div>
                        @if(isset($assign_vehicle))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('assign-vehicle-update',@$assign_vehicle->id), 'method' => 'PUT']) }}
                        @else
                         @if(userPermission(358) )

                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'assign-vehicle', 'method' => 'POST']) }}
                        @endif
                        @endif
                        <input type="hidden" name="id" value="{{isset($assign_vehicle)? @$assign_vehicle->id:''}}">
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        

                                        <select class="niceSelect w-100 bb form-control{{ $errors->has('route') ? ' is-invalid' : '' }}" name="route">
                                            <option data-display="@lang('transport.select_route') *" value="">@lang('transport.select_route') *</option>
                                            @foreach($routes as $routes)
                                                @if(isset($assign_vehicle))
                                                    <option value="{{@$routes->id}}" {{@$assign_vehicle->route_id == @$routes->id? 'selected':''}}>{{@$routes->title}}</option>
                                                @else
                                                    <option value="{{@$routes->id}}">{{@$routes->title}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('route'))
                                        <span class="invalid-feedback invalid-select" role="alert">
                                            <strong>{{ $errors->first('route') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-40">
                                    <div class="col-lg-12">
                                        <label>@lang('transport.vehicle') *</label><br>
                                        @foreach($vehicles as $vehicle)
                                            @if(isset($assign_vehicle))
                                                <div class="">
                                                    <input type="radio" id="vehicle{{@$vehicle->id}}" class="common-checkbox" name="vehicles[]" value="{{@$vehicle->id}}" {{in_array(@$vehicle->id, @$vehiclesIds)? 'checked': ''}}>
                                                    <label for="vehicle{{@$vehicle->id}}">{{@$vehicle->vehicle_no}}</label>
                                                </div>
                                            @else
                                                <div class="">
                                                    <input type="radio" id="vehicle{{@$vehicle->id}}" class="common-checkbox" name="vehicles[]" value="{{@$vehicle->id}}">
                                                    <label for="vehicle{{@$vehicle->id}}">{{@$vehicle->vehicle_no}}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if($errors->has('vehicles'))
                                            <span class="text-danger validate-textarea-checkbox" role="alert">
                                                <strong>{{ $errors->first('vehicles') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @php 
                                  $tooltip = "";
                                  if(userPermission(358)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                         <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{@$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($assign_vehicle))
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
                            <h3 class="mb-0">@lang('transport.assign_vehicle_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        
                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                             
                                <tr>
                                    <th>@lang('transport.route')</th>
                                    <th>@lang('transport.vehicle')</th>
                                    <th>@lang('common.action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($assign_vehicles as $assign_vehicle)
                                <tr>
                                    <td valign="top">{{@$assign_vehicle->route !=""? @$assign_vehicle->route->title:""}}</td>
                                    <td>
                                    {{@$assign_vehicle->vehicle !=""? @$assign_vehicle->vehicle->vehicle_no:""}}
                                    </td>
                                    
                                    <td valign="top">
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">

                                               @if(userPermission(259))
                                                <a class="dropdown-item" href="{{route('assign-vehicle-edit',@$assign_vehicle->id)}}">@lang('common.edit')</a>
                                                @endif
                                               
                                                @if(userPermission(360))
                                                <a class="dropdown-item deleteAssignVehicle" data-toggle="modal" href="#" data-id="{{@$assign_vehicle->id}}" data-target="#deleteAssignVehicle">@lang('common.delete')</a>
                                           @endif
                                            </div>
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

<div class="modal fade admin-query" id="deleteAssignVehicle" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('transport.delete_assign_vehicle')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                </div>

                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                     {{ Form::open(['route' => 'assign-vehicle-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                     <input type="hidden" name="id" id="assign_vehicle_id" >
                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                     {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
