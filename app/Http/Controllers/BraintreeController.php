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
use App\Libraries\LogHelper;
use App\Libraries\ResponseHelper;
use Request;
use Braintree_ClientToken;
use Braintree_Configuration;

class BraintreeController extends Controller {

	public function generateToken(){

		Braintree_Configuration::environment('sandbox');
		Braintree_Configuration::merchantId('sn37rg5tcpydtbt3');
		Braintree_Configuration::publicKey('3xdbz3s8mbrqnjpt');
		Braintree_Configuration::privateKey('2a10e16734ee11bee5c7b0aab86be986');
		$clientToken = Braintree_ClientToken::generate();

		return ResponseHelper::OutputJSON('success', '' , ['token' => $clientToken]);
	}
}





