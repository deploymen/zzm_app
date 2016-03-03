<?php namespace App\Http\Controllers;

use Config;
use Cookie;
use DB;
use Exception;
use Redirect;
use Request;
use Session;
use Socialite;
use Schoology;

Class schoologyController extends Controller {

	public function schoology() {
		// require_once('../public/schoology_sdk/SchoologyApi.class.php');

	

		$url = Schoology::authorize();	
		$url = preg_replace( '/^http:\/\//', '', $url);
		return redirect($url);

		//Schoology::authorize();

		$users = Schoology::apiResult('users');
		//var_export($users); die();
	}
}

// http://zzm.uat.my/saml/acs?realm=user&realm_id=31347549&app_id=506504863&is_ssl=1
