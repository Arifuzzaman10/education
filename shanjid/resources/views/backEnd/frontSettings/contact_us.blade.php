@extends('backEnd.master')
@section('title')
@lang('front_settings.contact_page')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('front_settings.contact_page')</h1>
                <div class="bc-pages">
                    <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                    <a href="#">@lang('front_settings.front_settings')</a>
                    <a href="#">@lang('front_settings.contact_page')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            @if(isset($update))
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    @if(isset($update))
                                        @lang('common.edit')
                                    @else
                                        @lang('common.add')
                                    @endif
                                </h3>
                            </div>
                            @if(isset($update))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'contactPageStore',
                                'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            @else
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'visitor_store',
                                'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            @endif
                            <div class="white-box">
                               
                                <div class="add-visitor {{isset($update)? '':'isDisabled'}}">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="input-effect">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                            type="text" name="title" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->title:''):''}}">
                                                        <label>@lang('front_settings.title')<span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('title'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('title') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                
                                                <div class="col-lg-4">
                                                    <div class="input-effect">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('button_text') ? ' is-invalid' : '' }}"
                                                            type="text" name="button_text" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->button_text:''):'' }}">
                                                        <label>@lang('front_settings.button_text') <span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('button_text'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('button_text') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="input-effect">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('button_text') ? ' is-invalid' : '' }}"
                                                            type="text" name="button_url" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->button_url:''):'' }}">
                                                        <label>@lang('front_settings.button_url')<span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('button_url'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('button_url') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                
                                                
                                                <div class="col-lg-4">
                                                    <div class="input-effect mt-25">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                                            type="text" name="address" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->address:''):'' }}">
                                                        <label>@lang('common.address')<span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('address'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('address') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="input-effect mt-25">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('address_text') ? ' is-invalid' : '' }}"
                                                            type="text" name="address_text" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->address_text:''):'' }}">
                                                        <label>@lang('front_settings.address_text')<span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('address_text'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('address_text') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="input-effect mt-25">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                            type="text" name="phone" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->phone:''):'' }}">
                                                        <label>@lang('common.phone')<span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('phone'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('phone') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        
                                        <div class="col-lg-12">
                                            <div class="row">
                                                
                                                
                                                <div class="col-lg-4">
                                                    <div class="input-effect mt-25">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('phone_text') ? ' is-invalid' : '' }}"
                                                            type="text" name="phone_text" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->phone_text:''):'' }}">
                                                        <label>@lang('common.phone_text') <span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('phone_text'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('phone_text') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="input-effect mt-25">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                            type="text" name="email" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->email:''):'' }}">
                                                        <label>@lang('common.email')<span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="input-effect mt-25">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('email_text') ? ' is-invalid' : '' }}"
                                                            type="text" name="email_text" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->email_text:''):'' }}">
                                                        <label>@lang('common.email_text') <span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('email_text'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email_text') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>  
                                        <div class="col-lg-12">
                                            <div class="row">
                                                
                                                
                                                <div class="col-lg-3">
                                                    <div class="input-effect mt-25">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}"
                                                            type="text" name="latitude" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->latitude:''):'' }}">
                                                        <label>@lang('front_settings.latitude')<span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('latitude'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('latitude') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="input-effect mt-25">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}"
                                                            type="text" name="longitude" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->longitude:''):'' }}">
                                                        <label>@lang('front_settings.longitude')<span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('longitude'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('longitude') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="input-effect mt-25">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('zoom_level') ? ' is-invalid' : '' }}"
                                                            type="text" name="zoom_level" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->zoom_level:''):'' }}">
                                                        <label>@lang('front_settings.zoom_level')<span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('zoom_level'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('zoom_level') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>



                                                <div class="col-lg-4">
                                                    <div class="input-effect mt-25">
                                                        <input
                                                            class="primary-input form-control{{ $errors->has('google_map_address') ? ' is-invalid' : '' }}"
                                                            type="text" name="google_map_address" autocomplete="off"
                                                            value="{{isset($update)? ($contact_us != ''? $contact_us->google_map_address:''):'' }}">
                                                        <label>@lang('front_settings.google_map_address')<span>*</span></label>
                                                        <span class="focus-border"></span>
                                                        @if ($errors->has('google_map_address'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('google_map_address') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>


                                            </div>
                                        </div>      
                                    </div>
                                
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="input-effect mt-25">
                                                <div class="input-effect">
                                                    <textarea class="primary-input form-control" cols="0" rows="5" name="description" id="description">{{isset($update)? ($contact_us != ''? $contact_us->description:''):'' }}</textarea>
                                                    <label>@lang('common.description') <span>*</span> </label>
                                                    @if($errors->has('description'))
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $errors->first('description') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row no-gutters input-right-icon mt-35">
                                            <div class="col">
                                                <div class="input-effect">
                                                    <input class="primary-input form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" id="placeholderInput" type="text"
                                                           {{-- placeholder="Image" --}}
                                                           placeholder="{{ isset($update) and $contact_us ? ($contact_us->image !="") ? getFilePath3($contact_us->image) : trans('front_settings.image') .' *' : trans('front_settings.image') .' *' }}"
                                                           readonly>
                                                    <span class="focus-border"></span>
                                                    @if($errors->has('image'))
                                                        <span class="invalid-feedback mb-10" role="alert">
                                                            <strong>{{ $errors->first('image') }}</strong>
                                                        </span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button class="primary-btn-small-input" type="button">
                                                    <label class="primary-btn small fix-gr-bg"
                                                           for="browseFile">@lang('common.browse')</label>
                                                    <input type="file" class="d-none" id="browseFile" name="image">
                                                </button>

                                            </div>
                                            

                                        </div>
                                    <span class="mt-10">@lang('front_settings.image')(1420px*450px)</span>



                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            @if(Illuminate\Support\Facades\Config::get('app.app_sync'))
                                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo "> <button class="primary-btn fix-gr-bg  demo_view" style="pointer-events: none;" type="button" >@lang('front_settings.update') </button></span>
                                            @else

                                                <button class="primary-btn fix-gr-bg">
                                                    <span class="ti-check"></span>
                                                    @if(isset($update))
                                                        @lang('front_settings.update')
                                                    @else
                                                        @lang('front_settings.save')
                                                    @endif
                                                </button>
                                            @endif    
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
            </div>
            @endif

            <div class="row">

                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mt-30 mb-30">@lang('front_settings.info')</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 scroll_table">

                            <table class="display school-table school-table-style" cellspacing="0" width="100%">

                                <thead>
                                <tr>
                                    <th width="10%">@lang('front_settings.title')</th>
                                    <th width="20%">@lang('common.description')</th>
                                    <th width="10%">@lang('front_settings.button_text')</th>
                                    <th width="10%">@lang('front_settings.button_url') </th>
                                    <th width="10%">@lang('front_settings.image')</th>
                                    <th width="10%">@lang('common.action')</th>
                                </tr>
                                </thead>

                                <tbody>
                                
                                    <tr>
                                        <td width="10%">{{$contact_us != ""? $contact_us->title:""}}</td>
                                        <td width="20%">{{$contact_us != ""? $contact_us->description:""}}</td>
                                        <td width="10%">{{$contact_us != ""? $contact_us->button_text:""}}</td>
                                        <td width="10%">{{$contact_us != ""? $contact_us->button_url:""}}</td>
                                        
                                        <td width="10%">
                                            @if($contact_us != "")
                                                @if(userPermission(515))
                                                    <a class="primary-btn small fix-gr-bg" data-toggle="modal" data-target="#showimageModal"  href="#">@lang('common.view')</a>
                                                @endif
                                            @endif
                                        </td>
                                        @if(userPermission(516))
                                            <td width="10%"><a href="{{route('contactPageEdit')}}" class="primary-btn small fix-gr-bg">@lang('common.edit')</a></td>
                                        @endif
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>


    <div class="modal fade admin-query" id="showimageModal">
    <div class="modal-dialog modal-dialog-centered max_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('common.view_image')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body p-0">
                <div class="container student-certificate">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <div class="mb-5">
                                <img class="img-fluid" src="{{asset($contact_us != ''? $contact_us->image:'')}}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
