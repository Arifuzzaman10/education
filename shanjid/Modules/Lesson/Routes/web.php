<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['middleware' => ['subdomain']], function () {
    Route::prefix('lesson')->group(function () {
        Route::get('/', 'SmLessonController@index')->name('lesson')->middleware('userRolePermission:801');
        Route::post('/create-store', 'AjaxController@getSubject')->name('lesson.create-store');
        Route::get('lesson', 'SmLessonController@addLesson')->name('lesson.addLesson');
        Route::post('lesson', 'SmLessonController@storeLesson')->name('lesson.storelesson')->middleware('userRolePermission:802');

        Route::get('lesson-edit/{class_id}/{section_id}/{subject_id}', 'SmLessonController@editLesson')->name('lesson-edit')->middleware('userRolePermission:803');

        Route::get('un-lesson-edit/{session_id}/{faculty_id}/{department_id}/{academic_id}/{semester_id}/{semester_label_id}/{subject_id}', 'SmLessonController@editLessonForUniVersity')->name('un-lesson-edit')->middleware('userRolePermission:803');
        Route::post('lesson-update', 'SmLessonController@updateLesson')->name('lesson-update')->middleware('userRolePermission:803');
        Route::delete('lesson-delete/{id}', 'SmLessonController@deleteLesson')->name('lesson-delete')->middleware('userRolePermission:804');
        Route::get('lesson-item-delete/{id}', 'SmLessonController@deleteLessonItem')->name('lesson-item-delete')->middleware('userRolePermission:804');

        Route::get('topic', 'SmTopicController@index')->name('lesson.topic')->middleware('userRolePermission:805');
        Route::post('topic', 'SmTopicController@store')->name('lesson.topic.store')->middleware('userRolePermission:806');

        Route::get('topic-edit/{id}', 'SmTopicController@edit')->name('topic-edit')->middleware('userRolePermission:807');
        Route::post('topic-update', 'SmTopicController@updateTopic')->name('lesson.topic.update')->middleware('userRolePermission:807');
        Route::delete('topic-delete/{id}', 'SmTopicController@topicdelete')->name('topic-delete')->middleware('userRolePermission:808');

        Route::get('topicTitle-delete/{id}', 'SmTopicController@deleteTopicTitle')->name('topicTitle-delete')->middleware('userRolePermission:808');

        Route::get('lesson-plan', 'LessonPlanController@index')->name('lesson.lesson-planner')->middleware('userRolePermission:810');
        Route::get('lesson-plan/{teacher_id}', 'LessonPlanController@searchTeacherLessonPlan')->name('lesson.lesson-planner-teacher-search')->middleware('userRolePermission:810');
        Route::post('lesson-plan', 'LessonPlanController@lessonPlannerSearch')->name('lesson-planner');
        Route::post('add-new-lesson-plan', 'LessonPlanController@addNewLessonPlan')->name('add-new-lesson-plan');
        Route::get('lesson-plan-lesson/{day}/{teacher_id}/{routine_id}/{lesson_date}', 'LessonPlanController@lessonPlannerLesson')->name('add-lesson-planner-lesson');
        Route::get('view-lesson-plan-lesson/{lessonPlan_id}', 'LessonPlanController@ViewlessonPlannerLesson')->name('view-lesson-planner-lesson');
        Route::get('edit-lesson-plan-lesson/{lessonPlan_id}', 'LessonPlanController@EditlessonPlannerLesson')->name('edit-lesson-planner-lesson');

        Route::post('update-lesson-plan', 'LessonPlanController@updateLessonPlan')->name('update-lesson-plan');

        Route::get('delete-lesson-plan-lesson/{lessonPlan_id}', 'LessonPlanController@deleteLessonPlanModal')->name('delete-lesson-planner-lesson');
        Route::get('delete-lesson-plan/{id}', 'LessonPlanController@deleteLessonPlan')->name('delete-lesson-plan')->middleware('userRolePermission:813');
        Route::get('topic-overview', 'LessonPlanController@topicOverview')->name('topic-overview')->middleware('userRolePermission:809');
        Route::post('topic-overview', 'LessonPlanController@topicOverviewSearch')->name('search-topic-overview');
        Route::get('lessonPlan-overiew', 'LessonPlanController@manageLessonPlanner')->name('lesson.lessonPlan-overiew')->middleware('userRolePermission:815');
        Route::post('lessonPlan-overiew', 'LessonPlanController@searchLessonPlan')->name('search-lesson-plan');
        Route::post('lesson-complete-status', 'LessonPlanController@completeStatus')->name('lesson-complete-status');
        Route::post('lessonPlan-complete-status', 'LessonPlanController@LessonPlanStatus')->name('lessonPlan-complete-status');
        Route::post('lessonPlan-status-ajax', 'LessonPlanController@lessonPlanstatusAjax');
        Route::get('change-week/{teacher_id}/{next_date}', 'LessonPlanController@changeWeek');
        Route::get('dicrease-week/{teacher_id}/{pre_date}', 'LessonPlanController@discreaseChangeWeek');

        Route::get('report-lesson-plan', 'LessonPlanController@lessonPlanReport')->name('report-lesson-plan');
        Route::post('report-lesson-plan', 'LessonPlanController@searchlessonPlanReport')->name('serach-report-lesson-plan');
        Route::get('ajaxSelectSubject', 'LessonPlanController@ajaxSelectSubject');

        //for teacher
        Route::get('teacher/lessonPlan', 'Teacher\TeacherLessonPlanController@teacherLessonPlan')->name('view-teacher-lessonPlan');

        Route::get('teacher/lessonPlan-overview', 'Teacher\TeacherLessonPlanController@teacherLessonPlanOverview')->name('view-teacher-lessonPlan-overview');
        Route::post('teacher/lessonPlan-overview', 'Teacher\TeacherLessonPlanController@searchTeacherLessonPlanOverview')->name('search-teacher-lessonPlan-overview');

        Route::get('teacher/change-week/{next_date}', 'Teacher\TeacherLessonPlanController@changeWeek');
        Route::get('teacher/dicrease-week/{pre_date}', 'Teacher\TeacherLessonPlanController@discreaseChangeWeek');
        //Parents
        Route::get('parent/lessonPlan/{id}', 'Parent\ParentLessonPlanController@index')->name('lesson-parent-lessonPlan')->middleware('userRolePermission:98');
        Route::get('parent/lessonPlan-overview/{id}', 'Parent\ParentLessonPlanController@overview')->name('lesson-parent-lessonPlan-overview');

        Route::get('parent/change-week/{id}/{next_date}', 'Parent\ParentLessonPlanController@changeWeek');
        Route::get('parent/dicrease-week/{id}/{pre_date}', 'Parent\ParentLessonPlanController@discreaseChangeWeek');

        //ajax Controller
        Route::get('ajaxSelectLesson', 'AjaxController@ajaxSelectLesson');
        Route::get('ajaxSelectTopic', 'AjaxController@ajaxSelectTopic');
        Route::get('ajaxGetTopicRow', 'AjaxController@ajaxGetTopicRow');
        Route::post('delete-lesson-topic', 'LessonPlanController@deleteLessonTopic');
        Route::get('lessonSubject', 'AjaxController@getSubjectLesson');

        //students
        Route::get('student/lessonPlan', 'Student\StudentLessonPlanController@index')->name('lesson-student-lessonPlan');
        Route::get('student/lessonPlan-overview', 'Student\StudentLessonPlanController@overview')->name('lesson-student-lessonPlan-overview');

        Route::get('change-week/{next_date}', 'Student\StudentLessonPlanController@changeWeek');
        Route::get('dicrease-week/{pre_date}', 'Student\StudentLessonPlanController@discreaseChangeWeek');

        Route::get('download-document/{file_name}', function ($file_name = null) {
            $file = base_path() . '/Modules/Lesson/Resources/assets/document/' . $file_name;

            if (file_exists($file)) {
                return Response::download($file);
            }
        })->name('download-document');

        Route::get('lessonPlan-setting', 'LessonPlanController@setting')->name('lesson.lessonPlan-setting')->middleware('userRolePermission:835');
        Route::post('lessonPlan-setting', 'LessonPlanController@postSetting');
    });
});
