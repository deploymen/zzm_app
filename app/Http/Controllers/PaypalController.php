<?php namespace App\Http\Controllers;

use DB;
use Models;
use Libraries;
use Models\Plugins\SportsBet as SportsBet;
use TesseractOCR;
use Config;
use App\Models\LogPaypal;
use App\Models\LogPaypalTransaction;
use App\Models\GameProfile;
use App\Models\GameClass;

class PaypalController extends Controller {

	public function InstantPaymentNotification(){

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
				$this->log("HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" ,  "HTTP response of validation request: $res");
			}
			curl_close($ch);
		}

		$tokens = explode("\r\n\r\n", trim($res));
		$res = trim(end($tokens));
		if (strcmp ($res, "VERIFIED") == 0) {
			$custom = explode (',', $_POST['custom']);

			$logPaypalTransaction = new LogPaypalTransaction;
			$logPaypalTransaction->ipn_track_id = $_POST['ipn_track_id'];
			$logPaypalTransaction->first_name = $_POST['first_name'];
			$logPaypalTransaction->last_name = $_POST['last_name'];
			$logPaypalTransaction->environment = $custom[0];
			$logPaypalTransaction->role = $custom[1];
			$logPaypalTransaction->user_id = $custom[2];
			$logPaypalTransaction->target_id = $custom[3];
			$logPaypalTransaction->payer_id = $_POST['payer_id'];
			$logPaypalTransaction->payer_email = $_POST['payer_email'];
			// $logPaypalTransaction->payer_status = $_POST['payer_status'];
			$logPaypalTransaction->item_name = $_POST['item_name'];
			// $logPaypalTransaction->quantity = $_POST['quantity'];
			$logPaypalTransaction->payment_gross = $_POST['payment_gross'];
			// $logPaypalTransaction->discount = $_POST['discount'];
			$logPaypalTransaction->payment_fee = $_POST['payment_fee'];
			$logPaypalTransaction->payment_type = $_POST['payment_type'];
			$logPaypalTransaction->payment_status = $_POST['payment_status'];
			$logPaypalTransaction->payment_date = $_POST['payment_date'];
			$logPaypalTransaction->mc_currency = $_POST['mc_currency'];
			$logPaypalTransaction->business = $_POST['business'];
			$logPaypalTransaction->receiver_id = $_POST['receiver_id'];
			$logPaypalTransaction->receiver_email = $_POST['receiver_email'];
			$logPaypalTransaction->verify_sign = $_POST['verify_sign'];
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
			
			if($debug == true) {
				$this->log("Verified IPN: $req ", '');
			}

		} else if (strcmp ($res, "INVALID") == 0) {

			if($debug == true) {
				$this->log("Invalid IPN: $req" , '');
			}
		}
	}

	private function log($col1, $col2){
		$errorLog = new LogPaypal;
		$errorLog->col1 = $col1;
		$errorLog->col2 = $col2;
		$errorLog->save();
	}

}





