@if(userPermission(1) && menuStatus(1))
    <li data-position="{{menuPosition(1)}}" class="sortable_li">
        <a href="{{route('student-dashboard')}}">
            <div class="nav_icon_small">
                <span class="flaticon-resume"></span>
                </div>
                <div class="nav_title">
                    @lang('common.dashboard')
                </div>
        </a>
    </li>
@endif
@if(userPermission(11) && menuStatus(11))
    <li data-position="{{menuPosition(11)}}" class="sortable_li">
        <a href="{{route('student-profile')}}">
            
            <div class="nav_icon_small">
                <span class="flaticon-resume"></span>
                </div>
                <div class="nav_title">
                    @lang('student.my_profile')
                </div>
        </a>
    </li>
@endif
@if(generalSetting()->fees_status == 0)
    @if(userPermission(20) && menuStatus(20))
        <li data-position="{{menuPosition(20)}}" class="sortable_li">
            <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">                
                
                <div class="nav_icon_small">
                    <span class="flaticon-wallet"></span>
                    </div>
                    <div class="nav_title">
                        @lang('fees.fees')
                    </div>
            </a>
            <ul class="list-unstyled" >
                @if(moduleStatusCheck('FeesCollection')== false )
                    <li data-position="{{menuPosition(21)}}">
                        <a href="{{route('student_fees')}}">@lang('fees.pay_fees')</a>
                    </li>
                @else
                    <li data-position="{{ menuPosition(21) }}">
                        <a href="{{ route('feescollection/student-fees') }}">@lang('fees.pay_fees')</a>
                    </li>

                @endif
            </ul>
        </li>
    @endif
@endif

@if (generalSetting()->fees_status == 1)
    @includeIf('fees::sidebar.feesStudentSidebar')
@endif



@if (moduleStatusCheck('Lms') == true)
    @if (userPermission(1500) && menuStatus(1500))
        <li data-position="{{ menuPosition(1500) }}" class="sortable_li">
            <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
                <div class="nav_icon_small">
                    <span class="flaticon-reading"></span>
                </div>
                <div class="nav_title">
                    @lang('lms::lms.lms')
                </div>
            </a>
            <ul class="list-unstyled" id="lmsButtonMenu">
                @if (userPermission(1500) && menuStatus(1500))
                    <li data-position="{{ menuPosition(1555) }}">
                        <a href="{{ route('lms.allCourse', [auth()->user()->id]) }}">@lang('lms::lms.course')</a>
                    </li>
                @endif
 
                @if(generalSetting()->lms_checkout)
                    @if (userPermission(1500) && menuStatus(1500))
                        <li data-position="{{ menuPosition(1555) }}">
                            <a href="{{ route('lms.enrolledCourse',[auth()->user()->id] ) }}">@lang('lms::lms.my_course')</a>
                        </li>
                    @endif 
                    @if (userPermission(1500) && menuStatus(1500))
                        <li data-position="{{ menuPosition(1555) }}">
                            <a href="{{ route('lms.student.purchaseLog', [auth()->user()->id]) }}">@lang('lms::lms.purchase_history')</a>
                        </li>
                    @endif
                @endif

                @if (userPermission(1500) && menuStatus(1504))
                    <li data-position="{{ menuPosition(1504) }}">
                        <a href="{{ route('lms.student.quiz') }}">@lang('lms::lms.my_quiz')</a>
                    </li>
                @endif
                @if (userPermission(1500) && menuStatus(1505))
                    <li data-position="{{ menuPosition(1505) }}">
                        <a href="{{ route('lms.student.quizReport')}}">@lang('lms::lms.quiz_report')</a>
                    </li>
                @endif

                @if (userPermission(1500) && menuStatus(1505))
                    <li data-position="{{ menuPosition(1505) }}">
                        <a href="{{ route('lms.student.certificate', auth()->id())}}">@lang('lms::lms.certificate')</a>
                    </li>
                @endif

                
            </ul>
        </li>
    @endif
@endif



@if (moduleStatusCheck('Wallet') == true)
    <li data-position="{{ menuPosition(56) }}" class="sortable_li">
        <a href="{{ route('wallet.my-wallet') }}">
            <div class="nav_icon_small">
                <span class="flaticon-wallet"></span>
            </div>
            <div class="nav_title">
                @lang('wallet::wallet.my_wallet')
            </div>
        </a>
    </li>
@endif


@if(userPermission(22) && menuStatus(22))
    <li data-position="{{menuPosition(22)}}" class="sortable_li">
        <a href="{{route('student_class_routine')}}">
          
            
            <div class="nav_icon_small">
                <span class="flaticon-calendar-1"></span>
                </div>
                <div class="nav_title">
                    @lang('academics.class_routine')
                </div>
        </a>
    </li>
@endif

