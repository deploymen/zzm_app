<?php namespace App\Http\Controllers;

use DB;
use Models;
use Exception;
use Libraries;
use Models\Plugins\SportsBet as SportsBet;
use TesseractOCR;
use Config;

use App\Models\GameProfile;
use App\Models\GameClass;
use App\Models\User;
use App\Models\UserExternalId;
use App\Models\SubscriptionPackage;
use App\Models\UserSubsTransaction;
use App\Libraries\LogHelper;
use App\Libraries\ResponseHelper;
use Braintree_ClientToken;
use Braintree_Configuration;
use Braintree_Transaction;
use Braintree_Subscription;
use Braintree_Customer;
use Braintree_PaymentMethod;
use \Illuminate\Http\Request;
use App\Models\LogBraintreeTransaction;

class BraintreeController extends Controller {

    public function __construct()
    {
        Braintree_Configuration::environment(Config::get('app.braintree_sandbox'));
        Braintree_Configuration::merchantId(Config::get('app.braintree_merchant_id'));
        Braintree_Configuration::publicKey(Config::get('app.braintree_public_key'));
        Braintree_Configuration::privateKey(Config::get('app.braintree_private_key'));
    }

    public function generateToken(){

		$clientToken = Braintree_ClientToken::generate();
		return ResponseHelper::OutputJSON('success', '' , ['token' => $clientToken]);
	}

	public function getCustomer(Request $request){

		$userExternalId = UserExternalId::find($request->user_id);

        if(!$userExternalId->braintree_id){
            return ResponseHelper::OutputJSON('success','', ['customer' => [] ]);
        }

		//get BT customer ID and token(credit card)
		$customer = Braintree_Customer::find($userExternalId->braintree_id);

		if(!$customer){
			return ResponseHelper::OutputJSON('fail', 'customer not found');
		}

		$output = [];
		foreach($customer->creditCards as $card){
			array_push($output, [
				'expirationMonth' => $card->expirationMonth,
				'expirationYear' => $card->expirationYear,
				'last4' => $card->last4,
				'cardType' => $card->cardType,
				'cardholderName' => $card->cardholderName,
				'imageUrl' => $card->imageUrl,
				'token' => $card->token
				]);
		}

		return ResponseHelper::OutputJSON('success' , '' , ['customer' => $output]);
	}

	public function braintreeSubscribe(Request $request){

		//validation start
		if(!$request->user_id || !$request->target_id || !$request->role || !$request->plan_id){
			return ResponseHelper::OutputJSON('fail' , 'missing parameter');
		}

		$paymentMethodToken = $request->payment_method_token;

		$user = User::find($request->user_id);
		switch($request->role){
			case 'parent' : $target = GameProfile::find($request->target_id); break;
			case 'teacher' : $target = GameClass::find($request->target_id); break;

  			default: return ResponseHelper::OutputJSON('fail' , 'invalid role'); break;
		}

		switch($request->plan_id){
			case 'class-yearly-199' : $packageId = 'class-yearly-199'; break;
			case 'class-yearly-99' : $packageId = 'class-yearly-99'; break;
			case 'profile-yearly-4_99' : $packageId = 'profile-yearly-4.99'; break;
			case 'profile-yearly-9_99' : $packageId = 'profile-yearly-9.99'; break;
			default : return ResponseHelper::OutputJSON('fail' , 'invalid plan id'); break;
		}

		$subPackage = SubscriptionPackage::find($packageId);

		if(!$user || !$target || !$subPackage || !$subPackage->enable){
			return ResponseHelper::OutputJSON('fail' , 'incorrect data');
		}

		$userExternalId = UserExternalId::find($request->user_id);
		if(!$userExternalId->braintree_id){
			$customer = $this->createCustomer($request);

			if(!$customer){
				return ResponseHelper::OutputJSON('fail' , 'create customer fail');
			}
			$paymentMethodToken = $customer[0]->creditCards[0]->token;
		}

		if(!$paymentMethodToken){
			$newPaymentMethod = Braintree_PaymentMethod::create([
			    'customerId' => $userExternalId->braintree_id,
			    'paymentMethodNonce' => $request->nonce
			]);

			$paymentMethodToken = $newPaymentMethod->paymentMethod->token;
		}

		//validation end

		$result = Braintree_Subscription::create([
			'paymentMethodToken' => $paymentMethodToken,
			'planId' => $request->plan_id
			// 'planId' => 'profile-yearly-499'
		]);

		if($result->success){

			$expiredAt = date("Y-m-d H:i:s", strtotime('+1 year'));

			$target->expired_at = $expiredAt;
			$target->save();

			UserSubsTransaction::create([
				'user_id' => $request->user_id,
				'package_id' => $packageId,
				'target_id' => $request->target_id,
				'expired_at' => $expiredAt,
				]);

			LogBraintreeTransaction::create([
				'user_id' => $request->user_id,
				'role' => $request->role,
				'target_id' => $request->target_id,
				'package_id' => $packageId,
				'transaction_id' => $result->subscription->transactions[0]->id,
				'status' => $result->subscription->transactions[0]->status,
				'type' => $result->subscription->transactions[0]->type,
				'currency_iso_code' => $result->subscription->transactions[0]->currencyIsoCode,
				'amount' => $result->subscription->transactions[0]->amount,
				'merchant_account_id' => $result->subscription->transactions[0]->merchantAccountId,
				'sub_merchant_account_id' => $result->subscription->transactions[0]->subMerchantAccountId,
				'master_merchant_account_id' => $result->subscription->transactions[0]->masterMerchantAccountId,
				'order_id' => $result->subscription->transactions[0]->orderId,

				'customer_id'=>$result->subscription->transactions[0]->customer['id'],
				'first_name' =>$result->subscription->transactions[0]->customer['firstName'],
				]);
		}else{
			return ResponseHelper::OutputJSON('fail' , 'subscribe fail');
		}

		return ResponseHelper::OutputJSON('success');
	}

	function createCustomer($request){

		$user = User::find($request->user_id);

		if(!$request->name || !$request->nonce){
			return false;
		}

		$result = Braintree_Customer::create([
		    'firstName' => $request->name,
		    'paymentMethodNonce' => $request->nonce
		]);

		if(!$result->success){
			return false;
		}

		$userExternalId = UserExternalId::find($request->user_id)->update(['braintree_id' => $result->customer->id]);
		return [$result->customer];
	}

	public function deletedPaymentMethod(Request $request){
		$result = Braintree_PaymentMethod::delete($request->payment_method_token);

		if(!$result->success){
			return ResponseHelper::OutputJSON('fail');

		}
		return ResponseHelper::OutputJSON('success');
	}

}





