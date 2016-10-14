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
use App\Models\SpaceshipUserSpaceship;
use App\Models\SpaceshipUserItem;
use App\Models\SpaceshipUserFloor;
use App\Models\GameCoinTransaction;
use App\Models\GameMission;
use App\Models\StudentIdChange;
use DB;
use Exception;
use Request;
use Facebook\Facebook;
use Validator;
use Facebook\FacebookRequest;
use Input;

use PHPExcel_IOFactory;
use PHPExcel_Style_Color;
use PHPExcel_Style_NumberFormat;

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
		$classId = Request::input('class_id' , 0);

		$nickname1 = Request::input('nickname1', 999);
		$nickname2 = Request::input('nickname2', 999);
		$avatarId = Request::input('avatar_id', 999);

		try {
			
			if (!$firstName || !$school || !$age || !$grade) {
				return ResponseHelper::OutputJSON('fail', "missing parameters");
			}

			$nickname1Set = SetNickname1::find($nickname1);
			$nickname2Set = SetNickname2::find($nickname2);
			
			if (!$nickname1Set) {
				return ResponseHelper::OutputJSON('fail', "invalid nickname id");
			}

			if (!$nickname2Set) {
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
				$profileLimit = ($gameClass->expired_at > date("Y-m-d H:i:s"))?50:30;

				if($profileClass >= $profileLimit){
					return ResponseHelper::OutputJSON('fail', "class limited" );
				}
			}else{
				$userProfile = GameProfile::where('user_id' , $userId)->count();

				if($userProfile >= $userFlag->profile_limit){
					return ResponseHelper::OutputJSON('fail', "profile limited" , ['total_share' => $userFlag->total_share]);
				}
			}
		
			$avatarIdSet = AvatarSet::find($avatarId);
			$newProfile = ApiProfileHelper::newProfile($userId, $classId  ,$firstName, $age, $school, $grade, $nickname1, $nickname2, $avatarId , '');


		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > create',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}

		return ResponseHelper::OutputJSON('success', '', [
			'profile' => $newProfile,
		]); //production
	}

	public function createV1_3() {

		$userId = Request::input('user_id');

		$firstName = Request::input('first_name');
		$age = Request::input('age');
		$school = Request::input('school');
		$grade = Request::input('grade');
		$studentId = Request::input('student_id');
		$classId = Request::input('class_id' , 0);

		$nickname1 = Request::input('nickname1', 999);
		$nickname2 = Request::input('nickname2', 999);
		$avatarId = Request::input('avatar_id', 999);

		try {
		
			$nickname1Set = SetNickname1::find($nickname1);
			$nickname2Set = SetNickname2::find($nickname2);

			$validator = Validator::make( Input::all(), [
				'first_name' => 'required',
				'age' => 'required',
				'school' => 'required',
				'grade' => 'required',
				'student_id' => 'required|min:6|max:20|regex:/^[a-zA-Z0-9@()_\-:\/]+$/',
			]);

			if ($validator->fails()) {
				return ResponseHelper::OutputJSON('fail', array_flatten(head($validator->errors()))[0]);
			}

			$profile = GameProfile::checkStudentId($studentId);
			$studentIdChange = StudentIdChange::where('student_id', $studentId)->first();

			if($profile || $studentIdChange){
				return ResponseHelper::OutputJSON('fail', "student id has been used");
			}
					
			if (!$nickname1Set || !$nickname2Set) {
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
				$profileClass = GameProfile::where('class_id', $classId)->where('user_id', $userId)->count();
				$profileLimit = ($gameClass->expired_at > date("Y-m-d H:i:s"))?50:30;

				if($profileClass >= $profileLimit){
					return ResponseHelper::OutputJSON('fail', "class limited" );
				}
			}else{
				$userProfile = GameProfile::where('user_id', $userId)->count();

				if($userProfile >= $userFlag->profile_limit){
					return ResponseHelper::OutputJSON('fail', "profile limited" , ['total_share' => $userFlag->total_share]);
				}
			}
			
			$newProfile = ApiProfileHelper::newProfile($userId, $classId  ,$firstName, $age, $school, $grade, $nickname1, $nickname2, $avatarId , $studentId);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > create',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}

		return ResponseHelper::OutputJSON('success', '', [
			'profile' => $newProfile,
		]); //dev
	}

	public function update($id) {
		$userId = Request::input('user_id');

		$studentId = Request::input('student_id');
		$firstName = Request::input('first_name');
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

			$studentIdChange = StudentIdChange::where('student_id', $studentId)->first();
			$checkProfile = GameProfile::where('student_id', $studentId)->first();

			if($checkProfile || $studentIdChange){
				return ResponseHelper::OutputJSON('fail', "student id has been used");
			}

			if ($studentId) {
				$studentIdChange = new StudentIdChange;
				$studentIdChange->user_id = $userId;
				$studentIdChange->profile_id = $profile->id;
				$studentIdChange->student_id = $profile->student_id;
				$studentIdChange->save();
				
				$profile->student_id = $studentId;
			}

			if ($firstName) {
				$profile->first_name = $firstName;
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
				$profileClass = GameProfile::where('class_id', $classId)->where('user_id', $userId)->count();

				$gameClass = GameClass::find($classId);
				if(!$gameClass || $gameClass->user_id != $userId ) {
					return ResponseHelper::OutputJSON('fail', "class not found");
				}

				$profileLimit = ($gameClass->expired_at > date("Y-m-d H:i:s"))?50:30;

				if($profileClass >= $profileLimit){
					return ResponseHelper::OutputJSON('fail', "class limited" );
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
				// 'source' => 'ApiProfileController > update',
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

			$gameCode = GameCode::where('profile_id', $id)->delete();
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

			$profile = GameProfile::select('id', 'user_id', 'class_id', 'student_id' , 'first_name', 'age', 'school', 'grade', 'city', 'country', 'nickname1', 'nickname2', 'avatar_id', 'coin' ,'expired_at')->find($id);

			if (!$profile) {
				return ResponseHelper::OutputJSON('fail', 'profile not found');
			}

			$profile->nickName1;
			$profile->nickName2;
			$profile->avatar;
			$profile->paid = ($profile->expired_at > date("Y-m-d H:i:s") )?1:0;

			if ($userId != $profile->user_id) {
				return ResponseHelper::OutputJSON('fail', 'wrong user id');
			}

			return ResponseHelper::OutputJSON('success', '', ['profile' => $profile->toArray()] );
			
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
		$age = Request::input('age');
		$grade = Request::input('grade');
		

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

	public function gameUpdateV1_3() {
		$profileId = Request::input('student_profile_id');
		$userId = Request::input('user_id');

		$nickname1 = Request::input('nickname1');
		$nickname2 = Request::input('nickname2');
		$avatarId = Request::input('avatar_id');
		$age = Request::input('age');
		$grade = Request::input('grade');
		

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

	public function GenerateAnonymousGameCode(){
		$deviceId = Request::input('device_id');

		try {
			$idCounter = IdCounter::find(1);
			$gameCodeSeed = $idCounter->game_code_seed;
			$idCounter->game_code_seed = $gameCodeSeed + 1;
			$idCounter->save();

			$gamePro = new GameProfile;
			$gamePro->profile_type = 'anonymous';
			$gamePro->user_id = 0;
			$gamePro->student_id = ZapZapHelper::GenerateGameCode($gameCodeSeed);
			$gamePro->first_name = "Anonymous";
			$gamePro->nickname1 = 999;
			$gamePro->nickname2 = 999;
			$gamePro->avatar_id = 999;
			$gamePro->seed = $gameCodeSeed;
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

	public function GenerateAnonymousStudentId() {

		try {

			$newProfile = ApiProfileHelper::newProfile('0', '0', 'Anonymous', '5_or_younger' , 'default school' , 'K' , 999 , 999 , 999 , '');

			return ResponseHelper::OutputJSON('success', '', ['student_id' => $newProfile['student_id'] ]);

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
			$verifyHelper = ApiProfileHelper::verifyTransfer($deviceGameCode, $currentGameCode);

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

	public function verifyCodeV1_3() {
		$studentIdExisted = Request::input('student_id'); //game in device
		$studentIdEnter = Request::input('student_id_enter'); //game new key in

		if (!$studentIdEnter) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		$deviceProfile = GameProfile::where('student_id', $studentIdExisted);
		if (!$deviceProfile) {
			return ResponseHelper::OutputJSON('fail', 'anonymous profile no found');
		}

		$profile = GameProfile::find('student_id' , $studentIdEnter);
		if (!$profile) {
			return ResponseHelper::OutputJSON('fail', 'profile no found');
		}

		try {
			$verifyHelper = ApiProfileHelper::verifyTransfer($deviceProfile, $profile);

			if(!$verifyHelper){
				return ResponseHelper::OutputJSON('fail', 'verify error');
			}

			return ResponseHelper::OutputJSON('success', '' , [
				'device_student_id' => $studentIdExisted,
				'enter_student_id' => $studentIdEnter,
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
			$verifyHelper = ApiProfileHelper::verifyTransfer($deviceGameCode, $currentGameCode);

			if($verifyHelper['profile_transfer']){
				$gamePlay = GamePlay::where('code', $gameCodeExisted)->update([
					'type' => 'signed_up_profile',
					'code' => $gameCodeEnter,
					'user_id' => $profile->user_id,
					'profile_id' => $profile->id,
					'device_id' => $currentGameCode->device_id
					]);

				$gameUserMap = UserMap::where('profile_id', $deviceProfile->id)->update(['profile_id' => $profile->id]);
				
				$profile->grade = $deviceProfile->grade;
				$profile->nickname1 = $deviceProfile->nickname1;
				$profile->nickname2 = $deviceProfile->nickname2;
				$profile->avatar_id = $deviceProfile->avatar_id;
				$profile->coin += $deviceProfile->avatar_id;
				$profile->played = 1;
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

	public function profileTransferV1_3() {
		$studentIdExisted = Request::input('student_id'); //game in device
		$studentIdEnter = Request::input('student_id_enter'); //game new key in

		if (!$studentIdEnter) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		$deviceProfile = GameProfile::where('student_id' , $studentIdExisted);
		if (!$deviceProfile) {
			return ResponseHelper::OutputJSON('fail', 'anonymous profile no found');
		}

		$profile = GameProfile::where('student_id' , $studentIdEnter);
		if (!$profile) {
			return ResponseHelper::OutputJSON('fail', 'profile no found');
		}

		try {
			$verifyHelper = ApiProfileHelper::verifyTransfer($deviceProfile, $profile);

			if($verifyHelper['profile_transfer']){
				$gamePlay = GamePlay::where('code', $studentIdExisted)->update([
					'type' => 'signed_up_profile',
					'code' => $studentIdEnter,
					'user_id' => $profile->user_id,
					'profile_id' => $profile->id,
					]);

				$gameUserMap = UserMap::where('profile_id', $deviceProfile->id)->update(['profile_id' => $profile->id]);
				
				$profile->grade = $deviceProfile->grade;
				$profile->nickname1 = $deviceProfile->nickname1;
				$profile->nickname2 = $deviceProfile->nickname2;
				$profile->avatar_id = $deviceProfile->avatar_id;
				$profile->coin += $deviceProfile->avatar_id;
				$profile->played = 1;
				$profile->save();

				SpaceshipUser::where('profile_id' , $deviceProfile->id)->update([
					'user_id' => $profile->user_id,
					'profile_id' => $profile->id
					]);

				GameCoinTransaction::where('profile_id', $deviceProfile->id)->update([
					'profile_id' => $profile->id
					]);

				GameMission::where('profile_id', $deviceProfile->id)->update([
					'profile_id' => $profile->id
					]);

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

			$gPlay = GamePlay::where('code', $gameCodeExisted)->first();
			if($gPlay){
				$gamePlay = GamePlay::where('code', $gameCodeExisted)->update([
				'type' => 'signed_up_profile',
				'code' => $gameCodeEnter,
				'user_id' => $profile->user_id,
				'profile_id' => $profile->id,
				'device_id' => $currentGameCode->device_id
				]);
			}
			
			$gUserMap = UserMap::where('profile_id', $deviceProfile->id)->first();
			if($gUserMap){
				$gameUserMap = UserMap::where('profile_id', $deviceProfile->id)->update(['profile_id' => $profile->id]);
			}

			$profile->grade = $deviceProfile->grade;
			$profile->nickname1 = $deviceProfile->nickname1;
			$profile->nickname2 = $deviceProfile->nickname2;
			$profile->avatar_id = $deviceProfile->avatar_id;
			$profile->coin += $deviceProfile->coin;
			$profile->played = 1;
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

	public function profileTransferLooseV1_3() {
		$studentIdExisted = Request::input('student_id'); //game in device
		$studentIdEnter = Request::input('student_id_enter'); //game new key in

		if (!$studentIdEnter) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		$deviceProfile = GameProfile::where('student_id' , $studentIdExisted)->first();
		if (!$deviceProfile) {
			return ResponseHelper::OutputJSON('fail', 'anonymous profile no found');
		}

		$profile = GameProfile::where('student_id' , $studentIdEnter)->first();
		if (!$profile) {
			return ResponseHelper::OutputJSON('fail', 'profile no found');
		}

		if($deviceProfile->profile_type != 'anonymous' || $profile->profile_type != 'signed_up_profile'){
			return ResponseHelper::OutputJSON('fail', 'profile transfer is not allow on the inputs given');
		}

		try {

			$gPlay = GamePlay::where('code', $studentIdExisted)->first();
			if($gPlay){
				$gamePlay = GamePlay::where('code', $studentIdExisted)->update([
				'type' => 'signed_up_profile',
				'code' => $studentIdEnter,
				'user_id' => $profile->user_id,
				'profile_id' => $profile->id,
				]);
			}
			
			$gUserMap = UserMap::where('profile_id', $deviceProfile->id)->first();
			if($gUserMap){
				$gameUserMap = UserMap::where('profile_id', $deviceProfile->id)->update(['profile_id' => $profile->id]);
			}

			$profile->grade = $deviceProfile->grade;
			$profile->nickname1 = $deviceProfile->nickname1;
			$profile->nickname2 = $deviceProfile->nickname2;
			$profile->avatar_id = $deviceProfile->avatar_id;
			$profile->coin += $deviceProfile->coin;
			$profile->played = 1;
			$profile->save();

			SpaceshipUserSpaceship::where('profile_id' , $deviceProfile->id)->update([
				'user_id' => $profile->user_id,
				'profile_id' => $profile->id
				]);

			SpaceshipUserFloor::where('profile_id' , $deviceProfile->id)->update([
				'user_id' => $profile->user_id,
				'profile_id' => $profile->id
				]);

			SpaceshipUserItem::where('profile_id' , $deviceProfile->id)->update([
				'user_id' => $profile->user_id,
				'profile_id' => $profile->id
				]);

			GameCoinTransaction::where('profile_id', $deviceProfile->id)->update([
				'profile_id' => $profile->id
				]);

			GameMission::where('profile_id', $deviceProfile->id)->update([
				'profile_id' => $profile->id
				]);

			return ResponseHelper::OutputJSON('success');
			
		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > profileTransfer',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function createBulk() {
		$userId = Request::input('user_id');
		$classId = Request::input('class_id' , 0);
		$age = Request::input('age');
		$school = Request::input('school');
		$grade = Request::input('grade');

		DB::beginTransaction();
		try {

			if (!$school || !$age || !$grade) {
				return ResponseHelper::OutputJSON('fail', "missing parameters");
			}

			$gameClass = GameClass::find($classId);

			if(!$gameClass || $gameClass->user_id != $userId) {
				return ResponseHelper::OutputJSON('fail', "class not found");
			}
			
			$userFlag = UserFlag::find($userId);
			if(!$userFlag){
				return ResponseHelper::OutputJSON('fail', "user flag not found");
			}
			$filename = join('.', [$userId , date("YmdHis")] );
			$storage = new \Upload\Storage\FileSystem( '../resources/upload/create-student-bulk/' , true); //neeed update
			$uploadFile = new \Upload\File('file', $storage);
			$uploadFile->setName($filename);	
			$uploadFile->upload();

			$file = '../resources/upload/create-student-bulk/'.$filename.'.xlsx'; //set path //need update

			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			if (!$objReader->canRead($file)) {
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				if (!$objReader->canRead($file)) {
					unlink($file);
					return Libraries\ResponseHelper::OutputJSON('fail', "invalid file type");
				}
			}

		    $objPHPExcel = $objReader->load($file);
			$sheet = $objPHPExcel->getSheet(0); 
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = $sheet->getHighestColumn();
			
			// loop: validate @start
			$studentIds = [];
			$firstNames = [];
			for ($i= 2; $i<= $highestRow; $i++){ 

				$rowData = $sheet->rangeToArray('A' . $i . ':' . $highestColumn . $i , NULL , TRUE, FALSE);
			    $rowData = array_map('array_filter', $rowData);


			    $validateValue = array_merge($rowData[0] , [0,0]);	

			    if(!$validateValue[0] && !$validateValue[1] ){
					continue;
				}

				if(!$validateValue[0] || !$validateValue[1] ){
					unlink($file);
					return ResponseHelper::OutputJSON('fail', 'incomplete info');
				}

				$studentId = $rowData[0][0];
			   	$firstName = $rowData[0][1];

			   	if(in_array($studentId, $studentIds, true)){
					unlink($file);
					return ResponseHelper::OutputJSON('fail', 'student id duplicate');
			    }

			    //  Read a row of data into an array
			    $data = $sheet->rangeToArray('A' . $i . ':' . $highestColumn . $highestRow , NULL , TRUE, FALSE);
			    $data = array_map('array_filter', $data);
 				$data = array_filter($data);

			  	$profileCount = GameProfile::where('class_id', $classId)->where('user_id', $userId)->count();
				$profileLimit = ($gameClass->expired_at > date("Y-m-d H:i:s"))?50:30;

				if( ($profileCount + count($data)) > $profileLimit){
					unlink($file);
					return ResponseHelper::OutputJSON('fail', "class limited" , [
						'remain' => ($profileLimit - $profileCount),
						'upload' => count($data),
						]);
				}

			  	array_push($studentIds, $studentId);
			  	array_push($firstNames, $firstName);

			}

			if(!$studentIds && !$firstNames ){
				unlink($file);
				return ResponseHelper::OutputJSON('fail', 'no profile in upload file');
			}

			$sql = "
				SELECT `student_id`
					FROM `t0111_game_profile` 
						WHERE `student_id` IN('".join("','", $studentIds)."')	
				UNION 
				SELECT `student_id`
					FROM `t9103_student_id_change` 
						WHERE `student_id` IN('".join("','", $studentIds)."')	
			";

			$result = DB::SELECT($sql);

			if($result){
				unlink($file);
				return ResponseHelper::OutputJSON('fail', 'student id has been used', $result);
			}
			// loop: validate @end
		
			// loop: create	@start	
			for ($i= 2; $i<= $highestRow; $i++){ 
			    //  Read a row of data into an array
			    $rowData = $sheet->rangeToArray('A' . $i . ':' . $highestColumn . $i , NULL , TRUE, FALSE);
			  
			   	if(!$rowData[0][0] || !$rowData[0][1]){
			   		continue;
			   	}

			   	$studentId = $rowData[0][0];
			   	$firstName = $rowData[0][1];

				ApiProfileHelper::newProfile($userId, $classId, $firstName, $age, $school, $grade , 999 , 999 , 999 ,$studentId );
			}
			// loop: create	@end

			DB::commit();
			unlink($file);

			return ResponseHelper::OutputJSON('success');


		} catch (Exception $ex) {
			DB::rollback();
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiProfileController > createMultipleProfile',
				'inputs' => \Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}
}
