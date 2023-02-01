<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

if (config('app.app_sync') and !session('domain')) {
    Route::get('/', 'LandingController@index')->name('/');
} else {
    if (moduleStatusCheck('Saas') == TRUE) {
        Route::get('login', 'Auth\LoginController@loginFormTwo')->name('login');
    }
    Route::get('/', 'SmFrontendController@index')->name('/');
}

Route::get('login', 'Auth\LoginController@loginFormTwo')->name('login');

Route::post('login', 'Auth\LoginController@login');

Route::get('/academic_years', 'HomeController@academicUpdate');
Route::get('/class_updates', 'HomeController@classUpdate');
Route::get('/section_updates', 'HomeController@sectionUpdate');
Route::get('/class_section_updates', 'HomeController@sectionClassUpdate');
Route::get('/new_updates', 'HomeController@classSectionAllUpdate');
Route::get('/db_update_new', 'HomeController@dbUpdate');
Route::get('/student_update', 'HomeController@studentUpdate');
Route::get('/class_update_new', 'HomeController@classUpdateNew');
Route::get('home', 'SmFrontendController@index');
Route::get('/after-login', 'HomeController@dashboard');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('ajax-get-login-access', 'SmAuthController@getLoginAccess');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('home', 'SmFrontendController@index');
Route::get('about', 'SmFrontendController@about');
Route::get('course', 'SmFrontendController@course');
Route::post('load-more-course', 'SmFrontendController@loadMoreCourse')->name('load-more-course');
Route::get('course-Details/{id}', 'SmFrontendController@courseDetails')->name('course-Details')->where('id', '[0-9]+');
Route::get('news-page', 'SmFrontendController@newsPage');
Route::post('load-more-news', 'SmFrontendController@loadMoreNews')->name('load-more-news');
Route::get('news-details/{id}', 'SmFrontendController@newsDetails')->name('news-Details')->where('id', '[0-9]+');
Route::get('contact', 'SmFrontendController@contact');

Route::get('view/single/notification/{id}', 'SmNotificationController@viewSingleNotification')->where('id', '[0-9]+');

Route::get('view/all/notification/{id}', 'SmNotificationController@viewAllNotification')->name('view/all/notification')->where('id', '[0-9]+');
Route::get('notification-show/{id}', 'SmNotificationController@udpateNotification')->name('notification-show');

Route::get('view/notice/{id}', 'HomeController@viewNotice')->where('id', '[0-9]+')->where('id', '[0-9]+')->name('view-notice');
// update password

Route::get('change-password', 'HomeController@updatePassowrd')->name('updatePassowrd');
Route::post('admin-change-password', 'HomeController@updatePassowrdStore')->name('updatePassowrdStore'); //InfixPro Version

Route::get('download-uploaded-content/{id}/{student_id}', 'Student\SmStudentPanelController@downloadHomeWorkContent')->name('downloadHomeWorkContent');

Route::post('/pay-with-paystack', 'Student\SmFeesController@redirectToGateway')->name('pay-with-paystack');

Route::get('/payment/callback', 'Student\SmFeesController@handleGatewayCallback')->name('handleGatewayCallback');

//customer panel

Route::group(['middleware' => ['CustomerMiddleware']], function () {
    Route::get('customer-dashboard', ['as' => 'customer_dashboard', 'uses' => 'Customer\SmCustomerPanelController@customerDashboard']);
    Route::get('customer-purchases', 'Customer\SmCustomerPanelController@customerPurchases');
});
Route::get('student-transport-view-modal/{r_id}/{v_id}', ['as' => 'student_transport_view_modal', 'uses' => 'Student\SmStudentPanelController@studentTransportViewModal']);

//Install for Demo
Route::post('/verified-code', 'InstallController@verifiedCodeStore')->name('verifiedCodeStore');

//for localization
Route::get('locale/{locale}', 'Admin\SystemSettings\SmSystemSettingController@changeLocale');
Route::get('change-language/{id}', 'Admin\SystemSettings\SmSystemSettingController@changeLanguage')->name('change-language');


Route::get('verify/', 'VerifyController@index');
Route::put('/verify/storePurchasecode/{id}', 'VerifyController@storePurchasecode');
Route::put('/verify/storePurchasecode/{id}', 'VerifyController@storePurchasecode');


