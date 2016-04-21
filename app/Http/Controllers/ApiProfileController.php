<?php namespace App\Http\Controllers;

use App;
use App\Libraries\ApiProfileHelper;
use App\Libraries\DatabaseUtilHelper;
use App\Libraries\LogHelper;
use App\Libraries\ReportProfileHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\ZapZapHelper;
use App\Models\AvatarSet;
use App\Models\GameClass;
use App\Models\GameCode;
use App\Models\GamePlanet;
use App\Models\GamePlay;
use App\Models\GameProfile;
use App\Models\IdCounter;
use App\Models\SetNickname1;
use App\Models\SetNickname2;
use App\Models\UserMap;
use App\Models\UserFlag;
use App\Models\Age;
use App\Models\LogFacebookShare;
use DB;
use Exception;
use Request;
use Facebook\Facebook;
use Facebook\FacebookRequest;

Class ApiProfileController extends Controller {

	// =======================================================================//
	// ! Parent | Teacher												      //
	// =======================================================================//
	public function get() {
		$userId = Request::input('user_id');
		try {
			$profileInfo = ApiProfileHelper::GetProfile($userId , 0);

			return ResponseHelper::OutputJSON('success', '', ['list' => $profileInfo]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > get',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function create() {

		$userId = Request::input('user_id');

		$firstName = Request::input('first_name');
		$lastName = Request::input('last_name', '');
		$age = Request::input('age');
		$school = Request::input('school');
		$grade = Request::input('grade');
		$email = Request::input('email', '');
		$classId = Request::input('class_id' , 0);

		$nickname1 = Request::input('nickname1', 999);
		$nickname2 = Request::input('nickname2', 999);
		$avatarId = Request::input('avatar_id', 999);

		try {
			
			if (!$firstName || !$school || !$age || !$grade) {
				return ResponseHelper::OutputJSON('fail', "missing parameters");
			}

			if ($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return ResponseHelper::OutputJSON('fail', "invalid email format");
			}

			$nickname1Set = SetNickname1::find($nickname1);
			$nickname2Set = SetNickname2::find($nickname2);
			
			if (!$nickname1) {
				return ResponseHelper::OutputJSON('fail', "invalid nickname id");
			}

			if (!$nickname2) {
				return ResponseHelper::OutputJSON('fail', "invalid nickname id");
			}

			if (!$avatarId) {
				return ResponseHelper::OutputJSON('fail', "invalid avatar id");
			}

			if($classId){
				$gameClass = GameClass::find($classId);
				if(!$gameClass || $gameClass->user_id != $userId) {
					return ResponseHelper::OutputJSON('fail', "class not found");
				}
			}

			$userFlag = UserFlag::find($userId);
			if(!$userFlag){
				return ResponseHelper::OutputJSON('fail', "user flag not found");
			}
			
			if($classId){
				$profileClass = GameProfile::where('class_id' , $classId)->where('user_id', $userId)->count();

				if($profileClass >= $userFlag->profile_limit){
					return ResponseHelper::OutputJSON('fail', "class limited" );
				}
			}else{
				$userProfile = GameProfile::where('user_id' , $userId)->count();

				if($userProfile >= $userFlag->profile_limit){
					return ResponseHelper::OutputJSON('fail', "profile limited" , ['total_share' => $userFlag->total_share]);
				}
			}
		
			$avatarIdSet = AvatarSet::find($avatarId);

			$profile = new GameProfile;
			$profile->user_id = $userId;
			$profile->class_id = $classId;
			$profile->first_name = $firstName;
			$profile->last_name = $lastName;
			$profile->age = $age;
			$profile->school = $school;
			$profile->grade = $grade;
			$profile->email = $email;
			$profile->nickname1 = $nickname1;
			$profile->nickname2 = $nickname2;
			$profile->avatar_id = $avatarId;
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

			DatabaseUtilHelper::LogInsert($userId, $profile->table, $userId);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > create',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}

		return ResponseHelper::OutputJSON('success', '', [
			'profile' => $profile,
		]);
	}

	public function update($id) {
		$userId = Request::input('user_id');

		$firstName = Request::input('first_name');
		$lastName = Request::input('last_name');
		$age = Request::input('age');
		$school = Request::input('school');
		$grade = Request::input('grade');
		$email = Request::input('email');
		$nickname1 = Request::input('nickname1');
		$nickname2 = Request::input('nickname2');
		$avatarId = Request::input('avatar_id');
		$classId = Request::input('class_id');

		try {

			if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return ResponseHelper::OutputJSON('fail', "invalid email format");
			}

			$profile = GameProfile::find($id);
			if (!$profile) {
				return ResponseHelper::OutputJSON('fail', "profile not found");
			}

			if ($userId != $profile->user_id) {
				return ResponseHelper::OutputJSON('fail', 'wrong user id');
			}

			if ($firstName) {
				$profile->first_name = $firstName;
			}

			if ($lastName) {
				$profile->last_name = $lastName;
			}

			if ($age) {
				$profile->age = $age;
			}

			if ($school) {
				$profile->school = $school;
			}

			if ($grade) {
				$profile->grade = $grade;
			}

			if ($email) {
				$profile->email = $email;
			}

			if ($classId) {
				$profileClass = GameProfile::where('class_id' , $classId)->where('user_id', $userId)->count();

				if($profileClass >= $userFlag->profile_limit){
					return ResponseHelper::OutputJSON('fail', "limited");
				}
				
				$gameClass = GameClass::find($classId);

				if(!$gameClass || $gameClass->user_id != $userId ) {
					return ResponseHelper::OutputJSON('fail', "class not found");
				}
				$profile->class_id = $classId;
			}

			if ($nickname1) {
				$nicknameSet = SetNickname1::find($nickname1);				
				if (!$nicknameSet) {
					return ResponseHelper::OutputJSON('fail', "nickname not found");
				}
				$profile->nickname1 = $nickname1;
			}

			if ($nickname2) {
				$nicknameSet = SetNickname2::find($nickname2);
				if (!$nicknameSet) {
					return ResponseHelper::OutputJSON('fail', "nickname not found");
				}
				$profile->nickname2 = $nickname2;
			}

			if ($avatarId) {
				$avatarSet = AvatarSet::find($avatarId);
				if (!$avatarSet) {
					return ResponseHelper::OutputJSON('fail', "avatar not found");
				}
				$profile->avatar_id = $avatarId;
			}

			$profile->save();

			return ResponseHelper::OutputJSON('success', '', $profile->toArray());

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > update',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function delete($id) {
		$userId = Request::input('user_id');

		try {

			$profile = GameProfile::find($id);

			if (!$profile) {
				return ResponseHelper::OutputJSON('fail', "profile not found");
			}

			if ($userId != $profile->user_id) {
				return ResponseHelper::OutputJSON('fail', 'wrong user id');
			}

			$gameCode = GameCode::where('profile_id' , $id)->delete();
			$profile->delete();
			
			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > delete',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function getNick() {
		try {
			$list1 = SetNickname1::select('id', 'name')->get();
			$list2 = SetNickname2::select('id', 'name')->get();
			$list3 = AvatarSet::select('id', 'name', 'filename')->get();

			return ResponseHelper::OutputJSON('success', '', [
				'nickname1' => $list1->toArray(),
				'nickname2' => $list2->toArray(),
				'avatars' => $list3->toArray(),
			]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > getNick',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function getProfile($id) {

		$userId = Request::input('user_id');

		try {

			$profile = GameProfile::select('id', 'user_id', 'class_id', 'first_name', 'last_name', 'age', 'school', 'grade', 'city', 'country', 'email', 'nickname1', 'nickname2', 'avatar_id')->find($id);

			if (!$profile) {
				return ResponseHelper::OutputJSON('fail', 'profile not found');
			}

			$profile->nickName1;
			$profile->nickName2;
			$profile->avatar;
			$profile->gameCode;

			if ($userId != $profile->user_id) {
				return ResponseHelper::OutputJSON('fail', 'wrong user id');
			}

			return ResponseHelper::OutputJSON('success', '', ['profile' => $profile->toArray()]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > getProfile',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function gameUpdate() {
		$profileId = Request::input('game_code_profile_id');
		$userId = Request::input('user_id');

		$nickname1 = Request::input('nickname1');
		$nickname2 = Request::input('nickname2');
		$avatarId = Request::input('avatar_id');
		$age = Request::input('age' , 0);
		$grade = Request::input('grade', 'preschool');
		

		try {
			$profile = GameProfile::find($profileId);
			if (!$profile) {
				return ResponseHelper::OutputJSON('fail', "profile not found");
			}

			$nicknameSet = SetNickname1::find($nickname1);
			if (!$nicknameSet) {
				return ResponseHelper::OutputJSON('fail', "nickname1 not found");
			}

			$nicknameSet = SetNickname2::find($nickname2);
			if (!$nicknameSet) {
				return ResponseHelper::OutputJSON('fail', "nickname2 not found");
			}

			$avatarSet = AvatarSet::find($avatarId);
			if (!$avatarSet) {
				return ResponseHelper::OutputJSON('fail', "avatar not found");
			}
			
			if($age){
				$ageSet = Age::where('age', $age)->first();
				if (!$ageSet) {
					return ResponseHelper::OutputJSON('fail', "age not found");
				}
			}
			
			$secret = 'SAKA5636953H5Z26Q74Z';
			$ip = Request::ip();

			$res = file_get_contents("http://api.apigurus.com/iplocation/v1.8/locateip?key={$secret}&ip={$ip}&format=json&compact=y");			
			$ipDetail = json_decode($res, true);

			if(isset($ipDetail['geolocation_data']))
			{ 
				$geolocationData = $ipDetail['geolocation_data'];
				$profile->city = $geolocationData['city'];
				$profile->country = $geolocationData['country_name'];
				$profile->latitude = $geolocationData['latitude'];
				$profile->longitude = $geolocationData['longitude'];
			}

			$profile->nickname1 = $nickname1;
			$profile->nickname2 = $nickname2;
			$profile->avatar_id = $avatarId;
			$profile->age = $age;
			$profile->grade = $grade;
			$profile->save();

			return ResponseHelper::OutputJSON('success', '', $profile->toArray());

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > gameUpdate',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function GenerateAnonymousGameCode() {
		$deviceId = Request::input('device_id');

		try {
			$idCounter = IdCounter::find(1);
			$gameCodeSeed = $idCounter->game_code_seed;
			$idCounter->game_code_seed = $gameCodeSeed + 1;
			$idCounter->save();

			$gamePro = new GameProfile;
			$gamePro->user_id = 0;
			$gamePro->first_name = "Player 1";
			$gamePro->last_name = "Player 1";
			$gamePro->nickname1 = 999;
			$gamePro->nickname2 = 999;
			$gamePro->avatar_id = 999;
			$gamePro->save();

			$code = new GameCode;
			$code->profile_id = $gamePro->id;
			$code->type = 'anonymous';
			$code->code = ZapZapHelper::GenerateGameCode($gameCodeSeed);
			$code->seed = $gameCodeSeed;
			$code->device_id = $deviceId;
			$code->save();

			return ResponseHelper::OutputJSON('success', '', ['game_code' => $code->code]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > GenerateAnonymousGameCode',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function verifyCode() {
		$gameCodeExisted = Request::input('game_code'); //game in device
		$gameCodeEnter = Request::input('game_code_enter'); //game new key in

		if (!$gameCodeEnter) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		$deviceGameCode = GameCode::where('code', $gameCodeExisted)->first();
		if (!$deviceGameCode) {
			return ResponseHelper::OutputJSON('fail', 'device game code no found');
		}

		$currentGameCode = GameCode::where('code', $gameCodeEnter)->first();
		if (!$currentGameCode) {
			return ResponseHelper::OutputJSON('fail', 'game code no found');
		}

		$deviceProfile = GameProfile::find($deviceGameCode->profile_id);
		if (!$deviceProfile) {
			return ResponseHelper::OutputJSON('fail', 'anonymous profile no found');
		}

		$profile = GameProfile::find($currentGameCode->profile_id);
		if (!$profile) {
			return ResponseHelper::OutputJSON('fail', 'profile no found');
		}

		try {
			$verifyHelper = ApiProfileHelper::verifyTransfer($deviceGameCode , $currentGameCode);

			if(!$verifyHelper){
				return ResponseHelper::OutputJSON('fail', 'verify error');
			}

			return ResponseHelper::OutputJSON('success', '' , [
				'device_game_code' => $deviceGameCode,
				'enter_game_code' => $currentGameCode,
				'status' => $verifyHelper,
				]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > verifyCode',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function profileTransfer() {
		$gameCodeExisted = Request::input('game_code'); //game in device
		$gameCodeEnter = Request::input('game_code_enter'); //game new key in

		if (!$gameCodeEnter) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		$deviceGameCode = GameCode::where('code', $gameCodeExisted)->first();
		if (!$deviceGameCode) {
			return ResponseHelper::OutputJSON('fail', 'device game code no found');
		}

		$currentGameCode = GameCode::where('code', $gameCodeEnter)->first();
		if (!$currentGameCode) {
			return ResponseHelper::OutputJSON('fail', 'game code no found');
		}

		$deviceProfile = GameProfile::find($deviceGameCode->profile_id);
		if (!$deviceProfile) {
			return ResponseHelper::OutputJSON('fail', 'anonymous profile no found');
		}

		$profile = GameProfile::find($currentGameCode->profile_id);
		if (!$profile) {
			return ResponseHelper::OutputJSON('fail', 'profile no found');
		}

		try {
			$verifyHelper = ApiProfileHelper::verifyTransfer($deviceGameCode , $currentGameCode);

			if($verifyHelper['profile_transfer']){
				$gamePlay = GamePlay::where('code' , $gameCodeExisted)->update([
					'type' => 'signed_up_profile',
					'code' => $gameCodeEnter,
					'user_id' => $profile->user_id,
					'profile_id' => $profile->id,
					'device_id' => $currentGameCode->device_id
					]);

				$gameUserMap = UserMap::where('profile_id' , $deviceProfile->id)->update(['profile_id' => $profile->id]);
				
				$profile->nickname1 = $deviceProfile->nickname1;
				$profile->nickname2 = $deviceProfile->nickname2;
				$profile->avatar_id = $deviceProfile->avatar_id;
				$profile->save();

				$currentGameCode->played = 1;
				$currentGameCode->save();

				return ResponseHelper::OutputJSON('success');
			}

			return ResponseHelper::OutputJSON('fail', 'profile transfer is not allow on the inputs given');
			
		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > profileTransfer',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function profileTransferLoose() {
		$gameCodeExisted = Request::input('game_code'); //game in device
		$gameCodeEnter = Request::input('game_code_enter'); //game new key in

		if (!$gameCodeEnter) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		$deviceGameCode = GameCode::where('code', $gameCodeExisted)->first();
		if (!$deviceGameCode) {
			return ResponseHelper::OutputJSON('fail', 'device game code no found');
		}

		$currentGameCode = GameCode::where('code', $gameCodeEnter)->first();
		if (!$currentGameCode) {
			return ResponseHelper::OutputJSON('fail', 'game code no found');
		}

		$deviceProfile = GameProfile::find($deviceGameCode->profile_id);
		if (!$deviceProfile) {
			return ResponseHelper::OutputJSON('fail', 'anonymous profile no found');
		}

		$profile = GameProfile::find($currentGameCode->profile_id);
		if (!$profile) {
			return ResponseHelper::OutputJSON('fail', 'profile no found');
		}

		if($deviceGameCode->type != 'anonymous' || $currentGameCode->type != 'signed_up_profile'){
			return ResponseHelper::OutputJSON('fail', 'profile transfer is not allow on the inputs given');
		}

		try {

			$gPlay = GamePlay::where('code' , $gameCodeExisted)->first();
			if($gPlay){
				$gamePlay = GamePlay::where('code' , $gameCodeExisted)->update([
				'type' => 'signed_up_profile',
				'code' => $gameCodeEnter,
				'user_id' => $profile->user_id,
				'profile_id' => $profile->id,
				'device_id' => $currentGameCode->device_id
				]);
			}
			
			$gUserMap = UserMap::where('profile_id' , $deviceProfile->id)->first();
			if($gUserMap){
				$gameUserMap = UserMap::where('profile_id' , $deviceProfile->id)->update(['profile_id' => $profile->id]);
			}

			
			$profile->nickname1 = $deviceProfile->nickname1;
			$profile->nickname2 = $deviceProfile->nickname2;
			$profile->avatar_id = $deviceProfile->avatar_id;
			$profile->save();

			$currentGameCode->played = 1;
			$currentGameCode->save();

			return ResponseHelper::OutputJSON('success');
			
		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > profileTransfer',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function profileDetails() {
		$profileId = Request::input('profile_id');
		$userId = Request::input('user_id');

		try {
			if (!$profileId) {
				return ResponseHelper::OutputJSON('fail', 'misssing parameters');
			}

			$profile = GameProfile::find($profileId);
			if ($userId != $profile->user_id) {
				return ResponseHelper::OutputJSON('fail', 'invalid profile');
			}

			$gameCode = GameCode::where('profile_id', $profileId)->first();
			$planetCount = GamePlanet::where('enable', 1)->count();

			$lastPlay = ReportProfileHelper::LastPlay($profileId);
			$totalPlay = ReportProfileHelper::TotalPlay($profileId);
			$planetProgress = ReportProfileHelper::planetProgress($profileId);
			$TotalCompletedPlanet = ReportProfileHelper::TotalCompletedPlanet($profileId);

			return ResponseHelper::OutputJSON('success', '', [
				'first_name' => $profile->first_name,
				'last_name' => $profile->last_name,
				'game_code' => $gameCode->code,
				'total_play' => $totalPlay->total_play,
				'total_pass' => $totalPlay->total_pass,
				'total_fail' => $totalPlay->total_fail,
				'total_completed_planet' => $TotalCompletedPlanet->completed_planet . '/' . $planetCount,
				'last_play' => $lastPlay,
				'planet_progress' => $planetProgress,
			]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > profileDetails',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function unlockParentLimit() {
		
		$userId = Request::input('user_id');

		$fb = new Facebook([
            'app_id' => env('FACEBOOK_APP_KEY'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.5',
       	 ]);

		$helper = $fb->getJavaScriptHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            // echo 'Graph returned an error: ' . $e->getMessage();
            LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > unlockUserLimit',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            // echo 'Facebook SDK returned an error: ' . $e->getMessage();
            LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > unlockUserLimit',
				'inputs' => Request::all(),
			])]);
        }

        if (!isset($accessToken)) {
			return ResponseHelper::OutputJSON('fail' , 'No cookie set or no OAuth data could be obtained from cookie.');
        }

		try {
	        $postId = Request::input('post_id');

	        $response = $fb->get('/' . $postId. '?fields=privacy' , $accessToken->getValue());
	        $graphObject = $response->getGraphObject();

	        //get user Flag
	        $userFlag = UserFlag::find($userId);
	        if(!$userFlag){
				return ResponseHelper::OutputJSON('fail' , 'user flag not found');
	        }

			if($graphObject['privacy']['value'] == 'SELF'){
				return ResponseHelper::OutputJSON('fail' , 'privacy is not allow');
			}

			$userFlag->profile_limit = 5;
			$userFlag->total_share = $userFlag->total_share+1;
			$userFlag->save();

			$logFacebookShare = new LogFacebookShare;
			$logFacebookShare->user_id = $userId;
			$logFacebookShare->privacy = $graphObject['privacy']['value'];
			$logFacebookShare->post_id = $postId;
			$logFacebookShare->created_ip = Request::ip();
			$logFacebookShare->save();

			return ResponseHelper::OutputJSON('success');


		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > unlockUserLimitt',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}
}
