<?php

use Illuminate\Support\Facades\Route;
use Modules\Fees\Http\Controllers\AjaxController;
use Modules\Fees\Http\Controllers\FeesController;
use Modules\Fees\Http\Controllers\FeesReportController;
use Modules\Fees\Http\Controllers\StudentFeesController;

Route::group(['middleware' => ['subdomain']], function () {
    Route::prefix('fees')->middleware('auth')->group(function () {
        //Fees Group
        Route::get('fees-group', [FeesController::class, 'feesGroup'])->name('fees.fees-group')->middleware('userRolePermission:1131');
        Route::post('fees-group-store', [FeesController::class, 'feesGroupStore'])->name('fees.fees-group-store')->middleware('userRolePermission:1132');
        Route::get('fees-group-edit/{id}', [FeesController::class, 'feesGroupEdit'])->name('fees.fees-group-edit');
        Route::post('fees-group-update', [FeesController::class, 'feesGroupUpdate'])->name('fees.fees-group-update')->middleware('userRolePermission:1133');
        Route::post('fees-group-delete', [FeesController::class, 'feesGroupDelete'])->name('fees.fees-group-delete')->middleware('userRolePermission:1134');

        //Fees Type
        Route::get('fees-type', [FeesController::class, 'feesType'])->name('fees.fees-type')->middleware('userRolePermission:1135');
        Route::post('fees-type-store', [FeesController::class, 'feesTypeStore'])->name('fees.fees-type-store')->middleware('userRolePermission:1136');
        Route::get('fees-type-edit/{id}', [FeesController::class, 'feesTypeEdit'])->name('fees.fees-type-edit');
        Route::post('fees-type-update', [FeesController::class, 'feesTypeUpdate'])->name('fees.fees-type-update')->middleware('userRolePermission:1137');
        Route::post('fees-type-delete', [FeesController::class, 'feesTypeDelete'])->name('fees.fees-type-delete')->middleware('userRolePermission:1138');

        //Fees invoice
        Route::get('fees-invoice-list', [FeesController::class, 'feesInvoiceList'])->name('fees.fees-invoice-list')->middleware('userRolePermission:1139');
        Route::get('fees-invoice', [FeesController::class, 'feesInvoice'])->name('fees.fees-invoice');
        Route::post('fees-invoice-store', [FeesController::class, 'feesInvoiceStore'])->name('fees.fees-invoice-store')->middleware('userRolePermission:1140');
        Route::get('fees-invoice-edit/{id}', [FeesController::class, 'feesInvoiceEdit'])->name('fees.fees-invoice-edit');
        Route::post('fees-invoice-update', [FeesController::class, 'feesInvoiceUpdate'])->name('fees.fees-invoice-update')->middleware('userRolePermission:1145');
        Route::get('fees-invoice-view/{id}/{state}', [FeesController::class, 'feesInvoiceView'])->name('fees.fees-invoice-view');
        Route::post('fees-invoice-delete', [FeesController::class, 'feesInvoiceDelete'])->name('fees.fees-invoice-delete')->middleware('userRolePermission:1146');
        Route::post('fees-payment-store', [FeesController::class, 'feesPaymentStore'])->name('fees.fees-payment-store')->middleware('userRolePermission:1147');
        Route::get('single-payment-view/{id}', [FeesController::class, 'singlePaymentView'])->name('fees.single-payment-view');

        Route::get('add-fees-payment/{id}', [FeesController::class, 'addFeesPayment'])->name('fees.add-fees-payment')->middleware('userRolePermission:1144');
        Route::get('delete-single-fees-transcation/{id}', [FeesController::class, 'deleteSingleFeesTranscation'])->name('fees.delete-single-fees-transcation');

        //Bank Payment
        Route::get('bank-payment', [FeesController::class, 'bankPayment'])->name('fees.bank-payment')->middleware('userRolePermission:1148');
        Route::post('search-bank-payment', [FeesController::class, 'searchBankPayment'])->name('fees.search-bank-payment')->middleware('userRolePermission:1149');
        Route::post('approve-bank-payment', [FeesController::class, 'approveBankPayment'])->name('fees.approve-bank-payment')->middleware('userRolePermission:1150');
        Route::post('reject-bank-payment', [FeesController::class, 'rejectBankPayment'])->name('fees.reject-bank-payment')->middleware('userRolePermission:1151');

        //Fees invoice Settings
        Route::get('fees-invoice-settings', [FeesController::class, 'feesInvoiceSettings'])->name('fees.fees-invoice-settings')->middleware('userRolePermission:1152');
        Route::post('fees-invoice-settings-update', [FeesController::class, 'ajaxFeesInvoiceSettingsUpdate'])->name('fees.fees-invoice-settings-update')->middleware('userRolePermission:1153');

        //Fees Report
        Route::get('due-fees', [FeesReportController::class, 'dueFeesView'])->name('fees.due-fees')->middleware('userRolePermission:1155');
        Route::post('search-due-fees', [FeesReportController::class, 'dueFeesSearch'])->name('fees.search-due-fees');
        Route::get('fine-report', [FeesReportController::class, 'fineReportView'])->name('fees.fine-report')->middleware('userRolePermission:1158');
        Route::post('fine-search', [FeesReportController::class, 'fineReportSearch'])->name('fees.fine-search');
        Route::get('payment-report', [FeesReportController::class, 'paymentReportView'])->name('fees.payment-report')->middleware('userRolePermission:1159');
        Route::post('payment-search', [FeesReportController::class, 'paymentReportSearch'])->name('fees.payment-search');
        Route::get('balance-report', [FeesReportController::class, 'balanceReportView'])->name('fees.balance-report')->middleware('userRolePermission:1160');
        Route::post('balance-search', [FeesReportController::class, 'balanceReportSearch'])->name('fees.balance-search');
        Route::get('waiver-report', [FeesReportController::class, 'waiverReportView'])->name('fees.waiver-report')->middleware('userRolePermission:1161');
        Route::post('waiver-search', [FeesReportController::class, 'waiverReportSearch'])->name('fees.waiver-search');

        // Student
        Route::get('student-fees-list/{id}', [StudentFeesController::class, 'studentFeesList'])->name('fees.student-fees-list');
        Route::get('student-fees-payment/{id}', [StudentFeesController::class, 'studentAddFeesPayment'])->name('fees.student-fees-payment');
        Route::post('student-fees-payment-store', [StudentFeesController::class, 'studentFeesPaymentStore'])->name('fees.student-fees-payment-store');

        //Ajax Request
        Route::post('fees-view-payment', [AjaxController::class, 'feesViewPayment'])->name('fees.fees-view-payment')->middleware('userRolePermission:1141');
        Route::get('select-student', [AjaxController::class, 'ajaxSelectStudent'])->name('fees.select-student');
        Route::post('select-fees-type', [AjaxController::class, 'ajaxSelectFeesType'])->name('fees.select-fees-type');
        Route::get('ajax-get-all-section', [AjaxController::class, 'ajaxGetAllSection'])->name('fees.ajax-get-all-section');
        Route::get('ajax-section-all-student', [AjaxController::class, 'ajaxSectionAllStudent'])->name('fees.ajax-section-all-student');
        Route::get('ajax-get-all-student', [AjaxController::class, 'ajaxGetAllStudent'])->name('fees.ajax-get-all-student');
        Route::post('change-method', [AjaxController::class, 'changeMethod'])->name('fees.change-method');
        Route::get('gateway-service-charge', [AjaxController::class, 'serviceCharge'])->name('gateway-service-charge');
    });
});