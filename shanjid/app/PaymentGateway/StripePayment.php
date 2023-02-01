<?php 
namespace App\PaymentGateway;

use App\User;
use Stripe\Charge;
use Stripe\Stripe;
use App\SmPaymentGatewaySetting;
use Illuminate\Support\Facades\Auth;
use Modules\Wallet\Entities\WalletTransaction;
use Modules\Fees\Http\Controllers\FeesExtendedController;

class StripePayment{

    public function handle($data)
    {
      
        $payment_setting = SmPaymentGatewaySetting::where('gateway_name', 'Stripe')->where('school_id', Auth::user()->school_id)->first();

        Stripe::setApiKey($payment_setting->gateway_secret_key);

        $amount = $data['amount'];
        if(array_key_exists('service_charge', $data)) {
            $amount = $data['amount'] + $data['service_charge'];
        }

        Charge::create([
            "amount" => $amount * 100,
            "currency" => "usd",
            "source" => $data['stripeToken'],
            "description" => $data['description']
        ]);

        if($data['type'] == "Wallet"){
            $addPayment = new WalletTransaction();
            $addPayment->amount= $data['amount'];
            $addPayment->payment_method= $data['payment_method'];
            $addPayment->user_id= $data['user_id'];
            $addPayment->type= $data['wallet_type'];
            $addPayment->school_id= Auth::user()->school_id;
            $addPayment->academic_id= getAcademicId();
            $result = $addPayment->save();

            if($result){
                $user = User::find($addPayment->user_id);
                $currentBalance = $user->wallet_balance;
                $user->wallet_balance = $currentBalance + $data['amount'];
                $user->update();
                $gs = generalSetting();
                $compact['full_name'] =  $user->full_name;
                $compact['method'] =  $addPayment->payment_method;
                $compact['create_date'] =  date('Y-m-d');
                $compact['school_name'] =  $gs->school_name;
                $compact['current_balance'] =  $user->wallet_balance;
                $compact['add_balance'] =  $data['amount'];

                @send_mail($user->email, $user->full_name, "wallet_approve", $compact);
            }
         }elseif($data['type'] == "Fees"){
            $extendedController = new FeesExtendedController();
            $extendedController->addFeesAmount($data['transcationId'], null);
        }
        
    }

}
