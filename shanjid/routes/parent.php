<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['XSS', 'subdomain']], function () {
    // Parent Panel
    Route::group(['middleware' => ['ParentMiddleware']], function () {
        Route::get('parent-dashboard',  'Parent\SmParentPanelController@ParentDashboard')->name('parent-dashboard')->middleware('userRolePermission:56');
        Route::get('my-children/{id}', ['as' => 'my_children', 'uses' => 'Parent\SmParentPanelController@myChildren'])->middleware('userRolePermission:66');
        Route::get('update-my-children/{id}', 'Parent\SmParentPanelController@UpdatemyChildren')->name('update-my-children')->middleware('userRolePermission:66');
        Route::post('my-children-update', 'Parent\SmParentPanelController@studentUpdate')->name('my-children-update')->middleware('userRolePermission:66');
        Route::get('parent-fees/{id}', ['as' => 'parent_fees', 'uses' => 'Parent\SmFeesController@childrenFees'])->middleware('userRolePermission:71');
        Route::get('parent-class-routine/{id}', ['as' => 'parent_class_routine', 'uses' => 'Parent\SmParentPanelController@classRoutine'])->middleware('userRolePermission:72');
        Route::get('parent-attendance/{id}', ['as' => 'parent_attendance', 'uses' => 'Parent\SmParentPanelController@attendance'])->middleware('userRolePermission:75');
        Route::get('my-child-attendance/print/{student_id}/{id}/{month}/{year}/', 'Parent\SmParentPanelController@attendancePrint')->name('my_child_attendance_print');
        Route::get('parent-homework/{id}', ['as' => 'parent_homework', 'uses' => 'Parent\SmParentPanelController@homework'])->middleware('userRolePermission:73');
        Route::get('parent-homework-view/{class_id}/{section_id}/{homework}', ['as' => 'parent_homework_view', 'uses' => 'Parent\SmParentPanelController@homeworkView'])->middleware('userRolePermission:74');
        

        Route::get('university/parent-homework-view/{sem_label_id}/{homework}', ['as' => 'un_student_homework_view', 'uses' => 'Parent\SmParentPanelController@unStudentHomeworkView']);

        Route::get('parent-noticeboard', ['as' => 'parent_noticeboard', 'uses' => 'Parent\SmParentPanelController@parentNoticeboard'])->middleware('userRolePermission:85');
        Route::post('parent-attendance-search', ['as' => 'parent_attendance_search', 'uses' => 'Parent\SmParentPanelController@attendanceSearch']);
        Route::post('parent-exam-schedule/print','SmExamRoutineController@examSchedulePrint')->name('parent_exam_schedule_print');
        Route::get('parent-online-examination/{id}', ['as' => 'parent_online_examination', 'uses' => 'Parent\SmParentPanelController@onlineExamination'])->middleware('userRolePermission:79');
        Route::get('parent-online-examination-result/{id}', ['as' => 'parent_online_examination_result', 'uses' => 'Parent\SmParentPanelController@onlineExaminationResult'])->middleware('userRolePermission:79');
        Route::get('parent-answer-script/{exam_id}/{s_id}', ['as' => 'parent_answer_script', 'uses' => 'Parent\SmParentPanelController@parentAnswerScript']);
        Route::get('parent-leave/{id}', ['as' => 'parent_leave', 'uses' => 'Parent\SmParentPanelController@parentLeave']);

        // Leave
        Route::get('parent-apply-leave', 'Parent\SmParentPanelController@leaveApply')->name('parent-apply-leave')->middleware('userRolePermission:81');
        Route::post('parent-leave-store', 'Parent\SmParentPanelController@leaveStore')->name('parent-leave-store')->middleware('userRolePermission:82');
        Route::get('parent-view-leave-details-apply/{id}', 'Parent\SmParentPanelController@viewLeaveDetails')->name('parent-view-leave-details-apply')->middleware('userRolePermission:85');
        Route::get('parent-leave-edit/{id}', 'Parent\SmParentPanelController@parentLeaveEdit')->name('parent-leave-edit')->middleware('userRolePermission:83');
        Route::get('parent-pending-leave', 'Parent\SmParentPanelController@pendingLeave')->name('parent-pending-leave')->middleware('userRolePermission:82');
        Route::put('parent-leave-update/{id}', 'Parent\SmParentPanelController@update')->name('parent-leave-update')->middleware('userRolePermission:83');
        Route::delete('parent-leave-delete/{id}', 'Parent\SmParentPanelController@DeleteLeave')->name('parent-leave-delete')->middleware('userRolePermission:86');

        Route::get('parent-examination/{id}', ['as' => 'parent_examination', 'uses' => 'Parent\SmParentPanelController@examination'])->middleware('userRolePermission:77');
        Route::get('parent-examination-schedule/{id}', ['as' => 'parent_exam_schedule', 'uses' => 'Parent\SmParentPanelController@examinationSchedule'])->middleware('userRolePermission:78');
        Route::post('parent-examination-schedule', ['as' => 'parent_exam_schedule_search', 'uses' => 'Parent\SmParentPanelController@examinationScheduleSearch']);

                //abunayem
        Route::get('parent-routine-print/{class_id}/{section_id}/{exam_period_id}', 'Parent\SmParentPanelController@examRoutinePrint')->name('parent-routine-print');

        // Student Library Book list
        Route::get('parent-library', ['as' => 'parent_library', 'uses' => 'Parent\SmParentPanelController@parentBookList'])->middleware('userRolePermission:89');
        Route::get('parent-book-issue', ['as' => 'parent_book_issue', 'uses' => 'Parent\SmParentPanelController@parentBookIssue'])->middleware('userRolePermission:90');
        Route::get('parent-subjects/{id}', ['as' => 'parent_subjects', 'uses' => 'Parent\SmParentPanelController@subjects'])->middleware('userRolePermission:86');
        Route::get('parent-teacher-list/{id}', ['as' => 'parent_teacher_list', 'uses' => 'Parent\SmParentPanelController@teacherList'])->middleware('userRolePermission:87');
        Route::get('parent-transport/{id}', ['as' => 'parent_transport', 'uses' => 'Parent\SmParentPanelController@transport'])->middleware('userRolePermission:91');
        Route::get('parent-dormitory/{id}', ['as' => 'parent_dormitory_list', 'uses' => 'Parent\SmParentPanelController@dormitory'])->middleware('userRolePermission:92');

        // Dowmload 
        Route::get('parent/student-download-timeline-doc/{file_name}', ['as' => 'parent_student_download_timeline_doc', 'uses' => 'Parent\SmParentPanelController@StudentDownload']);
    });
});