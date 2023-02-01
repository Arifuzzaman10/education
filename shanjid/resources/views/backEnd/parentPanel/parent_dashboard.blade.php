@extends('backEnd.master')
@section('title')
    @lang('parent.parent_dashboard')
@endsection
@section('mainContent')
    <section class="student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <div class="main-title">
                        <h3 class="mb-20">@lang('parent.my_children')</h3>
                    </div>
                </div>
            </div>
            {{-- <div class="row"> --}}
            @foreach($childrens as $children)
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Start Student Meta Information -->
                        <div class="main-title">
                            <h3 class="mb-20"><strong> {{$children->full_name}}</strong></h3>
                        </div>

                        @php
                            $student_detail=$children;

                            $totalSubjects = $student_detail->assignSubjects->where('academic_id', generalSetting()->session_id);

                            $online_exams = $student_detail->studentOnlineExams->where('academic_id', generalSetting()->session_id);

                            $teachers =  $student_detail->assignSubject->where('academic_id', generalSetting()->session_id);

                            $issueBooks = $student_detail->bookIssue;
                            $exams = $student_detail->examSchedule->where('academic_id', generalSetting()->session_id) ;

                            $homeworkLists = 0;
                            
                            foreach($student_detail->studentRecords as $record){
                                $homeworkLists += $record->getHomeWorkAttribute()->count();   
                            }
                                // ->where('academic_id', generalSetting()->session_id) ;

                            $attendances =  $student_detail->studentAttendances->where('academic_id', generalSetting()->session_id)

                        @endphp
                    </div>
                </div>
                <div class="row">
                    @if(userPermission(57))
                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('common.subject')</h3>
                                            <p class="mb-0">@lang('parent.total_subject')</p>
                                        </div>
                                        <h1 class="gradient-color2">

                                            @if(isset($totalSubjects))
                                                {{count($totalSubjects)}}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if(userPermission(58))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parent_noticeboard') }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.notice')</h3>
                                            <p class="mb-0">@lang('parent.total_notice')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if(isset($totalNotices))
                                                {{count($totalNotices)}}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if(userPermission(59))
                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.exam')</h3>
                                            <p class="mb-0">@lang('parent.total_exam')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if(isset($exams))
                                                {{count($exams)}}
                                            @endif
                                        </h1>
                                    </div>
                                    <h1 class="gradient-color2">
                                        @if(isset($exams))
                                            {{count($exams)}}
                                        @endif
                                    </h1>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if(userPermission(60))
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('student_online_exam') }}" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.online_exam')</h3>
                                            <p class="mb-0">@lang('parent.total_online_exam')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if(isset($online_exams))
                                                {{count($online_exams)}}
                                            @endif
                                        </h1>
                                    </div>
                                    <h1 class="gradient-color2">
                                        @if(isset($online_exams))
                                            {{count($online_exams)}}
                                        @endif
                                    </h1>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if(userPermission(61))

                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.teachers')</h3>
                                            <p class="mb-0">@lang('parent.total_teachers')</p>
                                        </div>
                                        <h1 class="gradient-color2"> @if(isset($teachers))
                                                {{count($teachers)}}
                                            @endif</h1>
                                    </div>
                                    <h1 class="gradient-color2"> @if(isset($teachers))
                                            {{count($teachers)}}
                                        @endif</h1>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if(userPermission(62))
                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.issued_book')</h3>
                                            <p class="mb-0">@lang('parent.total_issued_book')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if(isset($issueBooks))
                                                {{count($issueBooks)}}
                                            @endif
                                        </h1>
                                    </div>
                                    <h1 class="gradient-color2">
                                        @if(isset($issueBooks))
                                            {{count($issueBooks)}}
                                        @endif
                                    </h1>
                                </div>
                            </a>
                        </div>

                    @endif
                    @if(userPermission(63))
                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.pending_home_work')</h3>
                                            <p class="mb-0">@lang('parent.total_pending_home_work')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if(isset($homeworkLists))
                                                {{$homeworkLists}}
                                            @endif
                                        </h1>
                                    </div>
                                    <h1 class="gradient-color2">
                                        @if(isset($homeworkLists))
                                            {{$homeworkLists}}
                                        @endif
                                    </h1>
                                </div>
                            </a>
                        </div>
                    @endif
                    @if(userPermission(64))
                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="d-block">
                                <div class="white-box single-summery">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('parent.attendance_in_current_month')</h3>
                                            <p class="mb-0">@lang('parent.total_attendance_in_current_month')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if(isset($attendances))
                                                {{count($attendances)}}
                                            @endif
                                        </h1>
                                    </div>
                                    <h1 class="gradient-color2">
                                        @if(isset($attendances))
                                            {{count($attendances)}}
                                        @endif
                                    </h1>
                                </div>
                            </a>
                        </div>
                    @endif

                </div>
                {{-- </div> --}}
                <br>
            @endforeach

            @if(userPermission(65))
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">@lang('parent.calendar')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <div class='common-calendar'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <div id="fullCalModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span
                                class="sr-only">close</span></button>
                    <h4 id="modalTitle" class="modal-title"></h4>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="There are no image" id="image" height="150" width="auto">
                    <div id="modalBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript">
        /*-------------------------------------------------------------------------------
           Full Calendar Js
        -------------------------------------------------------------------------------*/
        if ($('.common-calendar').length) {
            $('.common-calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                eventClick: function (event, jsEvent, view) {
                    $('#modalTitle').html(event.title);
                    $('#modalBody').html(event.description);
                    $('#image').attr('src', event.url);
                    $('#fullCalModal').modal();
                    return false;
                },
                height: 650,
                events: <?php echo json_encode($calendar_events);?>
            });
        }
    </script>
@endpush