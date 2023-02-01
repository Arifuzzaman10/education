@if(userPermission(56) && menuStatus(56))
<li data-position="{{menuPosition(56)}}" class="sortable_li">
   <a href="{{route('parent-dashboard')}}">
       <div class="nav_icon_small">
             <span class="flaticon-resume"></span>
        </div>
        <div class="nav_title">
            @lang('common.dashboard')
        </div>
   </a>
</li>
@endif
@if(userPermission(66) && menuStatus(66))
   <li data-position="{{menuPosition(66)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
          <div class="nav_icon_small">
            <span class="flaticon-reading"></span>
            </div>
            <div class="nav_title">
                @lang('common.my_children')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuParentMyChildren">
           

           @foreach($childrens as $children)
               <li>
                   <a href="{{route('my_children', [$children->id])}}">{{$children->full_name}}</a>
               </li>
           @endforeach
       </ul>
   </li>
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
                @foreach($childrens as $children)
                    <li>
                        <a href="{{route('lms.allCourse',[$children->user_id])}}">@lang('lms::lms.all_course') ({{$children->full_name}})</a>
                    </li>
                    <li>
                        <a href="{{route('lms.enrolledCourse',[$children->user_id])}}">{{$children->full_name}} - @lang('lms::lms.course')</a>
                    </li>
                    <li>
                        <a href="{{route('lms.student.purchaseLog',[$children->user_id])}}">{{$children->full_name}} - @lang('lms::lms.purchase_history')</a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif
@endif


@if(generalSetting()->fees_status == 0)
    @if(userPermission(71) && menuStatus(71))
        <li data-position="{{menuPosition(71)}}" class="sortable_li">
            <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">


                <div class="nav_icon_small">
                    <span class="flaticon-wallet"></span>
                </div>
                <div class="nav_title">
                        @lang('fees.fees')
                </div>
            </a>
            <ul class="list-unstyled" id="subMenuParentFees">
                @foreach($childrens as $children)
                @if(moduleStatusCheck('FeesCollection')== false )
                    <li>
                        <a href="{{route('parent_fees', [$children->id])}}">{{$children->full_name}}</a>
                    </li>
                @else
                    <li>
                        <a href="{{route('feescollection/parent-fee-payment', [$children->id])}}">{{$children->full_name}}</a>
                    </li>

                @endif
                @endforeach
            </ul>
        </li>
    @endif
@endif

@if(moduleStatusCheck('Wallet'))
    @includeIf('wallet::menu.sidebar')
@endif

@if(generalSetting()->fees_status == 1)
    @includeIf('fees::sidebar.feesParentSidebar')
@endif

@if(userPermission(72) && menuStatus(72))
   <li data-position="{{menuPosition(72)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
           <div class="nav_icon_small">
                <span class="flaticon-calendar-1"></span>
            </div>
            <div class="nav_title">
                @lang('academics.class_routine')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuParentClassRoutine">
           @foreach($childrens as $children)
               <li>
                   <a href="{{route('parent_class_routine', [$children->id])}}">{{$children->full_name}}</a>
               </li>
           @endforeach
       </ul>
   </li>
@endif

@if(userPermission(97) && menuStatus(97))
   <li data-position="{{menuPosition(97)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
           <div class="nav_icon_small">
                <span class="flaticon-calendar-1"></span>
            </div>
            <div class="nav_title">
                @lang('lesson::lesson.lesson')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuLessonPlan">
            @foreach($childrens as $children)           
             @if(userPermission(98) && menuStatus(98))
               <li data-position="{{menuPosition(98)}}" >
                  <a href="{{route('lesson-parent-lessonPlan',[$children->id])}}"> {{$children->full_name}}-Lesson plan</a>
               </li>
               @endif
               @if(userPermission(99) && menuStatus(99))
                 <li data-position="{{menuPosition(99)}}" >
                 <a href="{{route('lesson-parent-lessonPlan-overview',[$children->id])}}">  {{$children->full_name}}- Lesson plan overview</a>
               </li>
               @endif
           @endforeach
       </ul>
   </li>
@endif
@if(userPermission(73) && menuStatus(73))
   <li data-position="{{menuPosition(73)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">

           <div class="nav_icon_small">
            <span class="flaticon-book"></span>
            </div>
            <div class="nav_title">
                @lang('homework.home_work')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuParentHomework">
           @foreach($childrens as $children)
               <li>
                   <a href="{{route('parent_homework', [$children->id])}}">{{$children->full_name}}</a>
               </li>
           @endforeach
       </ul>
   </li>
