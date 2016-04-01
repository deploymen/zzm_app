<?php namespace	App\Libraries;

use App;
use Exception;
use Config;
use Request;
use DB;
use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\AuthHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\EmailHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\DatabaseUtilHelper;
use App\Libraries\ZapZapQuestionHelper;
use App\Libraries\ApiProfileHelper;


use App\Models;
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
use Session;

class ApiUserHelper{

	public static function Register($role, $name, $email, $country, $username, $password_sha1,  $registerFrom , $deviceId = ''){
		$classId = 0;

		$user = new User;
		$user->role = $role;
		$user->name = $name;
		$user->email = $email;
		$user->country = $country;
		$user->activated = 0;
		$user->register_from = $registerFrom;
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

		return [
			'user_id' => $user->id,
			'class_id' => $classId,
			];
	}

	public static function ProfileGameCode($userId){
		$profile = new GameProfile;
		$profile->user_id = $userId;
		$profile->nickname1 = 999;
		$profile->nickname2 = 999;
		$profile->avatar_id = 999;
		$profile->class_id = $classId;
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
	}

	public static function signin($username , $password_sha1){
		$userAccess = UserAccess::where('username', $username)->where('password_sha1', $password_sha1)->first();

		if (!$userAccess) {
			$log = new LogSignInUser;
			$log->username = $username;
			$log->password_sha1 = $password_sha1;
			$log->success = 0;
			$log->created_ip = Request::ip();
			$log->save();
			return 'invalid username/password';
		}

		$user = User::where('id', $userAccess->user_id)->where('activated', 1)->first();
		
		if (!$user) {
			$log = new LogSignInUser;
			$log->username = $username;
			$log->password_sha1 = $password_sha1;
			$log->success = 0;
			$log->created_ip = Request::ip();
			$log->save();
			return 'account is not activated';
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

		$checkFirstLogin = LogSignInUser::where('username' , $username)->where('success' , 1)->first();

		if(!$checkFirstLogin){
			$firstLogin = 0;
		}

		$log = new LogSignInUser;
		$log->username = $username;
		$log->password_sha1 = $password_sha1;
		$log->success = 1;
		$log->created_ip = Request::ip();
		$log->save();

		$list = User::select('role', 'name')->find($userAccess->user_id);

		return $list;
	}
}
