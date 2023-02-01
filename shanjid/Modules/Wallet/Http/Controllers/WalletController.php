<?php

namespace Modules\Wallet\Http\Controllers;

use App\User;
use App\SmBankAccount;
use App\SmNotification;
use App\SmPaymentMethhod;
use App\SmGeneralSettings;
use Illuminate\Http\Request;
use App\SmPaymentGatewaySetting;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Modules\Wallet\Entities\WalletTransaction;

class WalletController extends Controller
{
    public function addWalletAmount(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'payment_method' => 'required',
            'bank' => 'required_if:payment_method,Bank',
            'file' => 'mimes:jpg,jpeg,png,pdf',
        ]);
      

            $url = '';
            if ($request->payment_method == "Cheque" || $request->payment_method == "Bank") {
                $uploadFile = "";
                if ($request->file('file') != "") {
                    $maxFileSize = SmGeneralSettings::first('file_size')->file_size;
                    $file = $request->file('file');
                    $fileSize = filesize($file);
                    $fileSizeKb = ($fileSize / 1000000);
                    if ($fileSizeKb >= $maxFileSize) {
                        Toastr::error('Max upload file size ' . $maxFileSize . ' Mb is set in system', 'Failed');
                        return redirect()->back();
                    }
                    $file = $request->file('file');
                    $uploadFile = 'doc1-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $file->move('public/uploads/student/document/', $uploadFile);
                    $uploadFile = 'public/uploads/student/document/' . $uploadFile;
                }

                $addPayment = new WalletTransaction();
                $addPayment->amount = $request->amount;
                $addPayment->payment_method = $request->payment_method;
                $addPayment->bank_id = $request->bank;
                $addPayment->note = $request->note;
                $addPayment->file = $uploadFile;
                $addPayment->type = 'diposit';
                $addPayment->user_id = Auth::user()->id;
                $addPayment->school_id = Auth::user()->school_id;
                $addPayment->academic_id = getAcademicId();
                $addPayment->save();
            } else {
                $data = [];
                $data['payment_method'] = $request->payment_method;
                $data['amount'] = $request->amount;
                $data['service_charge'] = chargeAmount($request->payment_method, $request->amount);
                $data['user_id'] = Auth::user()->id;
                $data['type'] = "Wallet";
                $data['wallet_type'] = 'diposit';
                $data['description'] = "Wallet Amount Request";
                $data['stripeToken'] = $request->stripeToken;

                $classMap = config('paymentGateway.' . $data['payment_method']);
                $make_payment = new $classMap();
              
                $url = $make_payment->handle($data);
               
                if (!$url) {
                    $url = 'wallet/my-wallet';
                }
                if ($request->wantsJson()) {
                    return response()->json(['goto' => $url]);
                } else {
                    return redirect($url);
                }
                
            }

            // Notification Start
            $this->sendNotification(1, 1, "Wallet Request");

            $accounts_ids = User::where('role_id', 6)->get();
            foreach ($accounts_ids as $accounts_id) {
                $this->sendNotification($accounts_id->id, $accounts_id->role_id, "Wallet Request");
            }
            return response()->json(['success']);
            // Notification End

    }

    public function walletPendingDiposit()
    {
        $walletAmounts = $this->walletAmounts('diposit', 'pending');
        return view('wallet::walletPending', compact('walletAmounts'));
    }

    public function walletApprovePayment(Request $request)
    {
        try {
            $user = User::find($request->user_id);

            $currentamount = $user->wallet_balance;
            $addedAmount = $currentamount + $request->amount;
            $user->wallet_balance = $addedAmount;
            $user->update();

            $status = WalletTransaction::find($request->id);
            $status->status = 'approve';
            $status->updated_at = date('Y-m-d');
            $status->update();

            $compact['user_email'] = $user->email;
            $compact['method'] = $status->payment_method;
            $compact['create_date'] = $status->created_by;
            $compact['current_balance'] = $user->wallet_balance;
            $compact['add_balance'] = $request->amount;

            @send_mail($user->email, $user->full_name, "wallet_approve", $compact);

            $this->sendNotification($user->id, $user->role_id, "Wallet Approve");

            Toastr::success('Approve Successful', 'Success');
            return redirect()->route('wallet.pending-diposit');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function walletRejectPayment(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $status = WalletTransaction::find($request->id);
            $status->status = 'reject';
            $status->reject_note = $request->reject_note;
            $status->updated_at = date('Y-m-d');
            $status->update();

            $compact['user_email'] = $user->email;
            $compact['method'] = $status->payment_method;
            $compact['create_date'] = $status->created_at;
            $compact['current_balance'] = $user->wallet_balance;
            $compact['add_balance'] = $request->amount;
            $compact['reject_reason'] = $request->reject_note;

            @send_mail($user->email, $user->full_name, "wallet_reject", $compact);

            $this->sendNotification($user->id, $user->role_id, "Wallet Approve");

            Toastr::success('Reject Successful', 'Success');
            return redirect()->route('wallet.pending-diposit');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function walletApproveDiposit()
    {
        $walletAmounts = $this->walletAmounts('diposit', 'approve');
        return view('wallet::walletApprove', compact('walletAmounts'));
    }

    public function walletRejectDiposit()
    {
        $walletAmounts = $this->walletAmounts('diposit', 'reject');
        return view('wallet::walletReject', compact('walletAmounts'));
    }

    public function walletTransaction()
    {
        $walletAmounts = WalletTransaction::where('school_id', Auth::user()->school_id)
            ->get();
        return view('wallet::walletTransaction', compact('walletAmounts'));
    }

    public function walletRefundRequest()
    {
        $walletRefunds = WalletTransaction::where('type', 'refund')
            ->where('school_id', Auth::user()->school_id)
            ->get();

        return view('wallet::walletRefundRequest', compact('walletRefunds'));
    }

    public function walletRefundRequestStore(Request $request)
    {

        $request->validate([
            'refund_note' => 'required',
            'refund_file' => 'mimes:jpg,jpeg,png,pdf',
        ]);

        $existRefund = WalletTransaction::where('type', 'refund')
            ->where('user_id', $request->user_id)
            ->where('status', 'pending')
            ->where('school_id', Auth::user()->school_id)
            ->first();

        if ($existRefund) {
            throw ValidationException::withMessages(['exist' => 'You Already Request For Refund']);
        }

        try {
            $uploadFile = "";
            if ($request->file('refund_file') != "") {
                $maxFileSize = SmGeneralSettings::first('file_size')->file_size;
                $file = $request->file('refund_file');
                $fileSize = filesize($file);
                $fileSizeKb = ($fileSize / 1000000);
                if ($fileSizeKb >= $maxFileSize) {
                    Toastr::error('Max upload file size ' . $maxFileSize . ' Mb is set in system', 'Failed');
                    return redirect()->back();
                }
                $file = $request->file('refund_file');
                $uploadFile = 'doc1-' . md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('public/uploads/student/document/', $uploadFile);
                $uploadFile = 'public/uploads/student/document/' . $uploadFile;
            }

            $WalletRefund = new WalletTransaction();
            $WalletRefund->user_id = $request->user_id;
            $WalletRefund->amount = $request->refund_amount;
            $WalletRefund->type = 'refund';
            $WalletRefund->payment_method = 'Wallet';
            $WalletRefund->note = $request->refund_note;
            $WalletRefund->file = $uploadFile;
            $WalletRefund->school_id = Auth::user()->school_id;
            $WalletRefund->save();

            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function walletApproveRefund(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $user->wallet_balance = $user->wallet_balance - $request->amount;
            $user->update();

            $status = WalletTransaction::find($request->id);
            $status->status = 'approve';
            $status->updated_at = date('Y-m-d');
            $status->update();

            $compact['user_email'] = $user->email;
            $compact['create_date'] = $status->created_at;
            $compact['current_balance'] = $user->wallet_balance;
            $compact['refund_amount'] = $request->amount;

            @send_mail($user->email, $user->full_name, "wallet_refund", $compact);

            $this->sendNotification($user->id, $user->role_id, "Wallet Approve");

            Toastr::success('Approve Successful', 'Success');
            return redirect()->route('wallet.wallet-refund-request');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function walletRejectRefund(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $status = WalletTransaction::find($request->id);
            $status->status = 'reject';
            $status->note = $request->reject_note;
            $status->updated_at = date('Y-m-d');
            $status->update();

            $compact['user_email'] = $user->full_name;
            $compact['method'] = $status->payment_method;
            $compact['create_date'] = $status->created_by;
            $compact['current_balance'] = $user->wallet_balance;
            $compact['add_balance'] = $request->amount;
            $compact['reject_reason'] = $request->reject_note;

            @send_mail($user->email, $user->full_name, "wallet_reject", $compact);

            $this->sendNotification($user->id, $user->role_id, "Wallet Reject");

            Toastr::success('Reject Successful', 'Success');
            return redirect()->route('wallet.wallet-refund-request');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function walletReport()
    {
        return view('wallet::walletReport');
    }

    public function walletReportSearch(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('wallet.wallet-report')->withErrors($validator)->withInput();
        }

        try {
            $rangeArr = $request->date_range ? explode('-', $request->date_range) : [date('Y/m/d'), date('Y/m/d')];


            $date_from = \Carbon\Carbon::parse($rangeArr[0])->format('Y-m-d');
            $date_to = \Carbon\Carbon::parse($rangeArr[1])->format('Y-m-d');


            $walletReports = WalletTransaction::whereDate('created_at', '>=', $date_from)
                ->whereDate('created_at', '<=', $date_to)
                ->where('school_id', Auth::user()->school_id);

            $walletReports = $walletReports->when($request->type, function ($q) use ($request) {
                return $q->where('type', $request->type);
            })->when($request->status, function ($q) use ($request) {
                return $q->where('status', $request->status);
            })->get();
            return view('wallet::walletReport', compact('walletReports'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
        return view('wallet::walletReport');
    }

    public function myWallet()
    {
        try {
            $paymentMethods = SmPaymentMethhod::whereNotIn('method', ["Cash", "Wallet"])
                ->where('school_id', Auth::user()->school_id)
                ->get();
            
            $bankAccounts = SmBankAccount::where('active_status', 1)
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $walletAmounts = WalletTransaction::where('user_id', Auth::user()->id)
                ->where('school_id', Auth::user()->school_id)
                ->get();

            $stripe_info = SmPaymentGatewaySetting::where('gateway_name', 'stripe')
                ->where('school_id', Auth::user()->school_id)
                ->first();
            $razorpay_info = null;
            if (moduleStatusCheck('RazorPay')) {
                $razorpay_info = SmPaymentGatewaySetting::where('gateway_name', 'RazorPay')
                    ->where('school_id', Auth::user()->school_id)
                    ->first();
            }

            return view('wallet::myWallet', compact('paymentMethods', 'bankAccounts', 'walletAmounts', 'stripe_info', 'razorpay_info'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }


    // Private Function

    private function walletAmounts($type, $status)
    {
        $walletAmounts = WalletTransaction::where('type', $type)
            ->where('status', $status)
            ->where('school_id', Auth::user()->school_id)
            ->get();
        return $walletAmounts;
    }

    private function sendNotification($user_id, $role_id, $message)
    {
        $notification = new SmNotification;
        $notification->user_id = $user_id;
        $notification->role_id = $role_id;
        $notification->date = date('Y-m-d');
        $notification->message = $message;
        $notification->school_id = Auth::user()->school_id;
        $notification->academic_id = getAcademicId();
        $notification->save();
    }
}