@endif
@if(userPermission(75) && menuStatus(75))
   <li data-position="{{menuPosition(75)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">

           <div class="nav_icon_small">
            <span class="flaticon-authentication"></span>
            </div>
            <div class="nav_title">
                @lang('student.attendance')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuParentAttendance">
           @foreach($childrens as $children)
               <li>
                   <a href="{{route('parent_attendance', [$children->id])}}">{{$children->full_name}}</a>
               </li>
           @endforeach
       </ul>
   </li>
@endif
@if(userPermission(76) && menuStatus(76))
   <li data-position="{{menuPosition(76)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">


           <div class="nav_icon_small">
            <span class="flaticon-test"></span>
            </div>
            <div class="nav_title">
                @lang('exam.exam')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuParentExamination">
           @foreach($childrens as $children)
               @if(userPermission(77) && menuStatus(77))
                   <li  data-position="{{menuPosition(77)}}">
                       <a href="{{route('parent_examination', [$children->id])}}">{{$children->full_name}}</a>
                   </li>
               @endif
               @if(userPermission(78) && menuStatus(78))
                   <li  data-position="{{menuPosition(78)}}">
                       <a href="{{route('parent_exam_schedule', [$children->id])}}">@lang('exam.exam_schedule')</a>
                   </li>
               @endif
           @endforeach
       </ul>
   </li>
@endif

@if (moduleStatusCheck('ExamPlan') == true)
    {{-- @if(userPermission(2503) && menuStatus(2503)) --}}
    <li data-position="{{menuPosition(2503)}}" class="sortable_li">
        <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="flaticon-reading"></span>
                </div>
                <div class="nav_title">
                    @lang('examplan::exp.admit_card')
                </div>
        </a>
        <ul class="list-unstyled" id="subMenuParentMyChildren">
            @foreach($childrens as $children)
                <li>
                    <a href="{{ route('examplan.admitCardParent', [$children->id]) }}">{{$children->full_name}}</a>
                </li>
            @endforeach
        </ul>
    </li>
    {{-- @endif --}}
@endif



@if (moduleStatusCheck('ExamPlan') == true)
    @if(userPermission(2503) && menuStatus(2503))
    <li data-position="{{menuPosition(2503)}}" class="sortable_li">
        <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="flaticon-reading"></span>
                </div>
                <div class="nav_title">
                    @lang('examplan::exp.admit_card')
                </div>
        </a>
        <ul class="list-unstyled" id="subMenuParentMyChildren">
            @foreach($childrens as $children)
                <li>
                    <a href="{{ route('examplan.admitCardParent', [$children->id]) }}">{{$children->full_name}}</a>
                </li>
            @endforeach
        </ul>
    </li>
    @endif
@endif



@if (moduleStatusCheck('OnlineExam') == false)
    
    @if(userPermission(2016) && menuStatus(2016))
    <li data-position="{{menuPosition(2016)}}" class="sortable_li">
        <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
           <div class="nav_icon_small">
            <span class="flaticon-test"></span>
            </div>
            <div class="nav_title">
                @lang('exam.online_exam')
            </div>
        </a>
        <ul class="list-unstyled" id="subMenuOnlineExam">
            @if(moduleStatusCheck('OnlineExam') == false ) 
                @foreach($childrens as $children) 
                    @if(userPermission(2018) && menuStatus(2018))
                    <li  data-position="{{menuPosition(2018)}}">
                        <a href="{{ route('parent_online_examination', [$children->id])}}">@lang('exam.online_exam') - {{$children->full_name}}</a>
                    </li>
                    @endif
                    @if(userPermission(2017) && menuStatus(2017))
                        <li  data-position="{{menuPosition(2017)}}">
                        <a href="{{ route('parent_online_examination_result', [$children->id])}}">@lang('exam.online_exam_result') - {{$children->full_name}}</a>
                    </li>
                @endif
                <hr>
                @endforeach

            @endif      
            </ul>
        </li>
        @endif 