Route::get('/news', 'SmNewsController@index')->name('news_index');
Route::post('/news-store', 'SmNewsController@store')->name('store_news')->middleware('userRolePermission:497');
Route::post('/news-update', 'SmNewsController@update')->name('update_news')->middleware('userRolePermission:498');
Route::get('newsDetails/{id}', 'SmNewsController@newsDetails')->name('newsDetails')->middleware('userRolePermission:496');
Route::get('for-delete-news/{id}', 'SmNewsController@forDeleteNews')->name('for-delete-news')->middleware('userRolePermission:499');
Route::get('delete-news/{id}', 'SmNewsController@delete')->name('delete-news');
Route::get('edit-news/{id}', 'SmNewsController@edit')->name('edit-news')->middleware('userRolePermission:498');

Route::get('news-category', 'SmNewsController@newsCategory')->name('news-category')->middleware('userRolePermission:500');
Route::post('/news-category-store', 'SmNewsController@storeCategory')->name('store_news_category')->middleware('userRolePermission:501');
Route::post('/news-category-update', 'SmNewsController@updateCategory')->name('update_news_category')->middleware('userRolePermission:502');
Route::get('for-delete-news-category/{id}', 'SmNewsController@forDeleteNewsCategory')->name('for-delete-news-category')->middleware('userRolePermission:503');
Route::get('delete-news-category/{id}', 'SmNewsController@deleteCategory')->name('delete-news-category');
Route::get('edit-news-category/{id}', 'SmNewsController@editCategory')->name('edit-news-category')->middleware('userRolePermission:502');

Route::get('view-news-category/{id}', 'SmNewsController@viewNewsCategory')->name('view-news-category');

//For course module
Route::get('course-category', 'SmCourseController@courseCategory')->name('course-category')->middleware('userRolePermission:673');
Route::post('store-course-category', 'SmCourseController@storeCourseCategory')->name('store-course-category')->middleware('userRolePermission:674');
Route::get('edit-course-category/{id}', 'SmCourseController@editCourseCategory')->name('edit-course-category')->middleware('userRolePermission:675');
Route::post('update-course-category', 'SmCourseController@updateCourseCategory')->name('update-course-category')->middleware('userRolePermission:675');
Route::post('delete-course-category/{id}', 'SmCourseController@deleteCourseCategory')->name('delete-course-category')->middleware('userRolePermission:676');

Route::get('view-course-category/{id}', 'SmCourseController@viewCourseCategory')->name('view-course-category');

Route::get('course-list', 'SmCourseController@index')->name('course-list')->middleware('userRolePermission:509');
Route::post('/course-store', 'SmCourseController@store')->name('store_course')->middleware('userRolePermission:511');
Route::post('/course-update', 'SmCourseController@update')->name('update_course')->middleware('userRolePermission:512');
Route::get('for-delete-course/{id}', 'SmCourseController@forDeleteCourse')->name('for-delete-course')->middleware('userRolePermission:513');
Route::get('delete-course/{id}', 'SmCourseController@destroy')->name('delete-course')->middleware('userRolePermission:509');
Route::get('edit-course/{id}', 'SmCourseController@edit')->name('edit-course')->middleware('userRolePermission:512');
Route::get('course-Details-admin/{id}', 'SmCourseController@courseDetails')->name('course-Details-admin')->middleware('userRolePermission:510');

//for testimonial

Route::get('/testimonial', 'SmTestimonialController@index')->name('testimonial_index')->middleware('userRolePermission:504');
Route::post('/testimonial-store', 'SmTestimonialController@store')->name('store_testimonial')->middleware('userRolePermission:506');
Route::post('/testimonial-update', 'SmTestimonialController@update')->name('update_testimonial')->middleware('userRolePermission:507');
Route::get('testimonial-details/{id}', 'SmTestimonialController@testimonialDetails')->name('testimonial-details')->middleware('userRolePermission:505');
Route::get('for-delete-testimonial/{id}', 'SmTestimonialController@forDeleteTestimonial')->name('for-delete-testimonial')->middleware('userRolePermission:508');
Route::get('delete-testimonial/{id}', 'SmTestimonialController@delete')->name('delete-testimonial');
Route::get('edit-testimonial/{id}', 'SmTestimonialController@edit')->name('edit-testimonial')->middleware('userRolePermission:507');

