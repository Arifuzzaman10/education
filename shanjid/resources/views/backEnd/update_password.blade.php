@extends('backEnd.master')
@section('title')
    @lang('auth.change_password')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('auth.change_password') </h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('auth.change_password') </a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area mb-40">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('auth.change_password') </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="white-box">

                    @if (Illuminate\Support\Facades\Config::get('app.app_sync'))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'admin-dashboard', 'method' => 'GET', 'enctype' => 'multipart/form-data']) }}
                    @else
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'updatePassowrdStore', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                    @endif

                    <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
                    <div class="row mb-25">
                        <div class="cal-lg-4">
                            <div class="img-thumb text-center">
                                <img style="width:60%" class="rounded-circle"
                                    src="{{ file_exists(@profile()) ? asset(@profile()) : asset('public/uploads/staff/demo/staff.jpg') }}"
                                    alt="">
                            </div>
                            <div class="title text-center mt-25">
                                <h3>{{ @$LoginUser->full_name }}</h3>
                                <h4>{{ @$LoginUser->email }}</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="row mb-25">

                                <div class="col-lg-6  offset-lg-3">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input form-control{{ $errors->has('current_password') || session()->has('password-error') ? ' is-invalid' : '' }}"
                                            type="password" name="current_password">
                                        <label>@lang('auth.current_password') </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('current_password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('current_password') }}</strong>
                                            </span>
                                        @endif
                                        @if (session()->has('password-error'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ session()->get('password-error') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-25">
                                <div class="col-lg-6 offset-lg-3">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}"
                                            type="password" name="new_password">
                                        <label>@lang('auth.new_password') </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('new_password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('new_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-25">
                                <div class="col-lg-6 offset-lg-3">
                                    <div class="input-effect">
                                        <input
                                            class="primary-input form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}"
                                            type="password" name="confirm_password">
                                        <label>@lang('auth.confirm_password') </label>
                                        <span class="focus-border"></span>
                                        @if ($errors->has('confirm_password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('confirm_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-lg-12 mt-20 text-center">
                                    @if (Illuminate\Support\Facades\Config::get('app.app_sync'))
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                            title="Disabled For Demo ">
                                            <button style="pointer-events: none;"
                                                class="primary-btn small fix-gr-bg  demo_view" type="button">
                                                @lang('auth.change_password')</button>
                                        </span>
                                    @else
                                        <button type="submit" class="primary-btn fix-gr-bg">
                                            <span class="ti-check"></span>
                                            @lang('auth.change_password')
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
    </section>
@endsection