@endif
    @if (moduleStatusCheck('OnlineExam') == true)
        
        @if(userPermission(2101) && menuStatus(2101))
        <li data-position="{{menuPosition(79)}}" class="sortable_li">
            <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
                <div class="nav_icon_small">
                    <span class="flaticon-test"></span>
                    </div>
                    <div class="nav_title">
                        @lang('onlineexam::onlineExam.online_exam')
                    </div>
            </a>
            <ul class="list-unstyled" id="subMenuOnlineExamModule">
                
                
                    @foreach($childrens as $children)
                        @if(userPermission(2001) && menuStatus(2001))                           
                            <li data-position="{{menuPosition(2001)}}">                                            
                                <a href="{{route('om_parent_online_examination',$children->id)}}">  @lang('onlineexam::onlineExam.online_exam') {{count($childrens) >1 ? '-'.$children->full_name :''}} </a>
                            </li>  
                        @endif
                        @if(userPermission(2002) && menuStatus(2002))                           
                            <li data-position="{{menuPosition(2002)}}">                                            
                                <a href="{{route('om_parent_online_examination_result',$children->id)}}">  @lang('onlineexam::onlineExam.online_exam_result') {{count($childrens) >1 ? '-'.$children->full_name :''}} </a>
                            </li>  
                        @endif
                        @if(userPermission(2103) && menuStatus(2103))                           
                            <li data-position="{{menuPosition(2103)}}">                                            
                                <a href="{{route('parent_pdf_exam',$children->id)}}">  @lang('onlineexam::onlineExam.pdf_exam') {{count($childrens) >1 ? '-'.$children->full_name :''}} </a>
                            </li>  
                        @endif                                   
                        @if(userPermission(2104) && menuStatus(2104))   
                            <li data-position="{{menuPosition(2104)}}"> 
                                <a href="{{route('parent_view_pdf_result',$children->id)}}"> @lang('onlineexam::onlineExam.pdf_exam_result')  {{count($childrens) >1 ? '-'.$children->full_name :''}} </a>
                            </li> 
                        @endif 
                                            
                        <hr>
                    @endforeach
        
                
                </ul>
            </li>
            @endif 
    @endif 


@if(userPermission(80) && menuStatus(80))
   <li data-position="{{menuPosition(80)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
           <div class="nav_icon_small">
            <span class="flaticon-test"></span>
            </div>
            <div class="nav_title">
                @lang('leave.leave')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuParentLeave">
           @foreach($childrens as $children)
               <li >
                   <a href="{{route('parent_leave', [$children->id])}}">{{$children->full_name}}</a>
               </li>
           @endforeach
           @if(userPermission(81) && menuStatus(81))
               <li  data-position="{{menuPosition(81)}}">
                   <a href="{{route('parent-apply-leave')}}">@lang('leave.apply_leave')</a>
               </li>
           @endif
           @if(userPermission(82) && menuStatus(82))
               <li  data-position="{{menuPosition(82)}}">
                   <a href="{{route('parent-pending-leave')}}">@lang('leave.pending_leave_request')</a>
               </li>
           @endif
           
       </ul>
   </li>
@endif
@if(userPermission(85) && menuStatus(85))
   <li data-position="{{menuPosition(85)}}" class="sortable_li">
       <a href="{{route('parent_noticeboard')}}">
           <div class="nav_icon_small">
            <span class="flaticon-poster"></span>
            </div>
            <div class="nav_title">
                @lang('communicate.notice_board')
            </div>
       </a>
   </li>
@endif
@if(userPermission(86) && menuStatus(86))
   <li data-position="{{menuPosition(86)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">


           <div class="nav_icon_small">
            <span class="flaticon-reading-1"></span>
            </div>
            <div class="nav_title">
                @lang('common.subjects')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuParentSubject">
           @foreach($childrens as $children)
               <li>
                   <a href="{{route('parent_subjects', [$children->id])}}">{{$children->full_name}}</a>
               </li>
           @endforeach
       </ul>
   </li>
@endif
@if(userPermission(87) && menuStatus(87))
   <li data-position="{{menuPosition(87)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
           <div class="nav_icon_small">
                <span class="flaticon-professor"></span>
            </div>
            <div class="nav_title">
                @lang('common.teacher_list')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuParentTeacher">
           @foreach($childrens as $children)
               <li>
                   <a href="{{route('parent_teacher_list', [$children->id])}}">{{$children->full_name}}</a>
               </li>
           @endforeach
       </ul>
   </li>
