
@php
    $generalSetting= generalSetting();
    $languages = systemLanguage();
    $styles = allStyles();

@endphp
<style>
    #livesearch a{  text-align: left; display: block; }
    .languageChange .list{    padding-top: 40px !important;}
    .infix_theme_rtl .list{    padding-top: 40px !important;}
    .infix_theme_style .list{    padding-top: 40px !important;}
    p.date {
        font-size: 11px;
    }

    .mr-10.text-right.bell_time {
        text-align: right;
        margin-right: 0;
        padding-right: 0;
        position: relative;
        left: 22px;
    }

    .profile_single_notification i {
        margin-bottom: 20px;
    }

    .profile_single_notification span.ti-bell {
        font-size: 12px;
        margin-right: 5px;
        display: inline-block;
        overflow: hidden;
    }

    /* .dropdown-item:last-child .profile_single_notification {background: #;background: #000;} */

    .profile_single_notification.d-flex.justify-content-between.align-items-center {
        /* background: red; */
        margin-bottom: 10px !important;
        margin-top: 10px !important;
    }
    .admin .navbar .right-navbar .dropdown .message.notification_msg {
        font-size: 12px;
        max-width: 127px;
        max-height: auto !important;
        overflow: visible !important;
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
        line-height: 1.4;
        white-space: normal;

    }
    .admin .navbar .right-navbar .dropdown .message {
        max-height: initial !important;
    }

    /* sctolled_notify  */
    .sctolled_notify {
        max-height: 300px;
        overflow: auto;
    }
    .navbarSupportedContent{
        justify-content: flex-end;
        flex: auto;
        flex: auto 0 0;
    }
    .up_dash_menu ul.nav.navbar-nav.mr-auto.nav-buttons {
        margin: 0;
        text-align: center !important;
    }
    .navbar_menu_middle {
        display: flex;
        justify-content: flex-end;
        flex: 1 1 0;
    }
    #navbarSupportedContent {
        flex: 0 auto;
    }

@media (max-width: 991.98px) {
    .navbar_menu_middle {
	justify-content: center;
	margin-right: 45px;
}
 }
</style>
<style>
    .nice-select.open .list { min-width: 200px;  left: 0;  padding: 5px; }
    .nice-select .nice-select-search { min-width: 190px; }
</style>
@php
    $coltroller_role=1;
@endphp

