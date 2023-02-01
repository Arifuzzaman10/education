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

Route::prefix('parentregistration')->group(function () {
    Route::get('/', 'ParentRegistrationController@index');
    Route::get('/about', 'ParentRegistrationController@about');
    Route::get('/registration', 'ParentRegistrationController@registration');

    Route::get('/get-class-academicyear', 'ParentRegistrationController@getClasAcademicyear');
    Route::get('/get-section', 'ParentRegistrationController@getSection');

    Route::get('/get-classes', 'ParentRegistrationController@getClasses');

    Route::post('/student-store', 'ParentRegistrationController@studentStore');

    Route::get('/saas-student-list', 'ParentRegistrationController@saasStudentList');
    Route::post('/saas-student-list', 'ParentRegistrationController@saasStudentListsearch');

    Route::get('/student-list', 'ParentRegistrationController@studentList');
    Route::post('/student-list', 'ParentRegistrationController@studentListSearch');

    Route::post('student-approve', 'ParentRegistrationController@studentApprove');
    Route::get('student-view/{id}', 'ParentRegistrationController@studentView');

    Route::post('student-delete', 'ParentRegistrationController@studentDelete');


    Route::get('check-student-email', 'ParentRegistrationController@checkStudentEmail');

    Route::get('check-student-mobile', 'ParentRegistrationController@checkStudentMobile');

    Route::get('check-guardian-email', 'ParentRegistrationController@checkGuardianEmail');

    Route::get('check-guardian-mobile', 'ParentRegistrationController@checkGuardianMobile');

    // setting route
    Route::get('settings', 'ParentRegistrationController@settings');
    Route::post('settings', 'ParentRegistrationController@Updatesettings');
});
