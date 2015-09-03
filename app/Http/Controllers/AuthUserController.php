<?php namespace App\Http\Controllers;

use App;
use DB;
use Exception;
use Redirect;
use Config;
use Request;
use Session;
use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\AuthHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\EmailHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\DatabaseUtilHelper;

use App\Models;
use App\Models\User;
use App\Models\UserAccess;
use App\Models\UserExternalId;
use App\Models\UserSetting;
use App\Models\LogSignInUser;
use App\Models\LogAccountActivate;
use App\Models\GameProfile;
use App\Models\GameCode;
use App\Models\IdCounter;
use App\Models\LogPasswordReset;


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
		$password = Request::input('password');
		$password_sha1 = sha1($password . Config::get('app.auth_salt'));
		$name = Request::input('name');
		$email = Request::input('email');
		$country = Request::input('country', '');
		$accessToken = '';
		$deviceId = Request::input('device_id'); //optional
		$role = Request::input('role');

		if (!$username || !$password || !$name || !$email || !$country || !$role) {
			return ResponseHelper::OutputJSON('fail', "missing parameters");
		}

		switch ($role) {
			case 'parent': case 'teacher': break;
			default:return ResponseHelper::OutputJSON('fail', "invalid role");
		}

		if (strlen($password) < 6) {
			return ResponseHelper::OutputJSON('fail', 'password must be atleast 6 chars');
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ResponseHelper::OutputJSON('fail', "invalid email format");
		}

		$access = UserAccess::where('username', $username)->first();
		if($access){
			return ResponseHelper::OutputJSON('fail', "email used");
		}

		try {
			DB::transaction(function ()
				 use ($role, $username, $password_sha1, $name, $email, $country, $deviceId, $accessToken) {

					$user = new User;
					$user->role = $role;
					$user->name = $name;
					$user->email = $email;
					$user->country = $country;
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

					$profile = new GameProfile;
					$profile->user_id = $user->id;
					$profile->nickname1= 1;
					$profile->nickname2= 1;
					$profile->avatar_id = 1;
					$profile->save();

					$idCounter = IdCounter::find(1);
					$gameCodeSeed = $idCounter->game_code_seed;
					$idCounter->game_code_seed = $gameCodeSeed + 1;
					$idCounter->save();

					$code = new GameCode;
					$code->type = 'profile';
					$code->code = ZapZapHelper::GenerateGameCode($gameCodeSeed);
					$code->seed = $gameCodeSeed;
					$code->profile_id = $profile->id;
					$code->save();

					if ($deviceId) {
						//claim back previous game result played from this device id
						//to do...
					}

					$secretKey = sha1(time() . $email);
					$edmHtml = (string) view('emails.account-activation', [
						'name' => $name,
						'app_store_address' => config('app.app_store_url'),
						'username' => $email,
						'zapzapmath_portal' => config('app.website_url') . '/sign-in',
						'activation_link' => config('app.website_url') ."/api/auth/activate/{$secretKey}",
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

					$logOpenAcc = new LogAccountActivate;
					$logOpenAcc->user_id = $user->id;
					$logOpenAcc->secret = $secretKey;
					$logOpenAcc->save();

					//job done - log it!
					DatabaseUtilHelper::LogInsert($user->id, $user->table, $user->id);
					DatabaseUtilHelper::LogInsert($user->id, $access->table, $user->id);
					DatabaseUtilHelper::LogInsert($user->id, $extId->table, $user->id);
					DatabaseUtilHelper::LogInsert($user->id, $extId->table, $user->id);
					DatabaseUtilHelper::LogInsert($user->id, $profile->table, $profile->id);
					DatabaseUtilHelper::LogInsert($user->id, $code->table, $code->id);

					Session::put('access_token', $accessToken);
					setcookie('access_token', $accessToken, time() + (86400 * 30), "/"); // 86400 = 1 day*/
				});

				$userAccess = UserAccess::where('username', $username)->where('password_sha1', $password_sha1)->first();
				$list = User::select('role','name')->find($userAccess->user_id);
			} catch (Exception $ex) {
				LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
					'source' => 'AuthUserController > signUp',
					'inputs' => Request::all(),
				])]);
				return ResponseHelper::OutputJSON('exception');
			}

			return ResponseHelper::OutputJSON('success', '', $list, [
				'X-access-token' => $accessToken
			],[
				'access_token' => $accessToken
			]);	
	}

	public function signIn() {

		if (!DatabaseUtilHelper::TrafficControl('t9406_log_signin_user')) {
			return ResponseHelper::OutputJSON('fail', "traffic jam, please try again later.");
		}

		$username = Request::input('username');
		$password = Request::input('password');
		$password_sha1 = sha1($password.Config::get('app.auth_salt'));

		$deviceId = Request::input('device_id'); //optional

		if (!$username || !$password) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		//trial control //will implement here
		try {
	
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

			$log = new LogSignInUser;
			$log->username = $username;
			$log->password_sha1 = $password_sha1;
			$log->success = 1;
			$log->created_ip = Request::ip();
			$log->save();
			
			$list = User::select('role','name')->find($userAccess->user_id);


			Session::put('access_token', $accessToken);
			setcookie('access_token', $accessToken, time() + (86400 * 30), "/"); // 86400 = 1 day*/

			return ResponseHelper::OutputJSON('success', '', [], [
				'X-access-token' => $accessToken
			],[
				'access_token' => $accessToken
			]);				

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > signIn',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function connectFacebook() {
		return ResponseHelper::OutputJSON('fail', 'not yet support');
	}

	public function connectGoogle() {
		return ResponseHelper::OutputJSON('fail', 'not yet support');
	}

	public function signOut() {
		$accessToken = Request::header('X-access-token');
		try {
			$userAccess = UserAccess::where('access_token', $accessToken)->first();
			if ($userAccess) {
				$userAccess->access_token = '';
				$userAccess->access_token_issue_at = DB::Raw('NOW()');
				$userAccess->access_token_issue_ip = Request::ip();
				$userAccess->access_token_expired_at = DB::Raw('NOW()');
				$userAccess->save();
			}

			return ResponseHelper::OutputJSON('success');
		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'AuthUserController > signOut',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
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
				'password_sha1'=>$userAccess->password_sha1
			];

			
			$userAccess->password_sha1 = $password2Sha1;
			$userAccess->save();

			DatabaseUtilHelper::LogUpdate($userId, $userAccess->table, $userId ,$wipedData);
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

			DatabaseUtilHelper::LogUpdate($userId, $userAccess->table, $userId ,json_encode(['password_sha1' => $userAccess->password_sha1]));

			Session::put('access_token', $accessToken);
			return ResponseHelper::OutputJSON('success', '', [], [
				'X-access-token' => $accessToken
			],[
				'access_token' => $accessToken
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

		$logAccountActivate = LogAccountActivate::where('secret', $secretKey)
			->where('expired', '0')
			->whereNull('activated_at')
			->first();

		if (!$logAccountActivate) {
			return redirect::to('/activate-fail');
		}

		$user = $logAccountActivate->findUser()->first();
		if (!$user) {
			return redirect::to('/activate-fail');
		}

		try {
			$logAccountActivate->expired = 1;
			$logAccountActivate->activated_at = DB::raw('NOW()');
			$logAccountActivate->activated_ip = Request::ip();
			$logAccountActivate->save();

			$user->activated = 1;
			$user->save();

			return redirect::to('/activate-success');

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
				'zapzapmath_portal' => Config::get('app.website_url').'/sign-in',
				'social_media_links' => Config::get('app.fanpage_url'),
				'reset_url' => 'http://staging.zapzapmath.com/user/reset-password/' . $secret,
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

		try{
			$user = User::find($userId);

			if(!$user){
			return ResponseHelper::OutputJSON('fail','','user not found');
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

}