// Contact us
Route::get('contact-page', 'SmFrontendController@conpactPage')->name('conpactPage')->middleware('userRolePermission:514');
Route::get('contact-page/edit', 'SmFrontendController@contactPageEdit')->name('contactPageEdit');
Route::post('contact-page/update', 'SmFrontendController@contactPageStore')->name('contactPageStore');

// contact message
Route::get('contact-message', 'SmFrontendController@contactMessage')->name('contactMessage')->middleware('userRolePermission:517');
Route::get('delete-message/{id}', 'SmFrontendController@deleteMessage')->name('delete-message')->middleware('userRolePermission:519');

// News route start
Route::get('news-heading-update', 'SmFrontendController@newsHeading')->name('news-heading-update')->middleware('userRolePermission:523');
Route::post('news-heading-update', 'SmFrontendController@newsHeadingUpdate')->name('news-heading-update')->middleware('userRolePermission:524');

// Course route start
Route::get('course-heading-update', 'SmFrontendController@courseHeading')->name('course-heading-update')->middleware('userRolePermission:525');
Route::post('course-heading-update', 'SmFrontendController@courseHeadingUpdate')->name('course-heading-update')->middleware('userRolePermission:526');

// Course Details route start
Route::get('course-details-heading', 'SmFrontendController@courseDetailsHeading')->name('course-details-heading')->middleware('userRolePermission:525');
Route::post('course-heading-details-update', 'SmFrontendController@courseDetailsHeadingUpdate')->name('course-details-heading-update')->middleware('userRolePermission:526');

Route::get('about-page', 'SmFrontendController@aboutPage')->name('about-page')->middleware('userRolePermission:520');
Route::get('about-page/edit', 'SmFrontendController@aboutPageEdit')->name('about-page/edit');
Route::post('about-page/update', 'SmFrontendController@aboutPageStore')->name('about-page/update');

Route::post('send-message', 'SmFrontendController@sendMessage');

Route::get('custom-links', 'Admin\SystemSettings\SmSystemSettingController@customLinks')->name('custom-links')->middleware('userRolePermission:527');
Route::post('custom-links-update', 'Admin\SystemSettings\SmSystemSettingController@customLinksUpdate')->name('custom-links-update')->middleware('userRolePermission:528');

// admin-home-page
Route::get('admin-home-page', 'Admin\SystemSettings\SmSystemSettingController@homePageBackend')->name('admin-home-page')->middleware('userRolePermission:493');
Route::post('admin-home-page-update', 'Admin\SystemSettings\SmSystemSettingController@homePageUpdate')->name('admin-home-page-update')->middleware('userRolePermission:494');

// social media
Route::get('social-media', 'SmFrontendController@socialMedia')->name('social-media')->middleware('userRolePermission:529');
Route::post('social-media-store', 'SmFrontendController@socialMediaStore')->name('social-media-store');
Route::get('social-media-edit/{id}', 'SmFrontendController@socialMediaEdit')->name('social-media-edit');
Route::post('social-media-update', 'SmFrontendController@socialMediaUpdate')->name('social-media-update');
Route::get('social-media-delete/{id}', 'SmFrontendController@socialMediaDelete')->name('social-media-delete');

// Header Menu Manager
Route::get('header-menu-manager', 'SmFrontendController@headerMenuManager')->name('header-menu-manager')->middleware('userRolePermission:650');
Route::post('add-element', 'SmFrontendController@addElement')->name('add-element')->middleware('userRolePermission:651');
Route::post('reordering', 'SmFrontendController@reordering')->name('reordering');
Route::post('element-update', 'SmFrontendController@elementUpdate')->name('element-update')->middleware('userRolePermission:652');
Route::post('delete-element', 'SmFrontendController@deleteElement')->name('delete-element')->middleware('userRolePermission:653');

// Pages
Route::get('create-page', 'SmFrontendController@createPage')->name('create-page')->middleware('userRolePermission:656');
Route::post('save-page-data', 'SmFrontendController@savePageData')->name('save-page-data')->middleware('userRolePermission:656');
Route::get('edit-page/{id}', 'SmFrontendController@editPage')->name('edit-page')->middleware('userRolePermission:657');
Route::post('update-page-data', 'SmFrontendController@updatePageData')->name('update-page-data')->middleware('userRolePermission:657');
Route::get('view-page/{slug}', 'SmFrontendController@viewPage')->name('view-page');
Route::get('page-list', 'SmFrontendController@pageList')->name('page-list')->middleware('userRolePermission:654');
Route::post('delete-page/{id}', 'SmFrontendController@deletePage')->name('delete-page')->middleware('userRolePermission:658');
Route::get('download-header-image/{file_name}', function ($file_name = null) {
    $file = public_path() . '/uploads/pages/' . $file_name;
    if (file_exists($file)) {
        return Response::download($file);
    }
})->name('download-header-image')->middleware('userRolePermission:659');

