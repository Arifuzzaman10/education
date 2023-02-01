<?php

use Illuminate\Support\Facades\Route;

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

// Route::prefix('zoom')->group(function() {
//     Route::get('/', 'ZoomController@index');
// });

Route::group(['middleware' => ['subscriptionAccessUrl']], function () {
    Route::prefix('zoom')->group(function () {
        Route::name('zoom.')->group(function () {
            Route::get('about', 'MeetingController@about');
            
            Route::get('meetings', 'MeetingController@index')->name('meetings')->middleware('userRolePermission:560');
            Route::get('meetings/parent', 'MeetingController@index')->name('parent.meetings')->middleware('userRolePermission:103');
            Route::post('meetings', 'MeetingController@store')->name('meetings.store')->middleware('userRolePermission:556');
            Route::get('meetings-show/{id}', 'MeetingController@show')->name('meetings.show');
            Route::get('meetings-edit/{id}', 'MeetingController@edit')->name('meetings.edit')->middleware('userRolePermission:562');
            Route::post('meetings/{id}', 'MeetingController@update')->name('meetings.update')->middleware('userRolePermission:562');
            Route::delete('meetings/{id}', 'MeetingController@destroy')->name('meetings.destroy')->middleware('userRolePermission:563');
            
            Route::get('virtual-class', 'VirtualClassController@index')->name('virtual-class')->middleware('userRolePermission:555');
            Route::get('virtual-class/child/{id}', 'VirtualClassController@mychild')->name('parent.virtual-class')->middleware('userRolePermission:101');
            Route::post('virtual-class', 'VirtualClassController@store')->name('virtual-class.store')->middleware('userRolePermission:561');
            Route::get('virtual-class-show/{id}', 'VirtualClassController@show')->name('virtual-class.show');
            Route::get('virtual-class-edit/{id}', 'VirtualClassController@edit')->name('virtual-class.edit')->middleware('userRolePermission:555');
            Route::post('virtual-class/{id}', 'VirtualClassController@update')->name('virtual-class.update')->middleware('userRolePermission:555');
            Route::delete('virtual-class/{id}', 'VirtualClassController@destroy')->name('virtual-class.destroy')->middleware('userRolePermission:555');
            
            Route::get('meeting-room/{id}', 'VirtualClassController@meetingStart')->name('virtual-class.join');
            Route::get('virtual-class-room/{id}', 'MeetingController@meetingStart')->name('meeting.join');
            Route::get('user-list-user-type-wise', 'MeetingController@userWiseUserList')->name('user.list.user.type.wise');
            Route::get('settings', 'SettingController@settings')->name('settings')->middleware('userRolePermission:569');
            Route::get('user/settings', 'SettingController@userSettings')->name('userSettings')->middleware('userRolePermission:569');
           
            Route::post('upload_document','VirtualClassController@updateVedio')->name('upload_document');
            Route::get('virtual-upload-vedio-file/{id}','VirtualClassController@fileUpload')->name('virtual-upload-vedio-file');
            Route::get('meeting-upload-vedio-file/{id}','MeetingController@fileUpload')->name('meeting-upload-vedio-file');
            Route::post('settings', 'SettingController@updateSettings')->name('settings.update');
            Route::post('ind/settings', 'SettingController@updateIndSettings')->name('ind.settings.update');
            Route::get('virtual-class-reports', 'ReportController@report')->name('virtual.class.reports.show')->middleware('userRolePermission:565');
            Route::get('meeting-reports', 'ReportController@meetingReport')->name('meeting.reports.show')->middleware('userRolePermission:567');
        });
    });
});