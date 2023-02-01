@extends('backEnd.master')
    @section('title')
        @if(isset($editData))
            @lang('front_settings.edit_page')
        @else
            @lang('front_settings.add_page')
        @endif
        
    @endsection
@section('mainContent')
@push('css')
<style>
    .cust-class{
        font-size: 12px;
    }
</style>
@endpush
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('front_settings.create_page')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#"> @lang('front_settings.front_settings')</a>
                <a href="#">@lang('front_settings.create_page')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('page-list')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-angle-left pr-2"></span>
                    @lang('front_settings.back')
                </a>
                @if (isset($editData))
                    @if(userPermission(656))
                        <a href="{{route('create-page')}}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus pr-2"></span>
                            @lang('common.add')
                        </a>
                    @endif
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">
                                @if(isset($editData))
                                    @lang('front_settings.edit_page')
                                @else
                                    @lang('front_settings.add_page')
                                @endif
                             
                            </h3>
                        </div>
                        @if(isset($editData))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'update-page-data', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        <input type="hidden" name="id" value="{{$editData->id}}">
                        @else
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'save-page-data',
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('title') ? ' is-invalid' : '' }}"
                                                type="text" name="title" onkeyup="processSlug(this.value, '#slug')" autocomplete="off" value="{{ isset($editData) ? $editData->title : old('title') }}">
                                            <label>@lang('common.title') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row  mt-40">
                                    <div class="col-lg-6">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('slug') ? ' is-invalid' : '' }}"
                                                type="text" name="slug" id="slug" autocomplete="off" value="{{ isset($editData) ? $editData->slug : old('slug') }}">
                                            <label>@lang('front_settings.slug') <span>*</span></label>
                                            <span class="focus-border"></span>
                                            @if ($errors->has('slug'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ @$errors->first('slug') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row no-gutters input-right-icon mb-20">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input
                                                        class="primary-input form-control {{ $errors->has('header_image') ? ' is-invalid' : '' }}"
                                                        readonly="true" type="text"
                                                        placeholder="{{isset($editData->header_image) && @$editData->header_image != ""? getFilePath3(@$editData->header_image):trans('front_settings.image_header_min')." (1420*450 PX)"}}"
                                                        id="placeholderUploadContent">
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('header_image'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('header_image') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="primary-btn-small-input" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="upload_content_file">@lang('common.browse')</label>
                                                    <input type="file" class="d-none form-control" name="header_image"
                                                           id="upload_content_file">
                                                </button>
                                            </div>
                                        </div>
                                        @isset($editData)
                                            <a class="btn btn-primary cust-class pull-right" href="{{route('view-page', ['slug'=>@$editData->slug])}}" target="blank">@lang('front_settings.preview')</a>
                                        @endisset
                                        {{-- @if(isset($editData->header_image))
                                            <a class="btn btn-primary cust-class pull-right" data-toggle="modal" data-target="#viewImages" data-modal-size="full-width-modal" href="#">
                                                @lang('front_settings.preview')
                                            </a>
                                        @endif --}}
                                    </div>
                                </div>
                                <div class="row  mt-40">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <input class="primary-input form-control{{ @$errors->has('sub_title') ? ' is-invalid' : '' }}"
                                                type="text" name="sub_title" autocomplete="off" value="{{ isset($editData) ? $editData->sub_title : old('sub_title') }}">
                                            <label>@lang('front_settings.sub_title')</label>
                                            <span class="focus-border"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-40">
                                    <div class="col-lg-12">
                                        <div class="input-effect">
                                            <label>@lang('common.details')* </label>
                                            <textarea class="primary-input summer_note form-control{{ $errors->has('details') ? ' is-invalid' : '' }}" cols="0" rows="4" name="details" >{{isset($editData)? $editData->details: old('details')}}</textarea>
                                            <span class="focus-border textarea"></span>
                                            
                                            @if($errors->has('details'))
                                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('details') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            	@php
                                  $tooltip = "";
                                  if(userPermission(656)){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                    if(isset($editData)){
                                        if(userPermission(657)){
                                            $tooltip = "";
                                        }else{
                                            $tooltip = "You have no permission to edit";
                                        }
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                       <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{$tooltip}}">
                                            <span class="ti-check"></span>
                                            @if(isset($editData))
                                                @lang('front_settings.update_page')
                                            @else
                                                @lang('front_settings.save_page')
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
        </div>
    </div>
    <div class="modal fade admin-query" id="viewImages">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        @lang('front_settings.image_preview')
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <img src="{{asset(@$editData->header_image)}}" width="100%" style="float: left">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    function processSlug(value, slug_id){
        let data = value.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
        $(slug_id).val('');
        $(slug_id).val(data);
        $('#slug').addClass( "has-content" );
    }
    
                                    
</script>
@endpush