@endif
@if(userPermission(88) && menuStatus(88))
   <li data-position="{{menuPosition(88)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
           <div class="nav_icon_small">
                <span class="flaticon-book-1"></span>
            </div>
            <div class="nav_title">
                @lang('library.library')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuStudentLibrary">
           @if(userPermission(89) && menuStatus(89))
               <li data-position="{{menuPosition(89)}}">
                   <a href="{{route('parent_library')}}"> @lang('library.book_list')</a>
               </li>
           @endif
           @if(userPermission(90) && menuStatus(90))
               <li data-position="{{menuPosition(90)}}">
                   <a href="{{route('parent_book_issue')}}">@lang('library.book_issue')</a>
               </li>
           @endif
       </ul>
   </li>
@endif
@if(userPermission(91) && menuStatus(91))
   <li data-position="{{menuPosition(91)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">


           <div class="nav_icon_small">
            <span class="flaticon-bus"></span>
            </div>
            <div class="nav_title">
                @lang('transport.transport')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuParentTransport">
           @foreach($childrens as $children)
               <li>
                   <a href="{{route('parent_transport', [$children->id])}}">{{$children->full_name}}</a>
               </li>
           @endforeach
       </ul>
   </li>
@endif
@if(userPermission(92) && menuStatus(92))
   <li data-position="{{menuPosition(92)}}" class="sortable_li">
       <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">


           <div class="nav_icon_small">
            <span class="flaticon-hotel"></span>
            </div>
            <div class="nav_title">
                @lang('dormitory.dormitory_list')
            </div>
       </a>
       <ul class="list-unstyled" id="subMenuParentDormitory">
           @foreach($childrens as $children)
               <li>
                   <a href="{{route('parent_dormitory_list', [$children->id])}}">{{$children->full_name}}</a>
               </li>
           @endforeach
       </ul>
   </li>
@endif

<!-- chat module sidebar -->

 @if(userPermission(910) && menuStatus(910))
<li  data-position="{{menuPosition(900)}}" class="sortable_li">
    <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">


        <div class="nav_icon_small">
            <span class="flaticon-test"></span>
            </div>
            <div class="nav_title">
                @lang('chat::chat.chat')
            </div>
    </a>
    <ul class="list-unstyled" id="subMenuChat">
        @if(userPermission(911) && menuStatus(911))
        <li  data-position="{{menuPosition(901)}}" >
            <a href="{{ route('chat.index') }}">@lang('chat::chat.chat_box')</a>
        </li>
        @endif

        @if(userPermission(913) && menuStatus(913))
        <li data-position="{{menuPosition(903)}}" >
            <a href="{{ route('chat.invitation') }}">@lang('chat::chat.invitation')</a>
        </li>
        @endif

        @if(userPermission(914) && menuStatus(914))
            <li data-position="{{menuPosition(904)}}" >
                <a href="{{ route('chat.blocked.users') }}">@lang('chat::chat.blocked_user')</a>
            </li>
        @endif

     
    </ul>
</li>
@endif

<!-- BBB Menu  -->   
     @if(moduleStatusCheck('BBB') == true)
        @if(userPermission(105) && menuStatus(105))
                <li data-position="{{menuPosition(105)}}" class="sortable_li">
                <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">


                <div class="nav_icon_small">
                    <span class="flaticon-reading"></span>
                    </div>
                    <div class="nav_title">
                        @lang('bbb::bbb.bbb')
                    </div>
                </a>
                            <ul class="list-unstyled" id="bigBlueButtonMenu">
                                @foreach($childrens as $children)
                                    @if(userPermission(106) && menuStatus(106))
                                        <li data-position="{{menuPosition(106)}}" >
                                            <a href="{{ route('bbb.parent.virtual-class',[$children->id])}}">@if(count($childrens)>1){{$children->full_name}} @endif @lang('common.virtual_class')</a>
                                        </li>
                                    @endif
                                @endforeach
                                @if(userPermission(107) && menuStatus(107))
                                    <li data-position="{{menuPosition(107)}}" >
                                        <a href="{{ route('bbb.meetings') }}">@lang('common.virtual_meeting')</a>
                                    </li>
                                @endif
                                @foreach($childrens as $children)
                                @if(userPermission(115) && menuStatus(115))
                                    <li data-position="{{menuPosition(115)}}" >
                                        <a href="{{ route('bbb.parent.class.recording.list', $children->id) }}">@if(count($childrens)>1){{$children->full_name}} @endif @lang('common.class_record_list')</a>
                                    </li>
                                @endif
                                @endforeach
                            
                                @if(userPermission(116) && menuStatus(116))
                                    <li data-position="{{menuPosition(116)}}" >
                                        <a href="{{ route('bbb.parent.meeting.recording.list') }}"> @lang('bbb::bbb.meeting_record_list')</a>
                                    </li>
                                @endif

                            </ul>
                </li>

        @endif    