<nav class="navbar navbar-expand-lg up_navbar" id="main-nav-for-chat">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class='up_dash_menu'>
                    <div id="sidebarCollapse" class="sidebar_icon  d-lg-none btn nav_icon">
                        <i class="ti-more"></i>
                    </div>
                    <div class="collaspe_icon open_miniSide">
                        <i class="ti-menu"></i>
                    </div>

                    <ul class="nav navbar-nav mr-auto search-bar ml-0 d-none d-lg-flex">
                        <li class="">
                            <div class="input-group" id="serching">
                            <span>
                                <i class="ti-search" aria-hidden="true" id="search-icon"></i>
                            </span>
                                <input type="text" class="form-control primary-input input-left-icon" placeholder="@lang('common.search')"
                                       id="search" onkeyup="showResult(this.value)"/>
                                <span class="focus-border"></span>
                            </div>
                            <div id="livesearch"></div>
                        </li>
                    </ul>
                    <div class="navbar_menu_middle flex-fill">
                        <ul class="nav navbar-nav mr-auto nav-buttons flex-sm-row">
                            @if ( generalSetting()->website_btn==1)
                                <li class="nav-item">
                                    <a class="primary-btn white mr-10" href="{{url('/')}}/home">@lang('common.website')</a>
                                </li>
                            @endif
                            @if (generalSetting()->dashboard_btn==1)
                                @if (Auth::user()->role_id == $coltroller_role)
                                    <li class="nav-item">
                                        <a class="primary-btn white mr-10"
                                        href="{{route('admin-dashboard')}}">@lang('common.dashboard')</a>
                                    </li>
                                @endif
                            @endif
                            @if ( generalSetting()->report_btn==1)
                                @if (Auth::user()->role_id == $coltroller_role)
                                    <li class="nav-item">
                                        <a class="primary-btn white" href="{{route('student_report')}}">@lang('reports.reports')</a>
                                    </li>
                                @endif
                            @endif


                        </ul>
                        <ul class="nav navbar-nav mr-0 nav-setting flex-sm-row  colortheme">
                            <li class="nav-item active">
                                <input type="hidden" name="url" id="url" value="{{url('/')}}">
                                <select class="niceSelect infix_session" id="infix_session">

                                    <option data-display="Academic Year" value="0">@lang('common.academic_year') </option>
                                    @foreach (academicYears() as $academic_year)
                                            @if(moduleStatusCheck('University'))
                                            <option value="{{ @$academic_year->id }}" {{ getAcademicId()==@$academic_year->id?'selected':''}}>{{ @$academic_year->name }}  </option>
                                            @else
                                            <option value="{{ @$academic_year->id }}" {{ getAcademicId()==@$academic_year->id?'selected':''}}>{{ @$academic_year->year }} [{{@$academic_year->title}}] </option>
                                            @endif

                                    @endforeach
                                </select>
                            </li>
                        </ul>
                    </div>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto nav_icon" type="button"
                            data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false"
                            aria-label="Toggle navigation">
                        {{-- <i class="ti-menu"></i> --}}
                        <div class="client_thumb_btn">
                            @if (!empty(profile()))
                                <img class="client_img" src="{{asset(profile())}}" alt="Profile Pic">
                            @else
                                <img class="client_img" src="{{asset('public/uploads/staff/demo/staff.jpg') }}" alt="Profile Pic">
                                {{-- @else --}}
                            @endif
                        </div>
                    </button>
                    <div class="collapse navbar-collapse flex-end" id="navbarSupportedContent">

                        {{-- @if (Auth::user()->role_id==1 || Auth::user()->is_administrator=='yes') --}}

                        {{-- @endif --}}


                        @if(@$styles && Auth::user()->role_id == 1 )
                            @if (generalSetting()->style_btn==1)
                                <input type="hidden" name="url" id="url" value="{{Url('/')}}">
                                <ul class="nav navbar-nav mr-0  nav-setting flex-sm-row d-none d-lg-block colortheme">
                                    <li class="nav-item active">
                                        <select class="niceSelect infix_theme_style" id="infix_theme_style">

                                            <option data-display="@lang('common.select_style')" value="0">@lang('common.select_style')</option>
                                            @foreach($styles as $style)
                                                <option value="{{$style->id}}" {{activeStyle()->id == $style->id?'selected':''}}>{{$style->style_name}}</option>
                                            @endforeach
                                        </select>
                                    </li>
                                </ul>
                        @endif
                        {{-- @if (generalSetting()->ltl_rtl_btn==1)
                            <ul class="nav navbar-nav mr-auto nav-setting flex-sm-row d-none d-lg-block colortheme">
                                <li class="nav-item active">
                                    <select class="niceSelect infix_theme_rtl" id="infix_theme_rtl">
                                        <option data-display="@lang('common.select_alignment')" value="0">@lang('common.select_alignment')</option>
                                        @php
                                        $is_rtl = schoolConfig()->ttl_rtl;
                                        @endphp
                                            <option value="2" {{userRtlLtl()==2?'selected':''}}>@lang('lang.ltl')</option>
                                            <option value="1" {{userRtlLtl()==1?'selected':''}}>@lang('lang.rtl')</option>
                                    </select>
                                </li>
                            </ul>
                        @endif --}}
                    @endif
                    <!-- Start Right Navbar -->


                        <ul class="nav navbar-nav right-navbar">
                            @if(generalSetting()->lang_btn==1)
                                <li class="nav-item">
                                    <select class="niceSelect languageChange" name="languageChange" id="languageChange">
                                        <option data-display="@lang('common.select_language')" value="0">@lang('common.select_language')</option>
                                        @foreach($languages as $lang)
                                            <option data-display="{{$lang->native}}" value="{{ $lang->language_universal}}" {{$lang->language_universal == userLanguage()? 'selected':''}}>{{$lang->native}}</option>
                                        @endforeach
                                    </select>
                                </li>
                            @endif
                            {{-- @endif --}}
                            @if(app('general_settings')->get('chatting_method') == null || app('general_settings')->get('chatting_method') == 'log')
                                <jquery-notification-component
                                        :unreads="{{ json_encode($notifications_for_chat) }}"
                                        :user_id="{{ json_encode(auth()->id()) }}"
                                        :redirect_url="{{ json_encode(route('chat.index')) }}"
                                        :check_new_notification_url="{{ json_encode(route('chat.notification.check')) }}"
                                        :asset_type="{{ json_encode(asset('/public')) }}"
                                        :mark_all_as_read_url="{{ json_encode(route('chat.notification.allRead')) }}"
                                ></jquery-notification-component>
                            @else
                                <notification-component
                                        :unreads="{{ json_encode($notifications_for_chat) }}"
                                        :user_id="{{ json_encode(auth()->id()) }}"
                                        :redirect_url="{{ json_encode(route('chat.index')) }}"
                                        :asset_type="{{ json_encode(asset('/public')) }}"
                                        :mark_all_as_read_url="{{ json_encode(route('chat.notification.allRead')) }}"
                                ></notification-component>
                            @endif
