@extends('backEnd.master')
@section('title')
@lang('front_settings.add_testimonial')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('front_settings.add_testimonial')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('front_settings.front_settings')</a>
                    <a href="#">@lang('front_settings.add_testimonial')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if(isset($add_testimonial))
            @if(userPermission(506))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                        <a href="{{route('testimonial_index')}}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus pr-2"></span>
                            @lang('common.add')
                        </a>
                    </div>
                </div>
            @endif
            @endif
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">@if(isset($add_testimonial))
                                    @lang('front_settings.edit_testimonial')
                                @else
                                    @lang('front_settings.add_testimonial')
                                @endif
                               
                            </h3>
                        </div>
                        @if(isset($add_testimonial))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'update_testimonial',
                            'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'add-income-update']) }}
                        @else
                        @if(userPermission(506))
                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'store_testimonial',
                            'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'add-income']) }}
                        @endif
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                       
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                type="text" name="name" autocomplete="off"
                                                value="{{isset($add_testimonial)? @$add_testimonial->name: old('name')}}">
                                            <input type="hidden" name="id" value="{{isset($add_testimonial)? @$add_testimonial->id: ''}}">
                                            <label>@lang('common.name') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>



                                    </div>
                                </div>
                                <div class="row no-gutters input-right-icon mt-25">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('designation') ? ' is-invalid' : '' }}"
                                                   type="text" name="designation" autocomplete="off"
                                                   value="{{isset($add_testimonial)? @$add_testimonial->designation: old('designation')}}">
                                            <label>@lang('front_settings.designation') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('designation'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('designation') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row no-gutters input-right-icon mt-25">
                                    <div class="col">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ $errors->has('institution_name') ? ' is-invalid' : '' }}"
                                                   type="text" name="institution_name" autocomplete="off"
                                                   value="{{isset($add_testimonial)? @$add_testimonial->institution_name: old('institution_name')}}">
                                            <label>@lang('front_settings.institution_name') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('institution_name'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('institution_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row no-gutters input-right-icon mt-25">
                                    <div class="col">
                                        <div class="row no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input class="primary-input" type="text" id="placeholderFileOneName"
                                                           placeholder="{{isset($add_testimonial)? (@$add_testimonial->image !="") ? getFilePath3(@$add_testimonial->image) :trans('common.image') .' *' :trans('common.image') .' *' }}"
                                                           readonly
                                                    >
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('image'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('image') }}</strong>
                                            </span>
                                            @endif
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="primary-btn-small-input" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="document_file_1">@lang('common.browse')</label>
                                                    <input type="file" class="d-none" name="image" id="document_file_1">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <textarea class="primary-input form-control" cols="0" rows="4"
                                                      name="description">{{isset($add_testimonial)? @$add_testimonial->description: old('description')}}</textarea>
                                            <label>@lang('common.description') *<span></span></label>
                                            <span class="focus-border textarea"></span>
                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php 
                                    $tooltip = "";
                                    if(userPermission(506)){
                                            $tooltip = "";
                                        }else{
                                            $tooltip = "You have no permission to add";
                                        }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       
                                            @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo "> <button class="primary-btn fix-gr-bg  demo_view" style="pointer-events: none;" type="button" >@lang('front_settings.submit') </button></span>
                                            @else
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{@$tooltip}}">
                                                @if(isset($add_testimonial))
                                                    @lang('common.update')
                                                @else
                                                    @lang('common.add')
                                                @endif
                                            </button>

                                            @endif
                                        
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
                            <h3 class="mb-0">@lang('front_settings.testimonial_list')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">

                        <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                            <thead>
                           
                            <tr>
                                <th>@lang('common.name')</th>
                                <th>@lang('front_settings.designation')</th>
                                <th>@lang('front_settings.institution_name')</th>
                                <th>@lang('front_settings.image')</th>
                                <th>@lang('common.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($testimonial as $value)
                                <tr>
                                    <td>{{@$value->name}}</td>
                                    <td>{{@$value->designation}}</td>
                                    <td>{{@$value->institution_name}}</td>
                                    <td><img src="{{asset(@$value->image)}}" width="60px" height="50px"></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                @lang('common.select')
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(userPermission(505))
                                                <a href="{{route('testimonial-details',@$value->id)}}" class="dropdown-item small fix-gr-bg modalLink" title="@lang('front_settings.testimonial_details')" data-modal-size="modal-lg">
                                                    @lang('common.view')
                                                </a>
                                                @endif
                                                @if(userPermission(507))
                                                <a class="dropdown-item" href="{{route('edit-testimonial',@$value->id)}}">@lang('common.edit')</a>
                                                @endif

                                                @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                            <span  tabindex="0" data-toggle="tooltip" title="Disabled For Demo"> <a href="#" class="dropdown-item small fix-gr-bg  demo_view" style="pointer-events: none;" >@lang('common.delete')</a></span>
                                                        @else

                                                        @if(userPermission(508))
                                                        <a href="{{route('for-delete-testimonial',@$value->id)}}" class="dropdown-item small fix-gr-bg modalLink" title="@lang('front_settings.delete_testimonial')" data-modal-size="modal-md">
                                                            @lang('common.delete')
                                                        </a>
                                                        @endif      
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
    </section>
@endsection

