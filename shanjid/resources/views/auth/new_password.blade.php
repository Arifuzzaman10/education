<!DOCTYPE html>
@php
    App::setLocale(getUserLanguage());
@endphp
<html lang="{{ app()->getLocale() }}" @if(isset ($ttl_rtl ) && $ttl_rtl ==1) dir="rtl" class="rtl" @endif >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('auth.reset_password') </title>
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/bootstrap.css" />
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/themify-icons.css" />
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/css/style.css" />
	<style>
    html {
    visibility: visible;
    }
    </style>
</head>
<body class="login admin hight_100">

    <!--================ Start Login Area =================-->
	<section class="login-area up_login">
		<div class="container">
			<div class="row login-height justify-content-center align-items-center">
				<div class="col-lg-5 col-md-8">
					<div class="form-wrap text-center">
						<div class="logo-container">
							@php 
                            	$setting = generalSetting();
                        	@endphp
							<a href="#">
								{{-- <img src="{{asset('public/backEnd/img/logo.png')}}" alt=""> --}}
								<img src="{{asset($setting->logo)}}" alt="" width="170px" height="68px">
							</a>
						</div>
						<h5 class="text-uppercase">@lang('auth.reset_password')</h5>
						@if(session()->has('message-success') != "")
		                    @if(session()->has('message-success'))
		                    <p class="text-success">{{session()->get('message-success')}}</p>
		                    @endif
		                @endif
		                @if(session()->has('message-danger') != "")
		                    @if(session()->has('message-danger'))
		                    <p class="text-danger">{{session()->get('message-danger')}}</p>
		                    @endif
		                @endif
						<form method="POST" class="" action="{{ route('storeNewPassword') }}">
							<input type="hidden" name="email" value="{{$email}}">
                        @csrf

							<div class="form-group input-group mb-4 mx-3">
								<span class="input-group-addon">
									<i class="ti-key"></i>
								</span>
								<input class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" type="password" name='new_password' placeholder="@lang('auth.enter_new_password')"/>
								@if ($errors->has('new_password'))
                                    <span class="invalid-feedback text-left pl-3" role="alert">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
							</div>

							<div class="form-group input-group mb-4 mx-3">
								<span class="input-group-addon">
									<i class="ti-key"></i>
								</span>
								<input class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" type="password" name='confirm_password' placeholder="@lang('auth.confirm_new_password')"/>
								@if ($errors->has('confirm_password'))
                                    <span class="invalid-feedback text-left pl-3" role="alert">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                @endif
							</div>
							

							<div class="form-group mt-30 mb-30">
								<button type="submit" class="primary-btn fix-gr-bg">
									<span class="ti-lock mr-2"></span>
									@lang('common.save')
                                </button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================ Start End Login Area =================-->

	<!--================ Footer Area =================-->
	<footer class="footer_area">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-12 text-center">
					@if($setting->copyright_text)
					<p>{!! $setting->copyright_text !!}</p> 
					</p>
					@else
					<p>Copyright © 2019 All rights reserved | This application is made with <span class="ti-heart"></span>  by Codethemes</p> 
					</p>
					@endif
				</div>
			</div>
		</div>
	</footer>
	<!--================ End Footer Area =================-->


    <script src="{{asset('public/backEnd/')}}/vendors/js/jquery-3.2.1.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/vendors/js/popper.js"></script>
	<script src="{{asset('public/backEnd/')}}/vendors/js/bootstrap.min.js"></script>
	<script>
		$('.primary-btn').on('click', function(e) {
		// Remove any old one
		$('.ripple').remove();

		// Setup
		var primaryBtnPosX = $(this).offset().left,
			primaryBtnPosY = $(this).offset().top,
			primaryBtnWidth = $(this).width(),
			primaryBtnHeight = $(this).height();

		// Add the element
		$(this).prepend("<span class='ripple'></span>");

		// Make it round!
		if (primaryBtnWidth >= primaryBtnHeight) {
			primaryBtnHeight = primaryBtnWidth;
		} else {
			primaryBtnWidth = primaryBtnHeight;
		}

		// Get the center of the element
		var x = e.pageX - primaryBtnPosX - primaryBtnWidth / 2;
		var y = e.pageY - primaryBtnPosY - primaryBtnHeight / 2;

		// Add the ripples CSS and start the animation
		$('.ripple')
			.css({
				width: primaryBtnWidth,
				height: primaryBtnHeight,
				top: y + 'px',
				left: x + 'px'
			})
			.addClass('rippleEffect');
		});
	</script>
</body>
</html>