// admin-home-page
Route::get('admin-data-delete', 'Admin\SystemSettings\SmSystemSettingController@tableEmpty');
Route::post('database-delete', 'Admin\SystemSettings\SmSystemSettingController@databaseDelete')->name('database-delete');
Route::get('database-restore', 'Admin\SystemSettings\SmSystemSettingController@databaseRestory');
Route::post('database-restore', 'Admin\SystemSettings\SmSystemSettingController@databaseRestory');

Route::get('change-website-btn-status', 'Admin\SystemSettings\SmSystemSettingController@changeWebsiteBtnStatus');
Route::get('change-dashboard-btn-status', 'Admin\SystemSettings\SmSystemSettingController@changeDashboardBtnStatus');
Route::get('change-report-btn-status', 'Admin\SystemSettings\SmSystemSettingController@changeReportBtnStatus');

Route::get('change-style-btn-status', 'Admin\SystemSettings\SmSystemSettingController@changeStyleBtnStatus');
Route::get('change-ltl_rtl-btn-status', 'Admin\SystemSettings\SmSystemSettingController@changeLtlRtlBtnStatus');
Route::get('change-language-btn-status', 'Admin\SystemSettings\SmSystemSettingController@changeLanguageBtnStatus');
Route::post('update-website-url', 'Admin\SystemSettings\SmSystemSettingController@updateWebsiteUrl')->name('update-website-url')->middleware('userRolePermission:464');

Route::get('update-created-date', 'Admin\SystemSettings\SmSystemSettingController@updateCreatedDate');

Route::get('preloader-setting', 'Admin\SystemSettings\PreloaderSettingController@index')
    ->name('setting.preloader');

Route::post('preloader-setting', 'Admin\SystemSettings\PreloaderSettingController@store');

// manage currency

Route::get('manage-currency', 'Admin\SystemSettings\SmSystemSettingController@manageCurrency')->name('manage-currency')->middleware('userRolePermission:401');
Route::post('currency-store', 'Admin\SystemSettings\SmSystemSettingController@storeCurrency')->name('currency-store')->middleware('userRolePermission:402');
Route::post('currency-update', 'Admin\SystemSettings\SmSystemSettingController@storeCurrencyUpdate')->name('currency-update')->middleware('userRolePermission:403');
Route::get('manage-currency/edit/{id}', 'Admin\SystemSettings\SmSystemSettingController@manageCurrencyEdit')->name('currency_edit')->middleware('userRolePermission:403');
Route::get('manage-currency/delete/{id}', 'Admin\SystemSettings\SmSystemSettingController@manageCurrencyDelete')->name('currency_delete')->middleware('userRolePermission:404');
Route::get('system-destroyed-by-authorized', 'Admin\SystemSettings\SmSystemSettingController@systemDestroyedByAuthorized')->name('systemDestroyedByAuthorized');

Route::post('student-update-pic/{id}', ['as' => 'student_update_pic', 'uses' => 'SmStudentAdmissionController@studentUpdatePic']);
Route::post('student-document-delete', ['as' => 'student_document_delete', 'uses' => 'SmStudentAdmissionController@deleteStudentDocument']);
Route::post('staff-document-delete', ['as' => 'staff-document-delete', 'uses' => 'SmStaffController@deleteStaffDoc']);
Route::get('view-leave-details-apply/{id}', 'Admin\Leave\SmLeaveRequestController@viewLeaveDetails')->name('view-leave-details-apply');

Route::group(['middleware' => ['auth']], function () {
    Route::get('theme-style-active', 'Admin\SystemSettings\SmSystemSettingController@themeStyleActive');
    Route::get('theme-style-rtl', 'Admin\SystemSettings\SmSystemSettingController@themeStyleRTL');
    Route::get('/user-language-change', 'Admin\SystemSettings\SmSystemSettingController@ajaxUserLanguageChange');
    Route::get('change-academic-year', 'Admin\SystemSettings\SmSystemSettingController@sessionChange');
});

