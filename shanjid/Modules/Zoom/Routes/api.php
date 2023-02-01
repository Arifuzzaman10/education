<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['XSS','auth:api','json.response']], function () {
 


//Virtual Claas


 //Zoom Meeting
 Route::get('/zoom-make-meeting/user_id/{id}','ZoomApiController@zoomMakeMeeting');
 Route::get('/zoom-member-list/role_id/{role_id}','ZoomApiController@zoomMemberLiszt');
 Route::post('/zoom-store-meeting','ZoomApiController@zoomStoreMeeting');
 Route::get('/zoom-edit-meeting/meeting_id/{meeting_id}/user_id/{uesr_id}','ZoomApiController@zoomEditMeeting');
 Route::post('/zoom-update-meeting','ZoomApiController@zoomUpdateMeeting');
 Route::get('/zoom-delete-meeting/meeting_id/{meeting_id}/','ZoomApiController@zoomDeleteMeeting');
 Route::get('zoom-meeting-room/meeting_id/{meeting_id}/user_id/{user_id}', 'ZoomApiController@meetingStart');
//  Route::get('zoom-meeting-list/{user_id}', 'ZoomApiController@meetingList');
 
//Virtual Claas

Route::get('zoom-class-update/{cid}/{uid}','ZoomApiController@ClassEdit');
 Route::get('zoom/create-virtual-class/user_id/{user_id}','ZoomApiController@makeVirtualClass');
//teacher-section-list?id=1&class=2 [note: id=user_id,]
Route::post('zoom/virtual-class-store','ZoomApiController@storeVirtualClass');
Route::get('zoom/class-info/class_id/{class_id}','ZoomApiController@showClassInfo');
Route::post('zoom-class-update','ZoomApiController@ClassUpdate');
Route::get('zoom-class-room/meeting_id/{meeting_id}/user_id/{user_id}', 'ZoomApiController@classStart');

});