<!--                           <li class="nav-item notification-area">
                                <a href="{{ route('chat.index') }}" class="chat-quick-link">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                            </li>-->
                            <li class="nav-item notification-area  d-none d-lg-block">
                                <div class="dropdown">
                                    <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="badge">{{count($notifications?? [])}}</span>
                                        <span class="flaticon-notification"></span>
                                    </button>

                                    <div class="dropdown-menu">
                                        <div class="white-box">
                                            <div class="p-h-20">
                                                <p class="notification">@lang('common.you_have')
                                                    <span>{{count($notifications ?? [])}} @lang('common.new')</span>
                                                    @lang('common.notification')</p>
                                            </div>
                                            <div class="sctolled_notify">

                                                @foreach($notifications as $notification)

                                                    <a class="dropdown-item pos-re"
                                                       href="{{ route('notification-show',$notification->id) }}">

                                                        <div class="profile_single_notification d-flex justify-content-between align-items-center">
                                                            <div class="mr-30">
                                                                <p class="message s"> <span class="ti-bell"></span>{{$notification->message}}</p>
                                                            </div>
                                                            <div class="text-right bell_time">
                                                                <p class="time text-uppercase">{{date("h.i a", strtotime($notification->created_at))}}</p>
                                                                <p class="date">
                                                                    {{$notification->date != ""? dateConvert($notification->date):''}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>

                                                @endforeach
                                            </div>
                                            <a href="{{route('view/all/notification',Auth()->user()->id)}}" class="primary-btn text-center text-uppercase mark-all-as-read">
                                                @lang('common.mark_all_as_read')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item setting-area">
                                <div class="dropdown">
                                    <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                                        <img class="rounded-circle" src="{{ @profile() && file_exists(@profile()) ? asset(profile()) : asset('public/uploads/staff/demo/staff.jpg') }}" alt="">
                                    </button>
                                    <div class="dropdown-menu profile-box">
                                        <div class="white-box">
                                            <a class="dropdown-item" href="#">
                                                <div class="">
                                                    <div class="d-flex">
                                                        <img class="client_img"
                                                             src="{{ @profile() && file_exists(@profile()) ? asset(profile()) : asset('public/uploads/staff/demo/staff.jpg') }} "
                                                             alt="">
                                                        <div class="d-flex ml-10">
                                                            <div class="">
                                                                <h5 class="name text-uppercase">{{Auth::user()->full_name}}</h5>
                                                                <p class="message mb-2">{{Auth::user()->email}} </p>
                                                                @if (isset(Auth::user()->wallet_balance))
                                                                    @if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                                                                        <p class="message">
                                                                            <strong>
                                                                                @lang('common.balance'):
                                                                                {{generalSetting()->currency_symbol}}{{(Auth::user()->wallet_balance != null) ? number_format(Auth::user()->wallet_balance, 2, '.', ''): 0.00}}
                                                                            </strong>
                                                                        </p>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                            <ul class="list-unstyled">
                                                <li>

                                                    @if(Auth::user()->is_saas == 1)
                                                        <a href="{{ route('saasStaffDashboard')}}">
                                                            <span class="fa fa-home"></span>
                                                            @lang('common.saas_dashboard')
                                                        </a>
                                                    @endif

                                                    @if(Auth::user()->role_id == "2" && Auth::user()->is_saas == 0)
                                                        <a href="{{ route('student-profile')}}">
                                                            <span class="ti-user"></span>
                                                            @lang('common.view_profile')
                                                        </a>

                                                    @elseif(Auth::user()->role_id != "3" && Auth::user()->is_saas == 0 && Auth::user()->staff)


                                                        <a href="{{route('viewStaff', Auth::user()->staff->id)}}">
                                                            <span class="ti-user"></span>
                                                            @lang('common.view_profile')
                                                        </a>

                                                    @endif


                                                </li>
                                                @if(auth()->user()->staff && teacherParentService()==true)
                                                    @if(auth()->user()->staff->parent_id)
                                                        @if(auth()->user()->role_id == 3)
                                                        <li>
                                                            <a href="{{route('viewAsRole')}}">
                                                                <span class="ti-key"></span>
                                                            @lang('common.VIEW_AS_'.strtoupper(auth()->user()->staff->previousRole->name))
                                                            </a>
                                                        </li>
                                                        @else
                                                        <li>
                                                            <a href="{{route('viewAsParent')}}">
                                                                <span class="ti-key"></span>
                                                            @lang('common.VIEW_AS_PARENT')
                                                            </a>
                                                        </li>
                                                        @endif
                                                    @endif
                                                @endif

                                                    @if(moduleStatusCheck('Saas')== TRUE && Auth::user()->is_administrator=="yes" && Auth::user()->role_id==1 && Auth::user()->is_saas ==0)

                                                        <li>
                                                            <a href="{{route('viewAsSuperadmin')}}">
                                                                <span class="ti-key"></span>
                                                                @if(Session::get('isSchoolAdmin')==TRUE)
                                                                    @lang('common.view_as_saas_admin')
                                                                @else
                                                                    @lang('common.view_as_school_admin')
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        <a href="{{route('updatePassowrd')}}">
                                                            <span class="ti-key"></span>
                                                            @lang('common.password')
                                                        </a>
                                                    </li>
                                                    <li>

                                                        <a href="{{ Auth::user()->role_id == 2? route('student-logout'): route('logout')}}"
                                                           onclick="event.preventDefault();

                                                         document.getElementById('logout-form').submit();">
                                                            <span class="ti-unlock"></span>
                                                            @lang('common.logout')
                                                        </a>

                                                        <form id="logout-form"
                                                              action="{{ Auth::user()->role_id == 2? route('student-logout'): route('logout') }}"
                                                              method="POST" style="display: none;">

                                                            @csrf
                                                        </form>
                                                    </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <!-- End Right Navbar -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>



@section('script')

@endsection
