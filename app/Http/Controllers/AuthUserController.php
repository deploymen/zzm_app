<?php namespace App\Http\Controllers;

use App;
use App\Libraries\AuthHelper;
use App\Libraries\DatabaseUtilHelper;
use App\Libraries\EmailHelper;
use App\Libraries\LogHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\ApiUserHelper;
use App\Libraries\ApiProfileHelper;
use App\Models\GameCode;
use App\Models\GameClass;
use App\Models\GameProfile;
use App\Models\IdCounter;
use App\Models\LogAccountActivate;
use App\Models\LogPasswordReset;
use App\Models\LogSignInUser;
use App\Models\User;
use App\Models\UserAccess;
use App\Models\UserFlag;
use App\Models\UserExternalId;
use App\Models\UserSetting;
use Config;
use Cookie;
use DB;
use Exception;
use Redirect;
use Request;
use Session;
use Socialite;
use GuzzleHttp\Client;

Class AuthUserController extends Controller {

	public function signUp() {

		// sign-up from web & app
		// =======================================================================//
		// ! this sign up is for web only, and not for mobile game client         //
		// =======================================================================//

		// if (!DatabaseUtilHelper::TrafficControl('t0101_user')) {
		// 	return ResponseHelper::OutputJSON('fail', "traffic jam, please try again later.");
		// }

		$username = Request::input('email'); //username = email
		$name = Request::input('name');
		$email = Request::input('email');
		$country = Request::input('country', '');
		$password = Request::input('password');
		$password_sha1 = sha1($password . Config::get('app.auth_salt'));
		$accessToken = '';
		$deviceId = Request::input('device_id'); //optional
		$role = Request::input('role');
		$registerFrom = Request::input('register_from' , 'website');
		$ref = Request::input('ref');
		$classId = 0;

		if (!$username || !$password || !$name || !$email || !$country || !$role) {
			return ResponseHelper::OutputJSON('fail', "missing parameters");
		}

		switch ($role) {
			case 'parent':

			break;
			case 'teacher':

			break;
			default:return ResponseHelper::OutputJSON('fail', "invalid role");
		}

		if (strlen($password) < 6) {
			return ResponseHelper::OutputJSON('fail', 'password must be atleast 6 chars');
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ResponseHelper::OutputJSON('fail', "invalid email format");
		}

		$access = UserAccess::where('username', $username)->first();
		if ($access) {
			return ResponseHelper::OutputJSON('fail', "email used");
		}

		// try {	
			// DB::transaction(function ()
				 // use ($role, $username, $password_sha1, $name, $email, $country, $deviceId, $accessToken, $classId) {

					$user = new User;
					$user->role = $role;
					$user->name = $name;
					$user->email = $email;
					$user->country = $country;
					$user->register_from = $registerFrom;
					$user->ref = $ref;
					$user->save();

					$accessToken = AuthHelper::GenerateAccessToken($user->id);

					$access = new UserAccess;
					$access->user_id = $user->id;
					$access->username = $username;
					$access->password_sha1 = $password_sha1;
					$access->access_token = $accessToken;
					$access->access_token_issue_at = DB::raw('NOW()');
					$access->access_token_issue_ip = Request::ip();
					$access->access_token_expired_at = DB::raw('DATE_ADD(NOW(), INTERVAL 10 YEAR)'); //we dont kick them out
					$access->save();

					$extId = new UserExternalId;
					$extId->user_id = $user->id;
					if ($deviceId) {$extId->device_id = $deviceId;}
					$extId->save();

					$setting = new UserSetting;
					$setting->user_id = $user->id;
					$setting->save();

					$userFlag = new UserFlag;
					$userFlag->user_id = $user->id;

					if($role == 'teacher'){
						$gameClass = new GameClass;
						$gameClass->user_id = $user->id;
						$gameClass->name = 'Default Class';
						$gameClass->save();

						$userFlag->profile_limit = 3;
						$userFlag->class_limit = 50;
						$userFlag->save();

						$classId = $gameClass->id;
					}else{
						$userFlag->profile_limit = 1;
						$userFlag->class_limit = 0;
						$userFlag->save();
					}

					$profile = new GameProfile;
					$profile->user_id = $user->id;
					$profile->nickname1 = 999;
					$profile->nickname2 = 999;
					$profile->avatar_id = 999;
					$profile->class_id = $classId;
					$profile->school = 'default school';
					$profile->save();

					$idCounter = IdCounter::find(1);
					$gameCodeSeed = $idCounter->game_code_seed;
					$idCounter->game_code_seed = $gameCodeSeed + 1;
					$idCounter->save();

					$code = new GameCode;
					$code->type = 'signed_up_profile';
					$code->code = ZapZapHelper::GenerateGameCode($gameCodeSeed);
					$code->seed = $gameCodeSeed;
					$code->profile_id = $profile->id;
					$code->save();

					if ($deviceId) {
						//claim back previous game result played from this device id
						//to do...
					}

					// $secretKey = sha1(time() . $email);
					// $edmHtml = (string) view('emails.account-activation', [
					// 	'name' => $name,
					// 	'app_store_address' => config('app.app_store_url'),
					// 	'username' => $email,
					// 	'zapzapmath_portal' => config('app.website_url') . '/user/sign-in',
					// 	'activation_link' => config('app.website_url') . "/api/auth/activate/{$secretKey}",
					// 	'email_support' => config('app.support_email'),
					// 	'social_media_links' => config('app.fanpage_url'),
					// ]);

					// EmailHelper::SendEmail([
					// 	'about' => 'Welcome',
					// 	'subject' => 'Your Zap Zap Account is now ready!',
					// 	'body' => $edmHtml,
					// 	'bodyHtml' => $edmHtml,
					// 	'toAddresses' => [$email],
					// ]);

					// $logOpenAcc = new LogAccountActivate;
					// $logOpenAcc->user_id = $user->id;
					// $logOpenAcc->secret = $secretKey;
					// $logOpenAcc->save();

					//job done - log it!
					DatabaseUtilHelper::LogInsert($user->id, $user->table, $user->id);
					DatabaseUtilHelper::LogInsert($user->id, $access->table, $user->id);
					DatabaseUtilHelper::LogInsert($user->id, $extId->table, $user->id);
					DatabaseUtilHelper::LogInsert($user->id, $extId->table, $user->id);
					DatabaseUtilHelper::LogInsert($user->id, $profile->table, $profile->id);
					DatabaseUtilHelper::LogInsert($user->id, $code->table, $code->id);

					Session::put('access_token', $accessToken);
					setcookie('access_token', $accessToken, time() + (86400 * 30), "/"); // 86400 = 1 day*/
				// }
				// );

			$userAccess = UserAccess::where('username', $username)->where('password_sha1', $password_sha1)->first();
			$list = User::select('id' , 'role' , 'name' , 'register_from')->find($userAccess->user_id);

		// } catch (Exception $ex) {
		// 	LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
		// 		'source' => 'AuthUserController > signUp',
		// 		'inputs' => Request::all(),
		// 	])]);
		// 	return ResponseHelper::OutputJSON('exception');
		// }

		return ResponseHelper::OutputJSON('success', '', ['user' => $list], [
			'X-access-token' => $accessToken,
		], [
			'access_token' => $accessToken,
		]);
	}

	public function signIn() {

		if (!DatabaseUtilHelper::TrafficControl('t9406_log_signin_user')) {
			return ResponseHelper::OutputJSON('fail', "traffic jam, please try again later.");
		}

		$username = Request::input('username');
		$password = Request::input('password');
		$password_sha1 = sha1($password . Config::get('app.auth_salt'));
		$deviceId = Request::input('device_id'); //optional
		$firstLogin = 0;


		if (!$username || !$password) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		//trial control //will implement here
		try {

			// $userAccess = UserAccess::all();
			$userAccess = UserAccess::where('username', $username)->where('password_sha1', $password_sha1)->first();

			if (!$userAccess) {
				$log = new LogSignInUser;
				$log->username = $username;
				$log->password_sha1 = $password_sha1;
				$log->success = 0;
				$log->created_ip = Request::ip();
				$log->save();
				return ResponseHelper::OutputJSON('fail', 'invalid username/password');
			}

			// $user = User::where('id', $userAccess->user_id)->where('activated', 1)->first();
			
			// if (!$user) {
			// 	$log = new LogSignInUser;
			// 	$log->username = $username;
			// 	$log->password_sha1 = $password_sha1;
			// 	$log->success = 0;
			// 	$log->created_ip = Request::ip();
			// 	$log->save();
			// 	return ResponseHelper::OutputJSON('fail', 'account is not activated');
			// }

			if ($userAccess->access_token == '') {
				$accessToken = AuthHelper::GenerateAccessToken($userAccess->user_id);
				$userAccess->access_token = $accessToken;
				$userAccess->access_token_issue_at = DB::Raw('NOW()');
				$userAccess->access_token_issue_ip = Request::ip();
			} else {
				$accessToken = $userAccess->access_token;
			}

			$userAccess->access_token_expired_at = DB::Raw('DATE_ADD(NOW(), INTERVAL 10 YEAR)');
			$userAccess->save();

			$checkFirstLogin = LogSignInUser::where('username' , $username)->where('success' , 1)->first();

			if(!$checkFirstLogin){
				$firstLogin = 1;
			}

			$log = new LogSignInUser;
			$log->username = $username;
			$log->password_sha1 = $password_sha1;
			$log->success = 1;
			$log->created_ip = Request::ip();
			$log->save();

			$list = User::select('id' , 'role', 'name' , 'register_from')->find($userAccess->user_id);

			Session::put('access_token', $accessToken);
			setcookie('access_token', $accessToken, time() + (86400 * 30), "/"); // 86400 = 1 day*/

			$user = User::find($userAccess->user_id);
			if(!$user->city || !$user->latitude || !$user->longitude){
				$secret = 'SAKF3G83D83MEKX59Y9Z';
				$ip = Request::ip();

				$res = file_get_contents("http://api.apigurus.com/iplocation/v1.8/locateip?key={$secret}&ip={$ip}&format=json&compact=y");			
				$ipDetail = json_decode($res, true);

				if(isset($ipDetail['geolocation_data'])) { 
					$geolocationData = $ipDetail['geolocation_data'];
					$user->city = $geolocationData['city'];
					$user->latitude = $geolocationData['latitude'];
					$user->longitude = $geolocationData['longitude'];
					$user->save();
				}
			}

			return ResponseHelper::OutputJSON('success', '', ['user' => $list , 'first_time_login' => $firstLogin], [
				'X-access-token' => $accessToken,
			], [
				'access_token' => $accessToken,
			]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > signIn',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function connectGoogle() {
		return ResponseHelper::OutputJSON('fail', 'not yet support');
	}

	public function signOut() {
		Session::forget('access_token');
		$cookie = Cookie::forget('access_token');
		return redirect('user/signin')->withCookie($cookie);
	}

	public function check() {
		try {

			return ResponseHelper::OutputJSON('success', '', [
				'user_id' => Request::input('user_id'),
				'user_name' => Request::input('user_name'),
				'user_role' => Request::input('user_role'),
			]);
		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > check',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function changePassword() {

		$userId = Request::input('user_id');
		$password1 = Request::input('password1');
		$password2 = Request::input('password2');

		if (!$password1 || !$password2) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		if (strlen($password2) < 6) {
			return ResponseHelper::OutputJSON('fail', 'password must be atleast 6 chars');
		}

		$password1Sha1 = sha1($password1 . Config::get('app.auth_salt'));
		$password2Sha1 = sha1($password2 . Config::get('app.auth_salt'));

		$userAccess = UserAccess::where('password_sha1', $password1Sha1)->where('user_id', $userId)->first();
		if (!$userAccess) {
			return ResponseHelper::OutputJSON('fail', 'invalid current password');
		}

		try {
			$wipedData = [
				'password_sha1' => $userAccess->password_sha1,
			];

			$userAccess->password_sha1 = $password2Sha1;
			$userAccess->save();

			DatabaseUtilHelper::LogUpdate($userId, $userAccess->table, $userId, $wipedData);
			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > changePassword',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function resetPassword() {

		$password = Request::input('password');
		$secret = Request::input('secret');

		if (!$password || !$secret) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		if (strlen($password) < 6) {
			return ResponseHelper::OutputJSON('fail', 'password must be atleast 6 chars');
		}

		$logPasswordReset = LogPasswordReset::where('secret', $secret)->where('expired', '0')->whereNull('activated_at')->first();
		if (!$logPasswordReset) {
			return ResponseHelper::OutputJSON('fail', 'invalid secret');
		}

		$userId = $logPasswordReset->user_id;
		$userAccess = UserAccess::find($userId);
		if (!$userAccess) {
			return ResponseHelper::OutputJSON('fail', 'user not found');
		}

		try {
			$accessToken = AuthHelper::GenerateAccessToken($userId);

			$logPasswordReset->expired = 1;
			$logPasswordReset->activated_at = DB::raw('NOW()');
			$logPasswordReset->activated_ip = Request::ip();
			$logPasswordReset->save();

			$userAccess->password_sha1 = sha1($password . Config::get('app.auth_salt'));
			$userAccess->access_token = $accessToken;
			$userAccess->save();

			DatabaseUtilHelper::LogUpdate($userId, $userAccess->table, $userId, json_encode(['password_sha1' => $userAccess->password_sha1]));

			Session::put('access_token', $accessToken);
			return ResponseHelper::OutputJSON('success', '', [], [
				'X-access-token' => $accessToken,
			], [
				'access_token' => $accessToken,
			]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > resetPassword',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function activate($secretKey) {

		$logAccountActivated = LogAccountActivate::where('secret', $secretKey)
			->where('expired', '1')
			->whereNotNull('activated_at')
			->first();

		if($logAccountActivated){
			return redirect::to('../user/activated');
		}

		$logAccountActivate = LogAccountActivate::where('secret', $secretKey)
			->where('expired', '0')
			->whereNull('activated_at')
			->first();

		if (!$logAccountActivate) {
			return redirect::to('../user/activate-fail');
		}

		$user = $logAccountActivate->findUser()->first();
		if (!$user) {
			return redirect::to('../user/activate-fail');
		}

		try {
			$logAccountActivate->expired = 1;
			$logAccountActivate->activated_at = DB::raw('NOW()');
			$logAccountActivate->activated_ip = Request::ip();
			$logAccountActivate->save();

			$user->activated = 1;
			$user->save();

			return redirect::to('../user/activate-success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > activate',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function forgotPassword() {

		$email = Request::input('email');

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ResponseHelper::OutputJSON('fail', "invalid email format");
		}

		$user = User::where('email', $email)->first();
		if (!$user) {
			return ResponseHelper::OutputJSON('fail', 'user not found');
		}

		if($user->register_from == 'facebook'){
			return ResponseHelper::OutputJSON('fail', 'this email register by facebook');
		}

		try {

			DB::table('t9202_log_password_reset')
				->where('user_id', $user->id)
				->update([
					'expired' => 1,
				]);

			$secret = sha1($user->name . time());

			$logPasswordReset = new LogPasswordReset;
			$logPasswordReset->user_id = $user->id;
			$logPasswordReset->secret = $secret;
			$logPasswordReset->save();

			$edmHtml = (string) view('emails.forgot-password', [
				'name' => $user->name,
				'username' => $email,
				'zapzapmath_portal' => Config::get('app.website_url') . '/user/sign-in',
				'social_media_links' => Config::get('app.fanpage_url'),
				'reset_url' => Config::get('app.website_url') . '/user/reset-password/' . $secret,
			]);

			EmailHelper::SendEmail([
				'about' => 'Reset Password',
				'subject' => 'Password Recovery Assistance',
				'body' => $edmHtml,
				'bodyHtml' => $edmHtml,
				'toAddresses' => [$email],
			]);
			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > forgotPassword',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function invite() {
		return ResponseHelper::OutputJSON('fail', "not yet support");

		$name = Request::input('name');
		$email = Request::input('email');
		$deviceId = Request::input('device_id', '');

		if (!$name || !$email || !$deviceId) {
			return ResponseHelper::OutputJSON('fail', "missing parameters");
		}

		try {

			$logInvite = new LogInvite;
			$logInvite->email = $email;
			$logInvite->name = $name;
			$logInvite->device_id = $deviceId;
			$logInvite->save();

			$edmHtml = (string) view('emails.invitation', [
				'name' => $name,
				'website_link' => Config::get('app.ses_website_url'),
				'social_media_links' => Config::get('app.ses_fanpage_url'),
				'app_store_address' => Config::get('app.ses_app_store_url'),
				'link' => Config::get('app.ses_website_url') . '/sign-up/' . $deviceId,
			]);

			EmailHelper::SendEmail([
				'about' => 'Invitation',
				'subject' => 'Your kid has sent you invitation.',
				'body' => $edmHtml,
				'bodyHtml' => $edmHtml,
				'toAddresses' => [$email],
			]);

			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > invite',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function update() {
		$userId = Request::input('user_id');

		$name = Request::input('name');
		$mobileNumber = Request::input('mobile_number');
		$address = Request::input('address');

		try {
			$user = User::find($userId);

			if (!$user) {
				return ResponseHelper::OutputJSON('fail', '', 'user not found');
			}

			$wiped = [];

			if ($name) {
				$wiped['name'] = $user->name;
				$user->name = $name;
			}

			if ($mobileNumber) {
				$wiped['mobile_number'] = $user->mobile_number;
				$user->mobile_number = $mobileNumber;
			}

			if ($address) {
				$wiped['address'] = $user->address;
				$user->address = $address;
			}

			$user->save();
			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > update',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function signUpApp() {
		$email = Request::input('email');
		$password = Request::input('password');
		$password_sha1 = sha1($password . Config::get('app.auth_salt'));

		$name = Request::input('name');
		$deviceId = Request::input('deviceId');
		$role = Request::input('role');
		$classId = 0;

		if (!$email || !$name) {
			return ResponseHelper::OutputJSON('fail', "missing parameters");
		}

		if ($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ResponseHelper::OutputJSON('fail', "invalid email format");
		}

		$access = UserAccess::where('username', $email)->first();
		$user = User::where('email' , $email)->first();
		if ($access || $user) {
			return ResponseHelper::OutputJSON('fail', "email used");
		}

		try {
			$user = new User;
			$user->role = $role;
			$user->name = $name;
			$user->email = $email;
			$user->register_from = 'App';
			$user->save();

			$accessToken = AuthHelper::GenerateAccessToken($user->id);

			$access = new UserAccess;
			$access->user_id = $user->id;
			$access->username = $email;
			$access->password_sha1 = $password_sha1;
			$access->access_token = $accessToken;
			$access->access_token_issue_at = DB::raw('NOW()');
			$access->access_token_issue_ip = Request::ip();
			$access->access_token_expired_at = DB::raw('DATE_ADD(NOW(), INTERVAL 10 YEAR)'); //we dont kick them out
			$access->save();

			$extId = new UserExternalId;
			$extId->user_id = $user->id;
			if ($deviceId) {$extId->device_id = $deviceId;}
			$extId->save();

			$setting = new UserSetting;
			$setting->user_id = $user->id;
			$setting->save();

			$userFlag = new UserFlag;
			$userFlag->user_id = $user->id;

			if($role == 'teacher'){
				$gameClass = new GameClass;
				$gameClass->user_id = $user->id;
				$gameClass->name = 'Default Class';
				$gameClass->save();

				$userFlag->profile_limit = 3;
				$userFlag->class_limit = 50;
				$userFlag->save();

				$classId = $gameClass->id;
			}else{
				$userFlag->profile_limit = 1;
				$userFlag->class_limit = 0;
				$userFlag->save();
			}

			$profile = new GameProfile;
			$profile->user_id = $user->id;
			$profile->nickname1 = 999;
			$profile->nickname2 = 999;
			$profile->avatar_id = 999;
			$profile->class_id = $classId;
			$profile->school = 'default school';
			$profile->save();

			$idCounter = IdCounter::find(1);
			$gameCodeSeed = $idCounter->game_code_seed;
			$idCounter->game_code_seed = $gameCodeSeed + 1;
			$idCounter->save();

			$code = new GameCode;
			$code->type = 'signed_up_profile';
			$code->code = ZapZapHelper::GenerateGameCode($gameCodeSeed);
			$code->seed = $gameCodeSeed;
			$code->profile_id = $profile->id;
			$code->save();


			if ($deviceId) {
				//claim back previous game result played from this device id
				//to do...
			}

			$secretKey = sha1(time() . $email);
			$edmHtml = (string) view('emails.set-password-app-signup', [
				'set_url' => config('app.website_url') . '/user/set-password/' . $secretKey,
				'social_media_links' => config('app.fanpage_url'),
			]);

			EmailHelper::SendEmail([
				'about' => 'Welcome',
				'subject' => 'Please Confirm Your Password for Zap Zap Math',
				'body' => $edmHtml,
				'bodyHtml' => $edmHtml,
				'toAddresses' => [$email],
			]);

			$logOpenAcc = new LogAccountActivate;
			$logOpenAcc->user_id = $user->id;
			$logOpenAcc->secret = $secretKey;
			$logOpenAcc->save();

			$logPasswordReset = new LogPasswordReset;
			$logPasswordReset->user_id = $user->id;
			$logPasswordReset->secret = $secretKey;
			$logPasswordReset->save();

			//job done - log it!
			DatabaseUtilHelper::LogInsert($user->id, $user->table, $user->id);
			DatabaseUtilHelper::LogInsert($user->id, $access->table, $user->id);
			DatabaseUtilHelper::LogInsert($user->id, $extId->table, $user->id);
			DatabaseUtilHelper::LogInsert($user->id, $extId->table, $user->id);
			DatabaseUtilHelper::LogInsert($user->id, $profile->table, $profile->id);
			DatabaseUtilHelper::LogInsert($user->id, $code->table, $code->id);

			return ResponseHelper::OutputJSON('success', '', $code->code);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > signUp',
				'inputs' => Request::all(),

			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function ResendACtivateCode(){
		$email = Request::input('email');

		if(!$email){
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		$user = User::where('email', $email)->first();

		if(!$user){
			return ResponseHelper::OutputJSON('fail', 'invalid email');
		}

		if($user->activated){
			return ResponseHelper::OutputJSON('fail', 'email already activated');
		}

		$secretKey = sha1(time() . $email);
		$edmHtml = (string) view('emails.account-activation', [
			'name' => $user->name,
			'app_store_address' => config('app.app_store_url'),
			'username' => $email,
			'zapzapmath_portal' => config('app.website_url') . '/user/sign-in',
			'activation_link' => config('app.website_url') . "/api/auth/activate/{$secretKey}",
			'email_support' => config('app.support_email'),
			'social_media_links' => config('app.fanpage_url'),
		]);

		EmailHelper::SendEmail([
			'about' => 'Welcome',
			'subject' => 'Your Zap Zap Account is now ready!',
			'body' => $edmHtml,
			'bodyHtml' => $edmHtml,
			'toAddresses' => [$email],
		]);

		//expired older activate code
		$logAccountActivate = LogAccountActivate::where('user_id', $user->id)->update(['expired' => 1]);

		$logOpenAcc = new LogAccountActivate;
		$logOpenAcc->user_id = $user->id;
		$logOpenAcc->secret = $secretKey;
		$logOpenAcc->save();

		return ResponseHelper::OutputJSON('success');

	}

	//Socialite
	/**
	 * Redirect the user to the GitHub authentication page.
	 *
	 * @return Response
	 */
	public function redirectToProvider(Request $request) {
		return Socialite::driver('facebook')->redirect();
	}

	/**
	 * Obtain the user information from GitHub.
	 *
	 * @return Response
	 */
	public function handleProviderCallback() {
		$client = new Client;
		$firstLogin = 0;
		$xsrfToken = Cookie::get('XSRF-TOKEN');
		
		$fbUser = Socialite::driver('facebook')->user();
		
		//check User facebook ID
		$userExternalId = UserExternalId::where('facebook_id' , $fbUser->id)->first();

		if($userExternalId){
		
			$user = User::select('id','role', 'name', 'register_from')->find($userExternalId->user_id);
			$userAccess = UserAccess::where('user_id' , $userExternalId->user_id)->first();

			if($userAccess->access_token == '') {
				$accessToken = AuthHelper::GenerateAccessToken($userAccess->user_id);
				$userAccess->access_token = $accessToken;
				$userAccess->access_token_issue_at = DB::Raw('NOW()');
				$userAccess->access_token_issue_ip = Request::ip();
			} else {
				$accessToken = $userAccess->access_token;
			}

			$userAccess->access_token_expired_at = DB::Raw('DATE_ADD(NOW(), INTERVAL 10 YEAR)');
			$userAccess->save();

			$checkFirstLogin = LogSignInUser::where('username' , $userAccess->username)->where('success' , 1)->first();

			if(!$checkFirstLogin){
				$firstLogin = 1;
			}

			$cookie = Cookie::make('access_token', $userAccess->access_token);

			$log = new LogSignInUser;
			$log->username = $userAccess->username;
			$log->password_sha1 = '';
			$log->success = 1;
			$log->created_ip = Request::ip();
			$log->save();

			return redirect(url(env('WEBSITE_URL').'/user/auth-redirect'))->with('user' , json_encode($user))->with('first_time_login', $firstLogin)->withCookie($cookie);
		}

		//check email didnt use
		$userAccess = UserAccess::where('username' , $fbUser->email)->first();

		if(!$userAccess){

			//create new
			return redirect(url(env('WEBSITE_URL').'/user/redirect-signup/facebook'))->with('name' , $fbUser->name)->with('email' , $fbUser->email)->with('facebook_id' , $fbUser->id);

		}

		//sync account
		$user = User::select('id' , 'role', 'name', 'register_from')->find($userAccess->user_id);
		$userExternalId = UserExternalId::where('user_id' , $userAccess->user_id)->update(['facebook_id' => $fbUser->id ]);
		$checkFirstLogin = LogSignInUser::where('username' , $userAccess->username)->where('success' , 1)->first();

		if(!$checkFirstLogin){
			$firstLogin = 1;
		}

		$cookie = Cookie::make('access_token', $userAccess->access_token);

		$log = new LogSignInUser;
		$log->username = $userAccess->username;
		$log->password_sha1 = '';
		$log->success = 1;
		$log->created_ip = Request::ip();
		$log->save();

		return redirect(url(env('WEBSITE_URL').'/user/auth-redirect'))->with('user' , json_encode($user))->with('first_time_login', $firstLogin)->withCookie($cookie);
	}

	public function deleteAccount(){
		$userId = Request::input('user_id');

		$user = User::find($userId);
		$userAccess = UserAccess::find($userId);		
		$gameProfile = GameProfile::where('user_id' , $userId )->get();
		$userSetting = UserSetting::find($userId);
		$userExternalId = UserExternalId::find($userId);

		if(!$user || !$userAccess || !$gameProfile){
			return ResponseHelper::OutputJSON('fail' , 'user not found');
		}

		$user->delete();
		$userAccess->delete();
		$userSetting->delete();
		$userExternalId->delete();
		
		foreach($gameProfile as $gameProfiles){
			$gameCode = GameCode::where('profile_id' , $gameProfiles->id)->delete();
			$gameProfiles->delete();
		}

		return ResponseHelper::OutputJSON('success');

	}

	public function facebookSignUp(){
		$role = Request::input('role');
		$name = Request::input('name');
		$email = Request::input('email');
		$facebook_id = Request::input('facebook_id');
		$country = Request::input('country');

		$classId = 0;
		$newUser = ApiUserHelper::Register($role , $name , $email , $country , $facebook_id , '' , 'facebook');

		$newProfile = ApiProfileHelper::newProfile($newUser['user_id'] , $newUser['class_id']  , 'Default Profile' , '' , '5_or_younger' , 'default school' , 'preschool' , '', 999 , 999 , 999);

		$user = User::select('id' , 'role', 'name' ,'register_from')->find($newUser['user_id']);
		$userExternalId = UserExternalId::where('user_id' , $newUser['user_id'])->update(['facebook_id' => $facebook_id ]);
		$userAccess = UserAccess::where('user_id' , $user->id)->first();

		$firstLogin = 1;

		$cookie = Cookie::make('access_token', $userAccess->access_token);

		$log = new LogSignInUser;
		$log->username = $userAccess->username;
		$log->password_sha1 = '';
		$log->success = 1;
		$log->created_ip = Request::ip();
		$log->save();

		return ResponseHelper::OutputJSON('success', '', ['user' => $user], [
			'X-access-token' => $userAccess->access_token,
		], [
			'access_token' => $userAccess->access_token,
		]);
	}

	public function checkUserFlag(){

		$userId = Request::input('user_id');

		$userFlag = UserFlag::find($userId);
		if(!$userFlag){
			return ResponseHelper::OutputJSON('success' , 'user flag not found');
		}
		$userProfile = GameProfile::where('user_id' , $userId)->count();

		if($userProfile >= $userFlag->profile_limit){
			return ResponseHelper::OutputJSON('success' , '' , ['within_profile_limit' => 0, 'total_share' => $userFlag->total_share]);
		}

		return ResponseHelper::OutputJSON('success' , '' , ['within_profile_limit' => 1 ,'total_share' => $userFlag->total_share]);


	}
}

