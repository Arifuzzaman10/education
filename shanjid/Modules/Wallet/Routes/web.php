<?php

use Illuminate\Support\Facades\Route;
use Modules\Wallet\Http\Controllers\WalletController;


Route::prefix('wallet')->middleware(['auth', 'subdomain'])->group(function() {
    Route::post('add-wallet-amount', [WalletController::class, 'addWalletAmount'])->name('wallet.add-wallet-amount');
    Route::get('pending-diposit', [WalletController::class, 'walletPendingDiposit'])->name('wallet.pending-diposit')->middleware('userRolePermission:1110');
    Route::get('approve-diposit', [WalletController::class, 'walletApproveDiposit'])->name('wallet.approve-diposit')->middleware('userRolePermission:1114');
    Route::get('reject-diposit', [WalletController::class, 'walletRejectDiposit'])->name('wallet.reject-diposit')->middleware('userRolePermission:1116');
    Route::post('approve-payment', [WalletController::class, 'walletApprovePayment'])->name('wallet.approve-payment')->middleware('userRolePermission:1111');
    Route::post('reject-payment', [WalletController::class, 'walletRejectPayment'])->name('wallet.reject-payment')->middleware('userRolePermission:1112');
    Route::get('wallet-transaction', [WalletController::class, 'walletTransaction'])->name('wallet.wallet-transaction')->middleware('userRolePermission:1118');

    Route::get('wallet-refund-request', [WalletController::class, 'walletRefundRequest'])->name('wallet.wallet-refund-request')->middleware('userRolePermission:1119');

    Route::post('wallet-refund-request-store', [WalletController::class, 'walletRefundRequestStore'])->name('wallet.wallet-refund-request-store');
    Route::post('approve-refund', [WalletController::class, 'walletApproveRefund'])->name('wallet.approve-refund');
    Route::post('reject-refund', [WalletController::class, 'walletRejectRefund'])->name('wallet.reject-refund');
    Route::get('wallet-report', [WalletController::class, 'walletReport'])->name('wallet.wallet-report')->middleware('userRolePermission:1123');
    Route::post('wallet-report-search', [WalletController::class, 'walletReportSearch'])->name('wallet.wallet-report-search');

    Route::get('my-wallet', [WalletController::class, 'myWallet'])->name('wallet.my-wallet');
});
