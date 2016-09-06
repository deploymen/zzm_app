<?php namespace App\Http\Controllers;

use DB;
use Models;
use Exception;
use Libraries;
use Models\Plugins\SportsBet as SportsBet;
use TesseractOCR;
use Config;
use App\Models\LogPaypal;
use App\Models\LogPaypalTransaction;
use App\Models\LogPaypalSubscriptTransaction;
use App\Models\GameProfile;
use App\Models\GameClass;
use App\Libraries\LogHelper;
use App\Libraries\ResponseHelper;
use Request;


class PaypalController extends Controller {

	public function InstantPaymentNotification(Request $request){
		try{
			$debug = 1;
			$sandbox = 0;

			$raw_post_data = file_get_contents('php://input');
			$raw_post_array = explode('&', $raw_post_data);
			$myPost = array();
			foreach ($raw_post_array as $keyval) {
				$keyval = explode ('=', $keyval);
				if (count($keyval) == 2)
					$myPost[$keyval[0]] = urldecode($keyval[1]);//original version
					// $myPost[$keyval[0]] = rawurldecode($keyval[1]); //revised version @https://github.com/paypal/ipn-code-samples/issues/51
			}

			$req = 'cmd=_notify-validate';
			if(function_exists('get_magic_quotes_gpc')) {
				$get_magic_quotes_exists = true;
			}

			foreach ($myPost as $key => $value) {
				if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
					$value = urlencode(stripslashes($value));
				} else {
					$value = urlencode($value);
				}
				$req .= "&$key=$value";
			}

			if($sandbox == true) {
				$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
			} else {
				$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
			}
			$ch = curl_init($paypal_url);
			if ($ch == FALSE) {
				return FALSE;
			}

			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			if($debug == true) {
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
			}
			
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
			curl_setopt($ch, CURLOPT_ENCODING ,"");

			$res = curl_exec($ch);
			if (curl_errno($ch) != 0) // cURL error
			{
				if($debug == true) {	
					$this->log("Can't connect to PayPal to validate IPN message:" . curl_error($ch) , '');
				}
				curl_close($ch);
				exit;
			} else {	
				if($debug == true) {
					$this->log("HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" ,  "HTTP response of validation request: $res" , $_POST['ipn_track_id'] ,  $_POST['txn_type'] );
				}
				curl_close($ch);
			}

			$tokens = explode("\r\n\r\n", trim($res));
			$res = trim(end($tokens));
			if (strcmp ($res, "VERIFIED") == 0) {
				$custom = explode (',', $_POST['custom']);
				$txnType = Request::input('txn_type');
				
				// if(!$custom[2] || $custom[3]){
				// 	return false;
				// }

				$logPaypalTransaction = new LogPaypalTransaction;
				$logPaypalTransaction->ipn_track_id = Request::input('ipn_track_id');
				$logPaypalTransaction->first_name = Request::input('first_name');
				$logPaypalTransaction->last_name = Request::input('last_name');
				$logPaypalTransaction->residence_country = Request::input('residence_country');
				$logPaypalTransaction->environment = $custom[0];
				$logPaypalTransaction->role = $custom[1];
				$logPaypalTransaction->user_id = $custom[2];
				$logPaypalTransaction->target_id = $custom[3];
				// $logPaypalTransaction->package = $custom[4];
				$logPaypalTransaction->subscr_id = Request::input('subscr_id');
				$logPaypalTransaction->payer_id = Request::input('payer_id');
				$logPaypalTransaction->payer_email = Request::input('payer_email');
				$logPaypalTransaction->payer_status = Request::input('payer_status');
				$logPaypalTransaction->item_name = Request::input('item_name');
				$logPaypalTransaction->payment_status = Request::input('payment_status');
				$logPaypalTransaction->mc_currency = Request::input('mc_currency');
				$logPaypalTransaction->business = Request::input('business');
				$logPaypalTransaction->receiver_email = Request::input('receiver_email');
				$logPaypalTransaction->verify_sign = Request::input('verify_sign');
				$logPaypalTransaction->charset = Request::input('charset');
				$logPaypalTransaction->notify_version = Request::input('notify_version');

				//subscr_payment
				$logPaypalTransaction->txn_id = Request::input('txn_id' , '');
				$logPaypalTransaction->mc_fee = Request::input('mc_fee' , '');
				$logPaypalTransaction->receiver_id = Request::input('receiver_id' , '');
				$logPaypalTransaction->transaction_subject = Request::input('transaction_subject' , '');
				$logPaypalTransaction->protection_eligibility = Request::input('protection_eligibility', '');
				$logPaypalTransaction->payment_fee = Request::input('payment_fee' , '');
				$logPaypalTransaction->payment_type = Request::input('payment_type' , '');

				//subscr_signup
				$logPaypalTransaction->reattempt = Request::input('reattempt' , '');
				$logPaypalTransaction->recurring = Request::input('recurring' , '');
				$logPaypalTransaction->period = Request::input('period3' , '');

				if($txnType == "subscr_signup"){
					$logPaypalTransaction->payment_gross = Request::input('amount3');
					$logPaypalTransaction->payment_date = Request::input('subscr_date');
					$logPaypalTransaction->mc_gross = Request::input('mc_amount3');

				}elseif ($txnType == "subscr_payment") {
					$logPaypalTransaction->payment_gross = Request::input('payment_gross');
					$logPaypalTransaction->payment_date = Request::input('payment_date');
					$logPaypalTransaction->mc_gross = Request::input('mc_gross');
					
				}elseif ($txnType == 'web_accept'){
					$logPaypalTransaction->payment_gross = Request::input('payment_gross');
					$logPaypalTransaction->payment_date = Request::input('payment_date');
					$logPaypalTransaction->mc_gross = Request::input('mc_gross');
				}

				$logPaypalTransaction->save();

				if($custom[1] == 'parent'){
					$profile = GameProfile::find($custom[3]);
					$profile->expired_at = date("Y-m-d H:i:s", strtotime('+1 year'));
					$profile->save();
				}	

				if($custom[1] == 'teacher'){
					$class = GameClass::find($custom[3]);
					$class->expired_at = date("Y-m-d H:i:s", strtotime('+1 year'));
					$class->save();

				}
				
				if($debug) {
					$this->log("Verified IPN: $req ", '');
				}

			} else if (strcmp ($res, "INVALID") == 0) {

				if($debug) {
					$this->log("Invalid IPN: $req" , $raw_post_data);
				}
			}
		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'paypal ',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	private function log($col1, $col2,$col3 = '' , $col4=''){
		$errorLog = new LogPaypal;
		$errorLog->col1 = $col1;
		$errorLog->col2 = $col2;
		$errorLog->col3 = $col3;
		$errorLog->col4 = $col4;
		$errorLog->save();
	}

}





