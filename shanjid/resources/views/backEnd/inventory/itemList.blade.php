@extends('backEnd.master')
@section('title')
@lang('inventory.item_list')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('inventory.item_list')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('inventory.inventory')</a>
                <a href="#">@lang('inventory.item_list')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($editData))
        @if(userPermission(321))
           
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('item-list')}}" class="primary-btn small fix-gr-bg">
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
                            <h3 class="mb-30">@if(isset($editData))
                                    @lang('inventory.edit_item')
                                @else
                                    @lang('inventory.add_item')
                                @endif
                               
                            </h3>
                        </div>
                        @if(isset($editData))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => array('item-list-update',$editData->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                        @if(userPermission(321))
           
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'item-list',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row"> 
                                    <div class="col-lg-12 mb-20">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('item_name') ? ' is-invalid' : '' }}"
                                            type="text" name="item_name" autocomplete="off" value="{{isset($editData)? $editData->item_name : '' }}">
                                            <label>@lang('inventory.item_name') <span>*</span> </label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('item_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('item_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-20">
                                <div class="input-effect">
                                    <select class="niceSelect w-100 bb form-control{{ $errors->has('category_name') ? ' is-invalid' : '' }}" name="category_name" id="category_name">
                                        <option data-display="@lang('inventory.select_item_category') *" value="">@lang('common.select')</option>
                                        @foreach($itemCategories as $key=>$value)
                                        <option value="{{$value->id}}"
                                        @if(isset($editData))
                                        @if($editData->item_category_id == $value->id)
                                            selected
                                        @endif
                                        @endif
                                        >{{$value->category_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border"></span>
                                    @if ($errors->has('category_name'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('category_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-12 mb-20">
                                <div class="input-effect">
                                    <textarea class="primary-input form-control" cols="0" rows="4" name="description" id="description">{{isset($editData) ? $editData->description : ''}}</textarea>
                                    <label>@lang('common.description') <span></span> </label>
                                    <span class="focus-border textarea"></span>

                                </div>
                            </div>
                             </div>
                  				@php 
                                  $tooltip = "";
                                  if(userPermission(321)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">

                                            <span class="ti-check"></span>
                                            @if(isset($editData))
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
                    <h3 class="mb-0">@lang('inventory.item_list')</h3>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                    <thead>
                       
                        <tr>
                            <th>@lang('common.sl')</th>
                            <th>@lang('inventory.item_name')</th>
                            <th>@lang('student.category') </th>
                            <th>@lang('inventory.total_in_stock') </th>
                            <th>@lang('common.action')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(isset($items))
                        @foreach($items as $key=>$value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{$value->item_name}}</td>
                            <td>{{$value->category !=""?$value->category->category_name:""}}</td>
                            <td>{{$value->total_in_stock}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                        @lang('common.select')
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                    @if(userPermission(322))
                                        <a class="dropdown-item" href="{{route('item-list-edit',$value->id)}}">@lang('common.edit')</a>
                                    @endif
                                    @if(userPermission(323))
                                        <a class="deleteUrl dropdown-item" data-modal-size="modal-md" title="@lang('inventory.delete_item')" href="{{route('delete-item-view',@$value->id)}}">@lang('common.delete')</a>
                                    @endif
                                    </div>
                                </div>
                            </td>

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
