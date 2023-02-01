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

Route::group(['middleware' => ['subdomain']], function () {
    Route::prefix('rolepermission')->group(function () {
        Route::get('/', 'RolePermissionController@index');
        Route::get('/about', 'RolePermissionController@about');
        Route::get('role', 'RolePermissionController@role')->name('rolepermission/role')->middleware('userRolePermission:585');
        Route::post('role-store', 'RolePermissionController@roleStore')->name('rolepermission/role-store')->middleware('userRolePermission:418');
        Route::get('role-edit/{id}', 'RolePermissionController@roleEdit')->name('rolepermission/role-edit')->middleware('userRolePermission:419');
        Route::post('role-update', 'RolePermissionController@roleUpdate')->name('rolepermission/role-update')->middleware('userRolePermission:419');
        Route::post('role-delete', 'RolePermissionController@roleDelete')->name('rolepermission/role-delete')->middleware('userRolePermission:420');

        //  permission module


        Route::get('assign-permission/{id}', 'RolePermissionController@assignPermission')->name('rolepermission/assign-permission')->middleware('userRolePermission:541');
        Route::post('role-permission-assign', 'RolePermissionController@rolePermissionAssign')->name('rolepermission/role-permission-assign')->middleware('userRolePermission:541');


        Route::get('about', 'RolePermissionController@about');

    });
});