@if(userPermission(800) && menuStatus(800))
    <li data-position="{{menuPosition(800)}}" class="sortable_li">
        <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
            
            <div class="nav_icon_small">
                <span class="flaticon-calendar-1"></span>
                </div>
                <div class="nav_title">
                    @lang('lesson::lesson.lesson')
                </div>
        </a>
        <ul class="list-unstyled" >
            @if(userPermission(810) && menuStatus(810))
                <li data-position="{{menuPosition(810)}}">
                    <a href="{{route('lesson-student-lessonPlan')}}">@lang('lesson::lesson.lesson_plan')</a>
                </li>
            @endif
            @if (userPermission(815) && menuStatus(815))
                <li data-position="{{ menuPosition(815) }}">
                    <a
                        href="{{ route('lesson-student-lessonPlan-overview') }}">@lang('lesson::lesson.lesson_plan_overview')</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if(userPermission(23) && menuStatus(23))
    <li data-position="{{menuPosition(23)}}" class="sortable_li">
        <a href="{{route('student_homework')}}">           
            <div class="nav_icon_small">
                <span class="flaticon-book"></span>
                </div>
                <div class="nav_title">
                    @lang('homework.home_work')
                </div>
        </a>
    </li>
@endif
@if(userPermission(26) && menuStatus(26))
    <li data-position="{{menuPosition(26)}}" class="sortable_li">
        <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
           
            
            <div class="nav_icon_small">
                <span class="flaticon-data-storage"></span>
                </div>
                <div class="nav_title">
                    @lang('study.download_center')
                </div>
        </a>
        <ul class="list-unstyled" id="subMenuDownloadCenter">
            @if(userPermission(27) && menuStatus(27))
                <li data-position="{{menuPosition(27)}}">
                    <a href="{{route('student_assignment')}}">@lang('study.assignment')</a>
                </li>
            @endif
            {{-- @if (userPermission(29) && menuStatus(29))
                <li>
                    <a href="{{route('student_study_material')}}">@lang('study.student_study_material')</a>
                </li>
            @endif --}}
            @if (userPermission(31) && menuStatus(31))
                <li data-position="{{ menuPosition(31) }}">
                    <a href="{{ route('student_syllabus') }}">@lang('study.syllabus')</a>
                </li>
            @endif
            @if (userPermission(33) && menuStatus(33))
                <li data-position="{{ menuPosition(33) }}">
                    <a href="{{ route('student_others_download') }}">@lang('study.other_download')</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if(userPermission(35) && menuStatus(35))
    <li data-position="{{menuPosition(35)}}" class="sortable_li">
        <a href="{{route('student_my_attendance')}}">
         
          
            <div class="nav_icon_small">
                <span class="flaticon-authentication"></span>
                </div>
                <div class="nav_title">
                    @lang('student.attendance')
                </div>
        </a>
    </li>
@endif
@if(userPermission(36) && menuStatus(36))
    <li data-position="{{menuPosition(36)}}" class="sortable_li">
        <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
           
            
            <div class="nav_icon_small">
                <span class="flaticon-test"></span>
                </div>
                <div class="nav_title">
                    @lang('exam.examinations')
                </div>
        </a>
        <ul class="list-unstyled" id="subMenuStudentExam">
            @if(userPermission(37) && menuStatus(37))
                <li data-position="{{menuPosition(37)}}">
                    <a href="{{route('student_result')}}">@lang('reports.result')</a>
                </li>
            @endif
            @if (userPermission(38) && menuStatus(38))
                <li data-position="{{ menuPosition(38) }}">
                    <a href="{{ route('student_exam_schedule') }}">@lang('exam.exam_schedule')</a>
                </li>
            @endif
        </ul>
    </li>
@endif


@if (moduleStatusCheck('ExamPlan') == true)
    <li data-position="{{ menuPosition(2501) }}" class="sortable_li">
        <a href="{{ route('examplan.admitCard') }}">
            <span class="flaticon-book-1"></span>
            @lang('examplan::exp.admit_card')
        </a>
    </li>
@endif

