@if(@in_array(542, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
    <li>
        <a href="#subMenuStudentRegistration" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
            <span class="flaticon-reading"></span>
            @lang('lang.registration')
        </a>
        <ul class="collapse list-unstyled" id="subMenuStudentRegistration">
            @if(@in_array(543, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                <li>
                    <a href="{{url('parentregistration/student-list')}}"> @lang('lang.student_list')</a>
                </li>
            @endif
            @if(App\SmGeneralSettings::isModule('Saas') != TRUE)
                @if(@in_array(547, App\GlobalVariable::GlobarModuleLinks()) || Auth::user()->role_id == 1)
                    <li>
                        <a href="{{url('parentregistration/settings')}}"> @lang('lang.settings')</a>
                    </li>
                @endif
            @endif
        </ul>
    </li>
@endif
