<?php 
namespace App\PaymentGateway;

use App\User;
use Exception;
use Omnipay\Omnipay;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use App\SmPaymentGatewaySetting;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Brian2694\Toastr\Facades\Toastr;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Modules\Fees\Entities\FmFeesTransaction;
use Illuminate\Validation\ValidationException;
use Modules\Wallet\Entities\WalletTransaction;
use Modules\Fees\Http\Controllers\FeesExtendedController;

class PaypalPayment{
    private $_api_context;
    private $mode;
    private $client_id;
    private $secret;

    public function __construct()
    {
        $paypalDetails = SmPaymentGatewaySetting::where('school_id',auth()->user()->school_id)
                        ->select('gateway_username', 'gateway_password', 'gateway_signature', 'gateway_client_id', 'gateway_secret_key')
                        ->where('gateway_name', '=', 'Paypal')
                        ->first();

        if(!$paypalDetails || !$paypalDetails->gateway_secret_key){
            Toastr::warning('Paypal Credentials Can Not Be Blank', 'Warning');
            return redirect()->send()->back();
        }
        $this->_api_context = Omnipay::create('PayPal_Rest');
        $this->_api_context->setClientId($paypalDetails->gateway_client_id);
        $this->_api_context->setSecret($paypalDetails->gateway_secret_key);
        $this->_api_context->setTestMode($paypalDetails->gateway_mode && strtolower($paypalDetails->gateway_mode) == 'live');

    }

    public function handle($data)
    {

            $response = $this->_api_context->purchase(array(
                'amount' => $data['amount'],
                'currency' => generalSetting()->currency,
                'returnUrl' => URL::to('payment_gateway_success_callback','PayPal'),
                'cancelUrl' => URL::to('payment_gateway_cancel_callback','PayPal'),

            ))->send();
          
            $payment_id = gv($response->getData(), 'id');
            if(!$payment_id){
                throw ValidationException::withMessages(['amount'=> $response->getMessage()]);
            }
            if ($data['type'] == "Wallet") {

                $addPayment = new WalletTransaction();
                $addPayment->amount= $data['amount'];
                $addPayment->payment_method= $data['payment_method'];
                $addPayment->user_id= $data['user_id'];
                $addPayment->type= $data['wallet_type'];
                $addPayment->school_id= auth()->user()->school_id;
                $addPayment->academic_id= getAcademicId();
                $addPayment->save();
                Session::put('paypal_payment_id', $payment_id);
                Session::put('payment_type', $data['type']);
                Session::put('wallet_payment_id',  $addPayment->id);
            }else{
                Session::forget('amount');
                Session::put('payment_type', $data['type']);
                Session::put('invoice_id', $data['invoice_id']);
                Session::put('amount', $data['amount']);
                Session::put('payment_method',  $data['payment_method']);
                Session::put('transcation_id',  $data['transcationId']);

                Session::put('paypal_payment_id', $payment_id);
                Session::put('fees_payment_id',  $data['transcationId']);
            }
           

            if ($response->isRedirect()) {
                return $response->getRedirectUrl(); // this will automatically forward the customer
            } else {
                throw ValidationException::withMessages(['amount'=> $response->getMessage()]);
            }



    }


    public function successCallback()
    {
    $request = App::make(Request::class);

      try {
            $payment_id = Session::get('paypal_payment_id');
            Session::forget('paypal_payment_id');
            if (empty($request->input('paymentId')) || empty($request->input('PayerID'))) {
                Session::put('error','Payment failed');
                return Redirect::route('paywithpaypal');
            }
          $transaction = $this->_api_context->completePurchase(array(
              'payer_id' => request()->input('PayerID'),
              'transactionReference' => request()->input('paymentId'),
          ));
          $response = $transaction->send();


            if ($response->isSuccessful() && $response->getData()['state'] == 'approved') {
                $paypal_wallet_paymentId = Session::get('wallet_payment_id');

                if(Session::get('payment_type')== "Wallet" && !is_null($payment_id)){
                    $transaction = WalletTransaction::find($paypal_wallet_paymentId);
                    $transaction->status = "approve";
                    $transaction->updated_at = date('Y-m-d');
                    $result = $transaction->update();
                    if($result){
                        $user = User::find($transaction->user_id);
                        $currentBalance = $user->wallet_balance;
                        $user->wallet_balance = $currentBalance + $transaction->amount;
                        $user->update();
                        $gs = generalSetting();
                        $compact['full_name'] =  $user->full_name;
                        $compact['method'] =  $transaction->payment_method;
                        $compact['create_date'] =  date('Y-m-d');
                        $compact['school_name'] =  $gs->school_name;
                        $compact['current_balance'] =  $user->wallet_balance;
                        $compact['add_balance'] =  $transaction->amount;

                        @send_mail($user->email, $user->full_name, "wallet_approve", $compact);
                    }
                    return redirect()->route('wallet.my-wallet');

                }elseif(Session::get('payment_type') == "Fees" && !is_null(Session::get('fees_payment_id'))){
                    $transcation= FmFeesTransaction::find(Session::get('fees_payment_id'));

                    $extendedController = new FeesExtendedController();
                    $extendedController->addFeesAmount(Session::get('fees_payment_id'), null);
                    
                    Session::put('success', 'Payment success');
                    Toastr::success('Operation successful', 'Success');
                    return redirect()->to(url('fees/student-fees-list',$transcation->student_id));
                }else{
                    Toastr::error('Operation Failed paypal', 'Failed');
                    return redirect()->back();
                }
            }
        }catch(\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function cancelCallback(){
        Toastr::error('Operation Failed', 'Failed');
        if (Session::get('payment_type') == "Wallet") {
            return redirect()->route('wallet.my-wallet');
        } elseif (Session::get('payment_type') == "Fees") {
            $transaction = FmFeesTransaction::find(Session::get('fees_payment_id'));
            if ($transaction) {
                return redirect()->to(url('fees/student-fees-list', $transaction->student_id));
            } else {
                return redirect()->route('admin-dashboard');
            }
        } else {
            Toastr::error('Operation Failed paypal', 'Failed');
            return redirect()->route('admin-dashboard');
        }
    }
}
