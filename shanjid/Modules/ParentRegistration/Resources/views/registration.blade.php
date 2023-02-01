<?php
$setting = App\SmGeneralSettings::find(1);
 
if (isset($setting->copyright_text)) {
    $copyright_text = $setting->copyright_text;
} else {
    $copyright_text = 'Copyright © 2020 All rights reserved | This template is made with by Codethemes';
}
if (isset($setting->logo)) {
    $logo = $setting->logo;
} else {
    $logo = 'public/uploads/settings/logo.png';
}

if (isset($setting->favicon)) {
    $favicon = $setting->favicon;
} else {
    $favicon = 'public/backEnd/img/favicon.png';
}

$login_background = App\SmBackgroundSetting::where([['is_default', 1], ['title', 'Login Background']])->first();

if (empty($login_background)) {
    $css = "background: url(" . url('public/backEnd/img/in_registration.png') . ")  no-repeat center; background-size: cover; ";
} else {
    if (!empty($login_background->image)) {
        $css = "background: url('" . url($login_background->image) . "')  no-repeat center;  background-size: cover;";
    } else {
        $css = "background:" . $login_background->color;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{asset('public/')}}/uploads/settings/favicon.png" type="image/png" />
    <title>{{$setting->site_title}} | Student Registration</title>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link rel="stylesheet" href="{{url('/')}}/public/backEnd/vendors/css/bootstrap.css" />
    <link rel="stylesheet" href="{{url('/')}}/public/backEnd/vendors/css/themify-icons.css" />
    <link rel="stylesheet" href="{{url('/public/')}}/landing/css/toastr.css">
    <link rel="stylesheet" href="{{url('/')}}/public/backEnd/vendors/css/nice-select.css" />
    <link rel="stylesheet" href="{{url('/')}}/public/backEnd/vendors/js/select2/select2.css" />
    <link rel="stylesheet" href="{{url('/')}}/public/backEnd/vendors/css/fastselect.min.css" />
    <link rel="stylesheet" href="{{url('public/backEnd/')}}/vendors/css/toastr.min.css"/>
    <link rel="stylesheet" href="{{url('public/backEnd/')}}/vendors/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="{{url('public/backEnd/')}}/vendors/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="{{url('public/backEnd/')}}/css/style.css"/>
		<link rel="stylesheet" href="{{url('Modules/ParentRegistration/Resources/assets/css/style.css')}}">

</head>

<body class="reg_bg"> 
    <!--================ Start Login Area =================-->
    <div class="reg_bg">

    </div>
    <section class="login-area  registration_area ">
        <div class="container">
            <div class="registration_area_logo">
                 @if(!empty($setting->logo))<img src="{{asset($setting->logo)}}" alt="Login Panel">@endif
            </div>
            @if (\Session::has('success'))
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12">
                    <div class="text-center white-box single_registration_area">
                        <h1>{{__('Thank You')}}</h1>
                        <h3>{!! \Session::get('success') !!}</h3>
                        <a href="{{url('/')}}" class="primary-btn small fix-gr-bg"> 
                            @lang('lang.home')
                        </a>
                    </div>

                </div>
            </div>
            @else

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12">
                    <div class="text-center white-box single_registration_area">
                        <div class="reg_tittle mt-20 mb-20">
                            <h2>@lang('lang.student') @lang('lang.registration')</h2>
                        </div>
                        <div class="reg_tittle mt-40">
                            <h5>@lang('lang.student') @lang('lang.info')</h5>
                        </div>
                            <form method="POST" class="" action="{{url('/parentregistration/student-store')}}" id="parent-registration">
                               {{ csrf_field() }}
                            <input type="hidden" id="url" value="{{url('/')}}"> 


                            <div class="row">
                                @if(App\SmGeneralSettings::isModule('Saas')== TRUE) 
                                <div class="col-lg-6">
                                    <div class="input-effect">
                                        <select class="niceSelect w-100 bb form-control" name="school" id="select-school">
                                            <option data-display="Select School *" value="">Select school *</option>
                                            @foreach($schools as $school)
                                            <option value="{{$school->id}}"> {{$school->school_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif

                                <div class="col-lg-6">
                                    <div class="input-effect" id="academic-year-div">
                                        <select class="niceSelect w-100 bb form-control" name="academic_year" id="select-academic-year">
                                            <option data-display="Select Academic Year *" value="">Select Academic Year *</option>
                                            @if(App\SmGeneralSettings::isModule('Saas')== FALSE) 
                                            @foreach($academic_years as $academic_year) 
                                                <option value="{{$academic_year->id}}">{{$academic_year->year}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                       
                                    </div>
                                     @if($errors->has('academic_year'))
                                            <div class="text-danger error-message invalid-select mb-10">{{ $errors->first('academic_year') }}</div>
                                        @endif
                                </div>

                                <div class="col-lg-6">
                                    <div class="input-effect" id="class-div">
                                        <select class="niceSelect w-100 bb form-control" name="class" id="select-class">
                                            <option data-display="@lang('lang.select_class') *" value="">@lang('lang.select_class') *</option>
                                        </select>
                                    </div>
                                    @if($errors->has('class'))
                                            <div class="text-danger error-message invalid-select mb-10">{{ $errors->first('class') }}</div>
                                        @endif
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-effect" id="section-div">
                                        <select class="niceSelect w-100 bb form-control" name="section" id="select-section">
                                            <option data-display="@lang('lang.select_section') *" value="">@lang('lang.select_section') *</option>
                                           
                                        </select>
                                    </div>
                                    @if($errors->has('section'))
                                            <div class="text-danger error-message invalid-select mb-10">{{ $errors->first('section') }}</div>
                                        @endif
                                </div> 

                                
                            </div> 

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group input-group">
                                        <input class="form-control" type="text" name='first_name' id="school_name" placeholder="student first Name *" value="{{old('first_name')}}" />
                                    </div>
                                    @if($errors->has('first_name'))
                                            <div class="text-danger error-message invalid-select mb-10">{{ $errors->first('first_name') }}</div>
                                        @endif
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group input-group">
                                        <input class="form-control" type="text" name='last_name' id="school_name" placeholder="student last Name *" value="{{old('student_email')}}" />
                                    </div>
                                    @if($errors->has('last_name'))
                                            <div class="text-danger error-message invalid-select mb-10">{{ $errors->first('last_name') }}</div>
                                        @endif
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-effect sm2_mb_20 md_mb_20">
                                        <select class="niceSelect w-100 bb form-control" name="gender">
                                            <option data-display="@lang('lang.gender') *" value="">@lang('lang.gender') *</option>
                                            @foreach($genders as $gender)
                                            <option value="{{$gender->id}}" {{old('gender') == $gender->id? 'selected': ''}}>{{$gender->base_setup_name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    @if($errors->has('gender'))
                                            <div class="text-danger error-message invalid-select mb-10">{{ $errors->first('gender') }}</div>
                                        @endif
                                </div>


                            <div class="col-lg-6">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="input-effect sm2_mb_20 md_mb_20">
                                            <input class="primary-input mydob date form-control{{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}" id="startDate" type="text"
                                                 name="date_of_birth" value="{{date('d/m/Y')}}" autocomplete="off" id="date_of_birth">
                                                <label>@lang('lang.date_of_birth') *</label>
                                                <span class="focus-border"></span>
                                            @if ($errors->has('date_of_birth'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('date_of_birth') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                                {{-- <div class="col-lg-6">
                                    <div class="form-group input-group">
                                        <input placeholder="Date Of Birth *" class="form-control mydob" type="text"  value="{{old('date_of_birth')}}" 
                                         name='date_of_birth' onfocus="(this.type='date')" id="date_of_birth"/>
                                    </div>
                                    @if($errors->has('date_of_birth'))
                                            <div class="text-danger error-message invalid-select mb-10">{{ $errors->first('date_of_birth') }}</div>
                                        @endif
                                </div> --}}

                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group input-group">
                                        <input class="form-control" type="text" name='age' id="age" placeholder="student Age *" readonly=""  value="{{old('age')}}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group input-group">
                                        <input class="form-control" type="email" name='student_email' id="student_email" placeholder="student email" value="{{old('student_email')}}"/>
                                    </div>
                                    <span class="text-danger error-message" id="student_email_error"></span>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group input-group">
                                        <input class="form-control" type="text" name='student_mobile' id="student_mobile" placeholder="student Mobile" value="{{old('student_mobile')}}" />
                                    </div>
                                    <span class="text-danger error-message" id="student_mobile_error"></span>
                                </div>

                            </div>

                            <div class="mt-40">

                                <h5>@lang('lang.guardian') @lang('lang.info')</h5>

                            </div>

                             <div class="row">
                                    
                                <div class="col-lg-6">
                                    <div class="form-group input-group">
                                        <input class="form-control" type="text" name='guardian_name' id="school_name" placeholder="Guardian Name *" value="{{old('guardian_name')}}" />
                                    </div>
                                    @if($errors->has('guardian_name'))
                                            <div class="text-danger error-message invalid-select mb-10">{{ $errors->first('guardian_name') }}</div>
                                        @endif
                                </div>
                                <div class="col-lg-6 d-flex relation-button">
                                    <p class="text-uppercase mb-0">@lang('lang.guardian_relation')</p>
                                    <div class="d-flex radio-btn-flex ml-30">
                                        <div class="mr-20">
                                            <input type="radio" name="relationButton" id="relationFather" value="F" class="common-radio relationButton" {{old('relationButton') == "F"? 'checked': ''}}>
                                            <label for="relationFather">@lang('lang.father')</label>
                                        </div>
                                        <div class="mr-20">
                                            <input type="radio" name="relationButton" id="relationMother" value="M" class="common-radio relationButton" {{old('relationButton') == "M"? 'checked': ''}}>
                                            <label for="relationMother">@lang('lang.mother')</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="relationButton" id="relationOther" value="O" class="common-radio relationButton"  {{old('relationButton') != ""? (old('relationButton') == "O"? 'checked': ''): 'checked'}}>
                                            <label for="relationOther">@lang('lang.Other')</label>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group input-group">
                                        <input class="form-control" type="text" name='guardian_email' id="guardian_email" placeholder="Guardian Email *" value="{{old('guardian_email')}}"/>
                                    </div>
                                    @if($errors->has('guardian_email'))
                                            <div class="text-danger error-message invalid-select mb-10" id="guardian_email_error">{{ $errors->first('guardian_email') }}</div>
                                        @else
                                            <div class="text-danger error-message invalid-select mb-10" id="guardian_email_error"></div>
                                        @endif

                                    </span>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group input-group">
                                        <input class="form-control" type="text" name='guardian_mobile' id="guardian_mobile" placeholder="Guardian  Mobile *" value="{{old('guardian_mobile')}}"/>
                                    </div>
                                    @if($errors->has('guardian_mobile'))
                                            <div class="text-danger error-message invalid-select mb-10" id="guardian_mobile_error">{{ $errors->first('guardian_mobile') }}</div>
                                        @else
                                            <div class="text-danger error-message invalid-select mb-10" id="guardian_mobile_error"></div>
                                        @endif
                                    </span>
                                </div>

                            </div>

                             <div class="row mt-20">

                                <div class="col-lg-12">
                                    <div class="form-group input-group">
                                        <textarea class="form-control" name='how_do_know_us' id="school_name" placeholder="How do you know us.?">{{old('how_do_know_us')}}</textarea>
                                    </div>
                                </div>

                            </div> 

                            @if($reg_setting->recaptcha == 1)

                            <div class="row">

                                <div class="col-lg-12 text-center">
                                      {!! NoCaptcha::renderJs() !!}
                                      {!! NoCaptcha::display() !!}
                                    <span class="text-danger" id="g-recaptcha-error">{{ $errors->first('g-recaptcha-response') }}</span>
                                </div>

                            </div>

                            @endif

                            <div class="row mt-40">
                                <div class="col-lg-12">
                                    <div class="login_button text-center">
                                        <button type="submit" class="primary-btn fix-gr-bg">
                                            <span class="ti-check"></span>
                                           @lang('lang.submit')
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mt-30">
                                        @lang('lang.note_for_multiple_child_registration')

                                        

                                        
                                    </div>
                                </div>
                                
                            </div>


                    </div>
                </div>
            </div>
            @endif

            
        </div>
        </form>
    </section>
    <!--================ Start End Login Area =================-->

    <!--================ Footer Area =================-->
    <footer class="footer_area registration_footer">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                <p>{!!$copyright_text!!}</p>
                </div>
            </div>
        </div>
    </footer>
    <!--================ End Footer Area =================-->


    <script src="{{url('/')}}/public/backEnd/vendors/js/jquery-3.2.1.min.js"></script>
    <script src="{{url('/')}}/public/backEnd/vendors/js/popper.js"></script>
    <script src="{{url('/')}}/public/backEnd/vendors/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/public/backEnd/vendors/js/nice-select.min.js"></script>
    <script src="{{url('/')}}/public/backEnd/js/login.js"></script>
    <script src="{{url('public/backEnd/js/validate.js')}}"></script>
    {{-- <script src="{{url('/')}}/public/backEnd/js/additional.js"></script> --}}

    {{-- <script src="{{asset('public/backEnd/')}}/vendors/js/bootstrap_datetimepicker.min.js"></script> --}}
    <script src="{{asset('public/backEnd/')}}/vendors/js/bootstrap-datepicker.min.js"></script>


    <script src="{{url('/')}}/public/backEnd/js/main.js"></script>
    <script src="{{url('/')}}/public/backEnd/js/custom.js"></script>

    <script src="{{url('/public/js/registration_custom.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/backEnd/')}}/vendors/js/toastr.min.js"></script> 
    {!! Toastr::message() !!}
    @yield('script')

</body>

</html>
