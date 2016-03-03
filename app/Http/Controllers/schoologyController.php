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
		$url = str_replace('http://https', 'https', $url);
		return redirect($url);
	}

	public function schoology2(){
		$users = Schoology::apiResult('users');
	}
}

// http://zzm.uat.my/saml/acs?realm=user&realm_id=31347549&app_id=506504863&is_ssl=1
