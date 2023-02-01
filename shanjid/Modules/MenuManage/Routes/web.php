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
    Route::prefix('menumanage')->group(function () {
        Route::name('menumanage.')->middleware('auth')->group(function () {

            Route::get('/', 'MenuManageController@index')->name('index');
            Route::post('menu-store', 'MenuManageController@store')->name('store.menu');
            Route::get('reset', 'MenuManageController@reset')->name('reset');

        });
    });
});
 