@endif
<!-- BBB  Menu end -->   
<!-- Jitsi Menu  -->      
    @if(moduleStatusCheck('Jitsi')==true)
     @if(userPermission(108) && menuStatus(108))
        <li data-position="{{menuPosition(108)}}" class="sortable_li">
                <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
                <div class="nav_icon_small">
                    <span class="flaticon-reading"></span>
                    </div>
                    <div class="nav_title">
                        @lang('jitsi::jitsi.jitsi')
                    </div>
                </a>
                <ul class="list-unstyled" id="subMenuJisti">
                    @foreach($childrens as $children)
                        @if(userPermission(109) && menuStatus(109))
                            <li data-position="{{menuPosition(109)}}" >
                                <a href="{{ route('jitsi.parent.virtual-class',[$children->id])}}">@if(count($childrens)>1){{$children->full_name}} @endif @lang('common.virtual_class')</a>
                            </li>
                        @endif
                    @endforeach
                    @if(userPermission(110) && menuStatus(110))
                        <li data-position="{{menuPosition(110)}}" >
                            <a href="{{ route('jitsi.meetings') }}">@lang('common.virtual_meeting')</a>
                        </li>
                    @endif
                
                </ul>
        </li>

    @endif        
@endif
<!-- jitsi Menu end -->

<!-- Zomm Menu  start -->
     @if(moduleStatusCheck('Zoom') == TRUE)

        @if(userPermission(100) && menuStatus(100))
            <li data-position="{{menuPosition(100)}}" class="sortable_li">
                <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
                <div class="nav_icon_small">
                    <span class="flaticon-reading"></span>
                    </div>
                    <div class="nav_title">
                        @lang('zoom::zoom.zoom')
                    </div>
                </a>
                <ul class="list-unstyled" id="zoomMenu">

                    @foreach($childrens as $children)
                        @if(userPermission(101) && menuStatus(101))
                            <li data-position="{{menuPosition(101)}}" >
                                <a href="{{ route('zoom.parent.virtual-class',[$children->id])}}">@if(count($childrens)>1){{$children->full_name}} @endif @lang('common.virtual_class')</a>
                            </li>
                        @endif
                    @endforeach
                    @if(userPermission(103) && menuStatus(103))
                        <li data-position="{{menuPosition(103)}}" >
                            <a href="{{ route('zoom.parent.meetings') }}">@lang('common.virtual_meeting')</a>
                        </li>
                    @endif

                </ul>
            </li>
        @endif
@endif
<!-- zoom Menu  -->
@if(moduleStatusCheck('Gmeet') == TRUE)
    @if(userPermission(3105) && menuStatus(3105))
        <li data-position="{{menuPosition(3105)}}" class="sortable_li">
            <a href="javascript:void(0)" class="has-arrow" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="flaticon-reading"></span>
                </div>
                <div class="nav_title">
                    @lang('gmeet::gmeet.gmeet')
                </div>
            </a>
            <ul class="list-unstyled" id="gmeetMenu">

                @foreach($childrens as $children)
                    @if(userPermission(3106) && menuStatus(3106))
                        <li data-position="{{menuPosition(3106)}}" >
                            <a href="{{ route('g-meet.virtual-class.parent.virtual-class',[$children->id])}}">@if(count($childrens)>1){{$children->full_name}} @endif @lang('common.virtual_class')</a>
                        </li>
                    @endif
                @endforeach
                @if(userPermission(3107) && menuStatus(3107))
                    <li data-position="{{menuPosition(3107)}}" >
                        <a href="{{ route('g-meet.virtual-meeting.index') }}">@lang('common.virtual_meeting')</a>
                    </li>
                @endif

            </ul>
        </li>
    @endif
@endif