@if(userPermission(39) && menuStatus(39))
    <li data-position="{{menuPosition(39)}}" class="sortable_li">
        <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
            
            
            <div class="nav_icon_small">
                <span class="flaticon-slumber"></span>
                </div>
                <div class="nav_title">
                    @lang('leave.leave')
                </div>
        </a>
        <ul class="list-unstyled" id="subMenuLeaveManagement">

            @if (userPermission(40) && menuStatus(40))

                <li data-position="{{ menuPosition(40) }}">
                    <a href="{{ route('student-apply-leave') }}">@lang('leave.apply_leave')</a>
                </li>
            @endif

            @if (userPermission(44) && menuStatus(44))

                <li data-position="{{ menuPosition(44) }}">
                    <a href="{{ route('student-pending-leave') }}">@lang('leave.pending_leave_request')</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if(moduleStatusCheck('OnlineExam') == true || (userPermission(45) && menuStatus(45)))
    <li data-position="{{menuPosition(45)}}" class="sortable_li">
        <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
            
           
            <div class="nav_icon_small">
                <span class="flaticon-test-1"></span>
                </div>
                <div class="nav_title">
                    @lang('exam.online_exam')
                </div>
        </a>
        <ul class="list-unstyled" id="subMenuStudentOnlineExam">

            @if (moduleStatusCheck('OnlineExam') == false)
                @if (userPermission(46) && menuStatus(46))
                    <li data-position="{{ menuPosition(46) }}">
                        <a href="{{ route('student_online_exam') }}">@lang('exam.active_exams')</a>
                    </li>
                @endif
                @if (userPermission(47) && menuStatus(47))
                    <li data-position="{{ menuPosition(47) }}">
                        <a href="{{ route('student_view_result') }}">@lang('exam.view_result')</a>
                    </li>
                @endif

            @elseif(moduleStatusCheck('OnlineExam') == true )

                @if (userPermission(2046) && menuStatus(2046))
                    <li data-position="{{ menuPosition(2046) }}">
                        <a href="{{ route('om_student_online_exam') }}"> @lang('exam.active_exams') </a>
                    </li>
                @endif

                @if (userPermission(2047) && menuStatus(2047))
                    <li data-position="{{ menuPosition(2047) }}">
                        <a href=" {{ route('om_student_view_result') }} "> @lang('exam.view_result') </a>
                    </li>
                @endif

                @if (userPermission(2048) && menuStatus(2048))
                    <li data-position="{{ menuPosition(2048) }}">
                        <a href="{{ route('student_pdf_exam') }} " class="active"> PDF @lang('exam.exam') </a>
                    </li>
                @endif

                @if (userPermission(2049) && menuStatus(2049))
                    <li data-position="{{ menuPosition(2049) }}">
                        <a href=" {{ route('student_view_pdf_result') }} "> PDF @lang('exam.exam_result') </a>
                    </li>
                @endif

            @endif

        </ul>
    </li>
@endif
@if(userPermission(48) && menuStatus(48))
    <li data-position="{{menuPosition(48)}}" class="sortable_li">
        <a href="{{route('student_noticeboard')}}">
            <div class="nav_icon_small">
                <span class="flaticon-poster"></span>
                </div>
                <div class="nav_title">
                    @lang('communicate.notice_board')
                </div>
        </a>
    </li>
@endif
@if(userPermission(49) && menuStatus(49))
    <li data-position="{{menuPosition(49)}}" class="sortable_li">
        <a href="{{route('student_subject')}}">
            <div class="nav_icon_small">
                <span class="flaticon-reading-1"></span>
                </div>
                <div class="nav_title">
                    @lang('common.subjects')
                </div>
        </a>
    </li>
@endif
@if(userPermission(50) && menuStatus(50))
    <li data-position="{{menuPosition(50)}}" class="sortable_li">
        <a href="{{route('student_teacher')}}">
           
           
            <div class="nav_icon_small">
                <span class="flaticon-professor"></span>
                </div>
                <div class="nav_title">
                    @lang('common.teacher')
                </div>
        </a>
    </li>
@endif
@if(userPermission(51) && menuStatus(51))
    <li data-position="{{menuPosition(51)}}" class="sortable_li">
        <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
           
            <div class="nav_icon_small">
                <span class="flaticon-book-1"></span>
                </div>
                <div class="nav_title">
                    @lang('library.library')
                </div>
        </a>
        <ul class="list-unstyled" id="subMenuStudentLibrary">
            @if(userPermission(52) && menuStatus(52))
                <li data-position="{{menuPosition(52)}}">
                    <a href="{{route('student_library')}}"> @lang('library.book_list')</a>
                </li>
            @endif
            @if (userPermission(53) && menuStatus(53))
                <li data-position="{{ menuPosition(53) }}">
                    <a href="{{ route('student_book_issue') }}">@lang('library.book_issue')</a>
                </li>
            @endif
        </ul>
    </li>
@endif
@if(userPermission(54) && menuStatus(54))
    <li data-position="{{menuPosition(54)}}" class="sortable_li">
        <a href="{{route('student_transport')}}">
            
           
            
            <div class="nav_icon_small">
                <span class="flaticon-bus"></span>
                </div>
                <div class="nav_title">
                    @lang('transport.transport')
                </div>
        </a>
    </li>
@endif
@if(userPermission(55) && menuStatus(55))
    <li data-position="{{menuPosition(55)}}" class="sortable_li">
        <a href="{{route('student_dormitory')}}">
           
           
            <div class="nav_icon_small">
                <span class="flaticon-hotel"></span>
                </div>
                <div class="nav_title">
                    @lang('dormitory.dormitory')
                </div>
        </a>
    </li>
@endif

@include('chat::menu')

<!-- Zoom Menu -->
@if (moduleStatusCheck('Zoom') == true)

    @include('zoom::menu.Zoom')
@endif

<!-- BBB Menu -->
@if (moduleStatusCheck('BBB') == true)
    @include('bbb::menu.bigbluebutton_sidebar')
@endif

@if (moduleStatusCheck('Gmeet') == true)
    @include('gmeet::menu')
@endif

{{-- @if (moduleStatusCheck('Lms') == true)
    @include('lms::menu.lms_sidebar')
@endif --}}

<!-- Jitsi Menu -->
@if (moduleStatusCheck('Jitsi') == true)
    @include('jitsi::menu.jitsi_sidebar')
@endif
