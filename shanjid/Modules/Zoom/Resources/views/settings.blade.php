@extends('backEnd.master')
@section('title') 
    @lang('lang.manage') @lang('lang.zoom') @lang('lang.settings')
@endsection
@section('mainContent')
 <style type="text/css">
        #selectStaffsDiv, .forStudentWrapper {
            display: none;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 55px;
            height: 26px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 24px;
            width: 24px;
            left: 3px;
            bottom: 2px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background: linear-gradient(90deg, #7c32ff 0%, #c738d8 51%, #7c32ff 100%);
        }

        input:focus + .slider {
            box-shadow: 0 0 1px linear-gradient(90deg, #7c32ff 0%, #c738d8 51%, #7c32ff 100%);
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
        .buttons_div_one{
        /* border: 4px solid #FFFFFF; */
        border-radius:12px;

        padding-top: 0px;
        padding-right: 5px;
        padding-bottom: 0px;
        margin-bottom: 4px;
        padding-left: 0px;
         }
        .buttons_div{
        border: 4px solid #19A0FB;
        border-radius:12px
        }
        .slider_zoom{
         margin-top: -8%;
         margin-bottom: 0;
         margin-left: 6%;
        }
    </style>
<section class="sms-breadcrumb mb-40 up_breadcrumb white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.manage') @lang('lang.zoom_setting')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.virtual_class')</a>
                <a href="#">@lang('lang.settings')</a>
            </div>
        </div>
    </div>
</section>
@if($setting->api_use_for==0 || auth()->user()->role_id ==1)
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('zoom.settings.update') }}" method="POST">
                        @csrf
                        <div class="white-box">
                                <div class="row p-0">
                                    <div class="col-lg-12">
                                        <h3 class="text-center">@lang('lang.zoom_setting')</h3>
                                        <hr>


                                        <div class="row mb-40 mt-40">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-5 d-flex">
                                                        <p class="text-uppercase fw-500 mb-10">@lang('lang.meeting_approval')</p>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <select class="w-100 bb niceSelect form-control {{ @$errors->has('approval_type') ? ' is-invalid' : '' }}" name="approval_type">
                                                            <option data-display="@lang('lang.select') *" value="">@lang('lang.select') *</option>
                                                            <option value="0" {{ old('approval_type',$setting->approval_type) == 0? 'selected' : ''}} >@lang('lang.automatically') </option>
                                                            <option value="1" {{ old('approval_type',$setting->approval_type) == 1? 'selected' : ''}} >@lang('lang.manually') @lang('lang.approve')</option>
                                                            <option value="2" {{ old('approval_type',$setting->approval_type) == 2? 'selected' : ''}} >@lang('lang.no') @lang('lang.registration') @lang('lang.required')</option>
                                                        </select>
                                                        @if ($errors->has('approval_type'))
                                                            <span class="invalid-feedback invalid-select" role="alert">
                                                                <strong>{{ @$errors->first('approval_type') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-5 d-flex">
                                                        <p class="text-uppercase fw-500 mb-10">@lang('lang.host_video') </p>
                                                    </div>
                                                    <div class="col-lg-7">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="host_video" id="host_video_on" value="1" class="common-radio relationButton" {{ old('host_video',$setting->host_video) == 1 ? 'checked': ''}}>
                                                                        <label for="host_video_on">@lang('lang.enable')</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="host_video" id="host_video" value="0" class="common-radio relationButton" {{ old('host_video',$setting->host_video) == '0' ? 'checked': ''}}>
                                                                        <label for="host_video">@lang('lang.disable')</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mb-40 mt-40">

                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-5 d-flex">
                                                        <p class="text-uppercase fw-500 mb-10"> @lang('lang.auto_recording') ( @lang('lang.for_paid_package') )</p>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <select class="w-100 bb niceSelect form-control {{ @$errors->has('auto_recording') ? ' is-invalid' : '' }}" name="auto_recording">
                                                            <option data-display="@lang('lang.select') *" value="">@lang('lang.select') *</option>
                                                            <option value="none" {{ old('auto_recording',$setting->auto_recording) == 'none'? 'selected' : ''}} >@lang('lang.none')</option>
                                                            <option value="local" {{ old('auto_recording',$setting->auto_recording) == 'local'? 'selected' : ''}} >@lang('lang.local')</option>
                                                            <option value="cloud" {{ old('auto_recording',$setting->auto_recording) == 'cloud'? 'selected' : ''}} >@lang('lang.cloud')</option>
                                                        </select>
                                                        @if ($errors->has('auto_recording'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong>{{ @$errors->first('auto_recording') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-5 d-flex">
                                                        <p class="text-uppercase fw-500 mb-10">@lang('lang.participant_video') </p>
                                                    </div>
                                                    <div class="col-lg-7">
                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="participant_video" id="participant_video_on" value="1" class="common-radio relationButton" {{ old('participant_video',$setting->participant_video) == 1? 'checked': ''}}>
                                                                        <label for="participant_video_on">@lang('lang.enable')</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="participant_video" id="participant_video" value="0" class="common-radio relationButton" {{ old('participant_video',$setting->participant_video) == 0? 'checked': ''}}>
                                                                        <label for="participant_video">@lang('lang.disable')</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mb-40 mt-40">

                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-5 d-flex">
                                                        <p class="text-uppercase fw-500 mb-10">@lang('lang.audio_options')</p>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <select class="w-100 bb niceSelect form-control {{ @$errors->has('audio') ? ' is-invalid' : '' }}" name="audio">
                                                            <option data-display="@lang('lang.select') *" value="">@lang('lang.select') *</option>
                                                            <option value="both" {{ old('audio',$setting->audio) == 'both' ? 'selected' : ''}} >@lang('lang.both')</option>
                                                            <option value="telephony"  {{ old('audio',$setting->audio) == 'telephony'? 'selected' : ''}}>@lang('lang.telephony')</option>
                                                            <option value="voip"  {{ old('audio',$setting->audio) == 'voip'? 'selected' : ''}} >@lang('lang.voip')</option>

                                                        </select>
                                                        @if ($errors->has('audio'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong>{{ @$errors->first('audio') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-5 d-flex">
                                                        <p class="text-uppercase fw-500 mb-10">@lang('lang.join_before_host') </p>
                                                    </div>
                                                    <div class="col-lg-7">
                                                            <div class=" radio-btn-flex ml-20">
                                                                <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="join_before_host" id="join_before_host_on" value="1" class="common-radio relationButton"  {{  old('join_before_host',$setting->join_before_host) == 1? 'checked': '' }}>
                                                                        <label for="join_before_host_on">@lang('lang.enable')</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="join_before_host" id="join_before_host" value="0" class="common-radio relationButton"  {{ old('join_before_host',$setting->join_before_host) == 0? 'checked': '' }}>
                                                                        <label for="join_before_host">@lang('lang.disable')</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-40 mt-40">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-5 d-flex">
                                                        <p class="text-uppercase fw-500 mb-10">@lang('lang.pakage')</p>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <select class="w-100 bb niceSelect form-control {{ @$errors->has('package_id') ? ' is-invalid' : '' }}" name="package_id">
                                                            <option data-display="@lang('lang.select') *" value="">@lang('lang.select') *</option>
                                                            <option value="1" {{ old('package_id',$setting->package_id) == 1 ? 'selected' : ''}} >@lang('lang.basic') (@lang('lang.free'))</option>
                                                            <option value="2" {{ old('package_id',$setting->package_id) == 2 ? 'selected' : ''}} >@lang('lang.pro')</option>
                                                            <option value="3" {{ old('package_id',$setting->package_id) == 3 ? 'selected' : ''}} >@lang('lang.business')</option>
                                                            <option value="4" {{ old('package_id',$setting->package_id) == 4 ? 'selected' : ''}} >@lang('lang.enterprise')</option>
                                                        </select>
                                                        @if ($errors->has('package_id'))
                                                        <span class="invalid-feedback invalid-select" role="alert">
                                                            <strong>{{ @$errors->first('package_id') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-5 d-flex">
                                                        <p class="text-uppercase fw-500 mb-10">@lang('lang.waiting_room')</p>
                                                    </div>
                                                    <div class="col-lg-7">
                                                            <div class=" radio-btn-flex ml-20">
                                                                <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="waiting_room" id="waiting_room_on" value="1" class="common-radio relationButton"  {{ old('waiting_room',$setting->waiting_room) == 1? 'checked': '' }}>
                                                                        <label for="waiting_room_on">@lang('lang.enable')</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="waiting_room" id="waiting_room" value="0" class="common-radio relationButton"  {{ old('waiting_room',$setting->waiting_room) == 0? 'checked': '' }}>
                                                                        <label for="waiting_room">@lang('lang.disable')</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row mb-40 mt-40">
                                            <div class="col-lg-6">
                                                <div class="input-effect sm2_mb_20 md_mb_20">
                                                    <input class="primary-input form-control{{ $errors->has('api_key') ? ' is-invalid' : '' }}" type="text" name="api_key" value="{{ old('api_key',$setting->api_key) }}">
                                                    <label>@lang('lang.api_key')<span>*</span> </label>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('api_key'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('api_key') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-5 d-flex">
                                                        <p class="text-uppercase fw-500 mb-10"> @lang('lang.mute_upon_entry') </p>
                                                    </div>
                                                    <div class="col-lg-7">

                                                            <div class="radio-btn-flex ml-20">
                                                                <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="mute_upon_entry" id="mute_upon_entr_on" value="1" class="common-radio relationButton" {{ old('mute_upon_entry',$setting->mute_upon_entry) == 1? 'checked': ''}}>
                                                                        <label for="mute_upon_entr_on">@lang('lang.enable')</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="mute_upon_entry" id="mute_upon_entry" value="0" class="common-radio relationButton"  {{ old('mute_upon_entry',$setting->mute_upon_entry) == 0? 'checked': ''}}>
                                                                        <label for="mute_upon_entry">@lang('lang.disable')</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row mb-40 mt-40">
                                            <div class="col-lg-6">
                                                <div class="input-effect sm2_mb_20 md_mb_20">
                                                    <input class="primary-input form-control{{ $errors->has('secret_key') ? ' is-invalid' : '' }}" type="text" name="secret_key" value="{{ old('secret_key',$setting->secret_key) }}">
                                                    <label>@lang('lang.serect_key')<span>*</span></label>
                                                    <span class="focus-border"></span>
                                                    @if ($errors->has('secret_key'))
                                                    <span class="invalid-feedback invalid-select" role="alert">
                                                        <strong>{{ $errors->first('secret_key') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-5 d-flex">
                                                        <p class="text-uppercase fw-500 mb-10">@lang('lang.api') use for</p>
                                                    </div>
                                                    <div class="col-lg-7">
                                                          <p class="slider_zoom">@lang('lang.admin')/@lang('lang.teacher')</p>
                                                            <div class=" radio-btn-flex ml-20">
                                                              
                                                                <label class="switch">
                                                                    <input type="checkbox" name="api_use_for"
                                                                            class="weekend_switch_btn" {{@$setting->api_use_for == 0? '':'checked'}}>
                                                                        <span class="slider round" style="background-color: #b336e2"></span>
                                                                    </label>
                                                                <div class="row">
                                                                {{-- <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="api_use_for" id="admin_api" value="1" class="common-radio relationButton"  {{ old('api_use_for',$setting->api_use_for) == 0? 'checked': '' }}>
                                                                        <label for="admin_api">@lang('lang.admin')</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="">
                                                                        <input type="radio" name="api_use_for" id="teahcer_api" value="0" class="common-radio relationButton"  {{ old('api_use_for',$setting->api_use_for) == 1? 'checked': '' }}>
                                                                        <label for="teahcer_api">@lang('lang.teacher')</label>
                                                                    </div>
                                                                </div> --}}

                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>

                                        @if(userPermission(570))
                                            <div class="row mt-40">
                                                <div class="col-lg-12 text-center">
                                                <button class="primary-btn fix-gr-bg" id="_submit_btn_admission">
                                                        <span class="ti-check"></span>
                                                        @lang('lang.update')
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@elseif($setting->api_use_for==1 && auth()->user()->role_id !=1)  
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('zoom.ind.settings.update') }}" method="POST">
                    @csrf
                    <div class="white-box">
                            <div class="row p-0">
                                <div class="col-lg-12">
                                    <h3 class="text-center">@lang('lang.zoom_setting')</h3>
                                    <hr>
                                       <div class="row mb-40 mt-40">
                                        <div class="col-lg-6">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input class="primary-input form-control{{ $errors->has('api_key') ? ' is-invalid' : '' }}" type="text" name="api_key" value="{{auth()->user()->zoom_api_key_of_user}}">
                                                <label>@lang('lang.api_key')<span>*</span> </label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('api_key'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('api_key') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="input-effect sm2_mb_20 md_mb_20">
                                                <input class="primary-input form-control{{ $errors->has('secret_key') ? ' is-invalid' : '' }}" type="text" name="secret_key" value="{{auth()->user()->zoom_api_serect_of_user}}">
                                                <label>@lang('lang.serect_key')<span>*</span></label>
                                                <span class="focus-border"></span>
                                                @if ($errors->has('secret_key'))
                                                <span class="invalid-feedback invalid-select" role="alert">
                                                    <strong>{{ $errors->first('secret_key') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                  

                                 
                                        <div class="row mt-40">
                                            <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" id="_submit_btn_admission">
                                                    <span class="ti-check"></span>
                                                    @lang('lang.update')
                                                </button>
                                            </div>
                                        </div>
                                  

                                </div>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endif
@endsection
