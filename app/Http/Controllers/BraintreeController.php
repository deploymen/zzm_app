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
use App\Models\UserSubsTransaction;
use App\Models\User;
use App\Models\SubscriptionPackage;
use App\Libraries\LogHelper;
use App\Libraries\ResponseHelper;
use Braintree_ClientToken;
use Braintree_Configuration;
use Braintree_Transaction;
use \Illuminate\Http\Request;
use App\Models\LogBraintreeTransaction;

class BraintreeController extends Controller {

	public function generateToken(){

		Braintree_Configuration::environment('sandbox');
		Braintree_Configuration::merchantId('sn37rg5tcpydtbt3');
		Braintree_Configuration::publicKey('3xdbz3s8mbrqnjpt');
		Braintree_Configuration::privateKey('2a10e16734ee11bee5c7b0aab86be986');
		$clientToken = Braintree_ClientToken::generate();

		return ResponseHelper::OutputJSON('success', '' , ['token' => $clientToken]);
	}

	public function braintreeValidation(Request $request){

		Braintree_Configuration::environment('sandbox');
		Braintree_Configuration::merchantId('sn37rg5tcpydtbt3');
		Braintree_Configuration::publicKey('3xdbz3s8mbrqnjpt');
		Braintree_Configuration::privateKey('2a10e16734ee11bee5c7b0aab86be986');

		if(!$request->nonce || !$request->user_id || !$request->target_id || !$request->role || !$request->package_id || !$request->amount){
			return ResponseHelper::OutputJSON('fail' , 'missing parameter');
		}

		$user = User::find($request->user_id);
		switch($request->role){
			case 'parent' : $target = GameProfile::find($request->target_id); break;
			case 'teacher' : $target = GameClass::find($request->class_id); break;

            default: return ResponseHelper::OutputJSON('fail' , 'invalid role'); break;
		}

		$subPackage = SubscriptionPackage::find($request->package_id);

		if(!$user || !$target || !$subPackage || !$subPackage->enable){
			return ResponseHelper::OutputJSON('fail' , 'incorrect data');
		} 

		$result = Braintree_Transaction::sale([
		  'amount' => $request->amount,
		  'paymentMethodNonce' => $request->nonce,
		  'options' => [
		    'submitForSettlement' => True
		  ]
		]);

		if($result->success){
			$expiredAt = date("Y-m-d H:i:s", strtotime('+1 year'));

			$target->expired_at = $expiredAt;
			$target->save();

			UserSubsTransaction::create([
				'user_id' => $request->user_id,
				'package_id' => $request->package_id,
				'target_id' => $request->target_id,
				'expired_at' => $expiredAt,
				]);
			
			LogBraintreeTransaction::create([
				'user_id' => $request->user_id,
				'role' => $request->role,
				'target_id' => $request->target_id,
				'package_id' => $request->package_id,
				'transaction_id' => $result->transaction->id,
				'status' => $result->transaction->status,
				'type' => $result->transaction->type,
				'currency_iso_code' => $result->transaction->currencyIsoCode,
				'amount' => $result->transaction->amount,
				'merchant_account_id' => $result->transaction->merchantAccountId,
				'sub_merchant_account_id' => $result->transaction->subMerchantAccountId,
				'master_merchant_account_id' => $result->transaction->masterMerchantAccountId,
				'order_id' => $result->transaction->orderId,

				'customer_id'=>$result->transaction->customer['id'],
				'first_name' =>$result->transaction->customer['firstName'],
				'last_name' =>$result->transaction->customer['lastName'],
				'company' =>$result->transaction->customer['company'],
				'email'=>$result->transaction->customer['email'],
				'website'=>$result->transaction->customer['website'],
				'phone'=>$result->transaction->customer['phone'],
				'fax'=>$result->transaction->customer['fax']
				]);

			return ResponseHelper::OutputJSON('success');

		}else{
			
			return ResponseHelper::OutputJSON('fail');

		}
	
	}
}





