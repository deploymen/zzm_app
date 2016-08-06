<?php namespace App\Http\Controllers;

use DB;
use Models;
use Libraries;
use Models\Plugins\SportsBet as SportsBet;
use TesseractOCR;
use Config;
use App\Models\Paypal;

class PaypalController extends Controller {

	public function InstantPaymentNotification(){

		$debug = Config::get('app.debug');
		$sandbox = 1;

		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
				$myPost[$keyval[0]] = urldecode($keyval[1]);
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

		$res = curl_exec($ch);

		if (curl_errno($ch) != 0) // cURL error
		{
			if($debug == true) {	
				$errorLog = new Paypal;
				$errorLog->email = 'developer@zzm.com';
				$errorLog->COL_1 = "Can't connect to PayPal to validate IPN message:"  . curl_error($ch) . PHP_EOL;
				$errorLog->save();

				

			}
			curl_close($ch);
			exit;
		} else {	
			if($debug == true) {
				$errorLog = new Paypal;
				$errorLog->email = 'developer@zzm.com';
				$errorLog->COL_1 = "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL;
				$errorLog->COL_2 = "HTTP response of validation request: $res" . PHP_EOL;
				$errorLog->save();

			}
			curl_close($ch);
		}

		$tokens = explode("\r\n\r\n", trim($res));
		$res = trim(end($tokens));
		if (strcmp ($res, "VERIFIED") == 0) {

			// $paypal = new Paypal;
			// $paypal->email = $_POST['payer_email'];
			// $paypal->COL_1 = $_POST['item_name'];
			// $paypal->COL_2 = $_POST['payment_status'];
			// $paypal->COL_3 = $_POST['mc_currency'];
			// $paypal->save();

			if($debug == true) {
				$errorLog = new Paypal;
				$errorLog->email = 'developer@zzm.com';
				$errorLog->COL_1 = "Verified IPN: $req ". PHP_EOL;
				$errorLog->save();
			}

		} else if (strcmp ($res, "INVALID") == 0) {

			if($debug == true) {
				$errorLog = new Paypal;
				$errorLog->email = 'developer@zzm.com';
				$errorLog->COL_1 = "Invalid IPN: $req" . PHP_EOL;
				$errorLog->save();
			}
		}
	}



}





