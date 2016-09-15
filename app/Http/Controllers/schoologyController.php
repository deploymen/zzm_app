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
use App\Models\User;
use App\Models\UserAccess;

Class schoologyController extends Controller {

	public function schoology() {
		// require_once('../public/schoology_sdk/SchoologyApi.class.php');

		$url = Schoology::authorize();	

		return redirect($url);
	}

	public function schoologyUser(\Illuminate\Http\Request $request){
		$firstLogin = 0;
		$schoologyUser = Schoology::apiResult('users/me');

		$user = User::select('id','role', 'name', 'register_from')->where('email', $schoologyUser->primary_email)->first();
		$userAccess = UserAccess::where('username' , $schoologyUser->uid)->first();

		if(!$user){
			setcookie("current_user", json_encode(['name' => $schoologyUser->name_display, 'email' => $schoologyUser->primary_email]), 0, "/");
			return redirect(url(env('WEBSITE_URL').'/user/redirect-signup/schoology'));
		}

		$checkFirstLogin = LogSignInUser::where('username' , $userAccess->username)->where('success' , 1)->first();

		if(!$checkFirstLogin){
			$firstLogin = 1;
		}

		$cookie = Cookie::make('access_token', $userAccess->access_token);
	    setcookie("current_user", json_encode(['user' => $user, 'first_time_login' => $firstLogin]), 0, "/");
		return redirect(url(env('WEBSITE_URL').'/user/auth-redirect'))->withCookie($cookie);
	}
}