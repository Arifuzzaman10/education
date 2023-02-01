<?php

namespace Modules\XenditPayment\Http\Controllers;

use App\SmParent;
use App\SmStudent;
use Xendit\Xendit;
use Xendit\Invoice;
use App\SmAddIncome;
use App\SmFeesPayment;
use App\SmPaymentMethhod;
use Illuminate\Http\Request;
use App\SmPaymentGatewaySetting;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Support\Renderable;
use Modules\University\Entities\UnFeesInstallmentAssign;

class XenditPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function studentPay(Request $request)
    {
        if(moduleStatusCheck('University')){
            $request->validate([
                'amount' => "required|min:1",
                'student_id' => "required",
                'installment_id' => 'required'
                ]);

        }else{
            $request->validate([
                'amount' => "required|min:1",
                'student_id' => "required",
                'fees_type_id' => 'required'
                ]);
        }


        try{
            $email = "";
            $student = SmStudent::find($request->student_id);
            
             
            if(!($student->email)){
                 $parent = SmParent::find($student->parent_id);
             
                $email =  $parent->guardians_email;
            }else{
                $email =   $student->email;
            }
         
            $xendit_config = SmPaymentGatewaySetting::where('gateway_name','Xendit')->where('school_id',auth()->user()->school_id)->first('gateway_secret_key');
            $withServiceCharge = $request->amount + chargeAmount('Xendit', $request->amount);
            if($xendit_config){
                Xendit::setApiKey($xendit_config->gateway_secret_key);
                $params = [ 
                    'external_id' => 'fees_collection_'.$request->fees_type_id,
                    'payer_email' => $email,
                    'description' => generalSetting()->school_name.' Fees_Payment',
                    'amount' => $withServiceCharge,
                    'success_redirect_url'=>url('xenditpayment/payment_success_callback'),
                    'failure_redirect_url'=>url('xenditpayment/payment_fail_callback')
                  ];
                
                  $createInvoice = \Xendit\Invoice::create($params);
                  if($createInvoice && $createInvoice['status']  =="PENDING"){
                        $user = Auth::user();
                        $fees_payment = new SmFeesPayment();
                        $fees_payment->student_id = $request->student_id;
                        $fees_payment->amount = $request->amount / 1000;
                        $fees_payment->payment_date = date('Y-m-d');
                        $fees_payment->payment_mode = 'Xendit';
                        $fees_payment->created_by = $user->id;
                        $fees_payment->record_id = $request->record_id;
                        $fees_payment->school_id = Auth::user()->school_id;
                        if(moduleStatusCheck('University')){
                            $fees_payment->un_academic_id = getAcademicId();
                            $fees_payment->un_fees_installment_id  = $request->installment_id;
                            $fees_payment->un_semester_label_id = $request->un_semester_label_id;
                        }
                        else{
                            $fees_payment->fees_type_id = $request->fees_type_id;
                            $fees_payment->academic_id = getAcademicId();
                        }
                        $fees_payment->active_status = 0;
                        $fees_payment->save();
                         /** add payment ID to session **/
                        Session::put('xendit_payment_id', $fees_payment->id);
                        return redirect($createInvoice['invoice_url']) ;
                  }
            }
            else{
                Toastr::error('Operation Faileduu', 'Failed');
                return redirect()->back();
            }
        
        }
        catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function successCallBack()
    {
       try{
            $payment_id =  Session::get('xendit_payment_id');
            if($payment_id ){
                $success_payment = SmFeesPayment::find($payment_id);
                $success_payment->active_status = 1 ; 
                $result = $success_payment->save();

                if($result){
                    if(moduleStatusCheck('University')){
                        $installment = UnFeesInstallmentAssign::find($success_payment->un_fees_installment_id);
                        $installment->paid_amount = $installment->amount;
                        $installment->active_status = 1;
                        $installment->payment_mode = $success_payment->payment_mode;
                        $installment->payment_date = $success_payment->payment_date;
                        $installment->save();
                    }
                    
                    $payment_method=SmPaymentMethhod::where('method',$success_payment->payment_mode)->first('id');
                    $income_head=generalSetting();
                    $add_income = new SmAddIncome();
                    $add_income->name = 'Fees Collect';
                    $add_income->date = date('Y-m-d', strtotime($success_payment->created_at));
                    $add_income->amount = !empty($success_payment->amount) ? $success_payment->amount : 0;
                    $add_income->fees_collection_id = $success_payment->id;
                    $add_income->active_status = 1;
                    $add_income->income_head_id = $income_head->income_head_id ?? 1;
                    $add_income->payment_method_id = $payment_method->id ?? 1;
                    $add_income->created_by = Auth()->user()->id;
                    $add_income->school_id = Auth::user()->school_id;
                    $add_income->academic_id = getAcademicId();
                    $add_income->save();
                }
                Session::forget('xendit_payment_id');

                if(auth()->user()->role_id == 2){
                    Toastr::success('Payment success', 'Success');
                    return redirect('student-fees');

                }elseif(auth()->user()->role_id == 3){
                    Toastr::success('Payment success', 'Success');
                    return redirect('parent-fees',$success_payment->student_id);
                }
            }
            
       }
        catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back();
        }

    }

    public function failCallBack(){
        try{
            $payment_id =  Session::get('xendit_payment_id');
            if($payment_id ){
                $success_payment = SmFeesPayment::find($payment_id);
                $success_payment->delete();
                Session::forget('xendit_payment_id');
                if(auth()->user()->role_id == 2){
                    Toastr::error('Payment failed', 'Failed');
                    return redirect('student-fees');

                }elseif(auth()->user()->role_id == 3){
                    Toastr::error('Payment failed', 'Failed');
                    return redirect('parent-fees',$success_payment->student_id);
                }
            }    
       }
        catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('xenditpayment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('xenditpayment::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