Route::get('/academic_years', 'HomeController@academicUpdate');
Route::get('/class_updates', 'HomeController@classUpdate');
Route::get('/section_updates', 'HomeController@sectionUpdate');
Route::get('/class_section_updates', 'HomeController@sectionClassUpdate');
Route::get('/new_updates', 'HomeController@classSectionAllUpdate');
Route::get('/db_update_new', 'HomeController@dbUpdate');
Route::get('/student_update', 'HomeController@studentUpdate');
Route::get('/class_update_new', 'HomeController@classUpdateNew');

Route::get('developer-tool/{purpose}', 'SmFrontendController@developerTool')->name('developerTool');

Route::group(['middleware' => ['XSS']], function () {
    Route::get('update-system', 'Admin\SystemSettings\SmSystemSettingController@UpdateSystem');
    Route::get('/verified-code', 'InstallController@verifiedCode');
    Route::post('system-verify', 'InstallController@systemVerifyPurchases')->name('systemVerifyPurchases');
    Route::get('module-verify', 'InstallController@ModuleVerify')->name('ModuleVerify');
    Route::post('module-verify-purchase', 'InstallController@ModuleverifyPurchases')->name('ModuleverifyPurchases');
    Route::get('institution-privacy-policy', 'SmFrontendController@institutionPrivacyPolicy')->name('institution-privacy-policy');
    Route::get('institution-terms-service', 'SmFrontendController@institutionTermServices')->name('institution-terms-service');

    //payment Gateway
    Route::get('payment_gateway_success_callback/{method}', 'PaymentGatewayCallbackController@successCallBack')->name('payment.success');
    Route::get('payment_gateway_cancel_callback/{method}', 'PaymentGatewayCallbackController@cancelCallback');
    Route::post('makeFeesPayment', 'GatewayPaymentController@makeFeesPayment')->name('makeFeesPayment');

    Route::get('db-upgrade', 'Admin\SystemSettings\SmSystemSettingController@DbUpgrade');
    Route::get('academicIdUpdated', 'Admin\SystemSettings\SmSystemSettingController@academicIdUpdated');



    //USER REGISTER SECTION
    Route::get('register', 'SmFrontendController@register')->name('register');
    Route::post('register', 'SmFrontendController@customer_register')->name('customer_register');


    Route::get('error-404', function () {
        return view('auth.error');
    })->name('error-404');
    Route::get('notification-api', 'Admin\SystemSettings\SmSystemSettingController@notificationApi')->name('notificationApi');



    /* ::::::::::::::::::::::::: START SEARCH ROUTES :::::::::::::::::::::::::: */

    Route::get('moduleAddOnsEnable/{name}', 'SmAddOnsController@moduleAddOnsEnable')->name('moduleAddOnsEnable');
    Route::post('/search', 'SmSearchController@search')->name('search');

    /* ::::::::::::::::::::::::: START SEARCH ROUTES :::::::::::::::::::::::::: */

    Route::group(['middleware' => ['CheckUserMiddleware']], function () {
        Route::get('recovery/passord', 'SmAuthController@recoveryPassord')->name('recoveryPassord');
        Route::post('email/verify', 'SmAuthController@emailVerify')->name('email/verify');
        Route::get('/reset/password/{email}/{code}', 'SmAuthController@resetEmailConfirtmation')->name('resetEmailConfirtmation');
        Route::post('/store/new/password', 'SmAuthController@storeNewPassword')->name('storeNewPassword');
        Route::get('login-2', 'Auth\LoginController@loginFormTwo')->name('loginFormTwo');
        Route::get('news', 'Admin\SystemSettings\SmSystemSettingController@news')->name('news')->middleware('userRolePermission:795');
    });

    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
    Route::get('ajax-get-login-access', 'SmAuthController@getLoginAccess');

    Route::get('class-routine/print/{class_id}/{section_id}', 'Admin\Academics\SmClassRoutineNewController@classRoutinePrint')->name('classRoutinePrint');

});
Route::get('paypal-return-status', 'SmCollectFeesByPaymentGateway@getPaymentStatus');
Route::get('/ajaxGetVehicle', 'Admin\StudentInfo\SmStudentAjaxController@ajaxGetVehicle');
Route::get('/ajaxRoomDetails', 'Admin\StudentInfo\SmStudentAjaxController@ajaxRoomDetails');