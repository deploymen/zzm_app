<?php namespace App\Http\Controllers;

use App;
use App\Libraries\ApiProfileHelper;
use App\Libraries\DatabaseUtilHelper;
use App\Libraries\LogHelper;
use App\Libraries\ReportProfileHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\ZapZapHelper;
use App\Models\AvatarSet;
use App\Models\GameCode;
use App\Models\GamePlanet;
use App\Models\GamePlay;
use App\Models\GameProfile;
use App\Models\IdCounter;
use App\Models\SetNickname1;
use App\Models\SetNickname2;
use App\Models\UserMap;
use DB;
use Exception;
use Request;

Class ApiProfileController extends Controller {

	// =======================================================================//
	// ! Parent | Teacher												      //
	// =======================================================================//
	public function get() {
		$userId = Request::input('user_id');
		$profileInfo = [];
		try {
			$profiles = GameProfile::select('id', 'user_id', 'class_id', 'first_name', 'last_name', 'age', 'school', 'grade', 'city', 'email', 'nickname1', 'nickname2', 'avatar_id')->where('user_id', $userId)->orderBy('id')->get();

			foreach ($profiles as $profile) {
				$profile->nickName1;
				$profile->nickName2;
				$profile->avatar;
				$profile->gameCode;
			}

			$sql = "
				 SELECT profile.`id` , play.`created_at`, count(result.`id`) AS `questions_played` ,play.`score`
		    		FROM `t0111_game_profile` profile
						LEFT JOIN `t0400_game_play` play ON (play.`profile_id` = profile.`id` AND play.`user_id` = {$userId} )
						LEFT JOIN `t0400_game_play` play2 ON (play2.`profile_id` = profile.`id` AND play2.`user_id` = {$userId} AND play2.`created_at` > play.`created_at`)

						LEFT JOIN `t0400_game_play` play_all ON (play_all.`profile_id` = profile.`id` AND play_all.`user_id` = {$userId})
						LEFT JOIN `t0300_game_result` result ON (play_all.`id` = result.`play_id` AND result.`target_type` = play_all.`target_type`)
				    		WHERE profile.`deleted_at` IS NULL
				    		AND play2.`id` IS NULL
				    		AND profile.`user_id` = {$userId}

		    					GROUP BY profile.`id`
			";

			$lastPlayed = DB::select($sql);
			for ($i = 0; $i < count($profiles); $i++) {
				$p = $profiles[$i];
				$lp = $lastPlayed[$i];

				array_push($profileInfo, [
					'id' => $p->id,
					'user_id' => $p->user_id,
					'class_id' => $p->class_id,
					'first_name' => $p->first_name,
					'last_name' => $p->last_name,
					'age' => $p->age,
					'school' => $p->school,
					'grade' => $p->grade,
					'city' => $p->city,
					'email' => $p->email,
					'questions_played' => $lp->questions_played,
					'nickname1' => $p->nickname1,
					'nickname2' => $p->nickname2,
					'avatar_id' => $p->avatar_id,
					'nick_name1' => $p->nickName1,
					'nick_name2' => $p->nickName2,
					'avatar' => $p->avatar,
					'game_code' => $p->gameCode,
					'last_played' => $lp->created_at,

				]);

			}

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
		$city = Request::input('city');
		$email = Request::input('email', '');

		$nickname1 = Request::input('nickname1', 1);
		$nickname2 = Request::input('nickname2', 1);
		$avatarId = Request::input('avatar_id', 1);

		if (!$firstName || !$school || !$city || !$age || !$grade) {
			return ResponseHelper::OutputJSON('fail', "missing parameters");
		}

		if ($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ResponseHelper::OutputJSON('fail', "invalid email format");
		}

		try {

			$nickname_1 = SetNickname1::find($nickname1);
			$nickname_2 = SetNickname2::find($nickname2);
			$avatarIdSet = AvatarSet::find($avatarId);

			if (!$nickname_1) {
				return ResponseHelper::OutputJSON('fail', "invalid nickname id");
			}

			if (!$nickname_2) {
				return ResponseHelper::OutputJSON('fail', "invalid nickname id");
			}

			if (!$avatarId) {
				return ResponseHelper::OutputJSON('fail', "invalid avatar id");
			}

			$profile = new GameProfile;
			$profile->user_id = $userId;
			$profile->first_name = $firstName;
			$profile->last_name = $lastName;
			$profile->age = $age;
			$profile->school = $school;
			$profile->grade = $grade;
			$profile->city = $city;
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
			$code->type = 'profile';
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
		$city = Request::input('city');
		$email = Request::input('email');
		$nickname1 = Request::input('nickname1');
		$nickname2 = Request::input('nickname2');
		$avatarId = Request::input('avatar_id');
		$classId = Request::input('class_id');

		try {
			$wiped = [];

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
				$wiped['first_name'] = $profile->first_name;
				$profile->first_name = $firstName;
			}

			if ($lastName) {
				$wiped['last_name'] = $profile->last_name;
				$profile->last_name = $lastName;
			}

			if ($age) {
				$wiped['age'] = $profile->age;
				$profile->age = $age;
			}

			if ($school) {
				$wiped['school'] = $profile->school;
				$profile->school = $school;
			}

			if ($grade) {
				$wiped['grade'] = $profile->grade;
				$profile->grade = $grade;
			}

			if ($city) {
				$wiped['city'] = $profile->city;
				$profile->city = $city;
			}

			if ($email) {
				$wiped['email'] = $profile->email;
				$profile->email = $email;
			}

			if ($classId) {
				$wiped['class_id'] = $profile->class_id;
				$profile->class_id = $classId;
			}

			if ($nickname1) {
				$nicknameSet = SetNickname1::find($nickname1);
				if (!$nicknameSet) {
					return ResponseHelper::OutputJSON('fail', "nickname not found");
				}
				$wiped['nickname1'] = $profile->nickname1;
				$profile->nickname1 = $nickname1;
			}

			if ($nickname2) {
				$nicknameSet = SetNickname2::find($nickname2);
				if (!$nicknameSet) {
					return ResponseHelper::OutputJSON('fail', "nickname not found");
				}
				$wiped['nickname2'] = $profile->nickname2;
				$profile->nickname2 = $nickname2;
			}

			if ($avatarId) {
				$avatarSet = AvatarSet::find($avatarId);
				if (!$avatarSet) {
					return ResponseHelper::OutputJSON('fail', "avatar not found");
				}
				$wiped['avatar_id'] = $profile->avatar_id;
				$profile->avatar_id = $avatarId;
			}

			$profile->save();

			DatabaseUtilHelper::LogUpdate($userId, $profile->table, $userId, json_encode($wiped));
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
			$count = GameProfile::where('user_id', $userId)->count();

			if (!$profile) {
				return ResponseHelper::OutputJSON('fail', "profile not found");
			}

			if ($userId != $profile->user_id) {
				return ResponseHelper::OutputJSON('fail', 'wrong user id');
			}

			if ($count == 1) {
				return ResponseHelper::OutputJSON('fail', 'account must have at least one profile');
			}

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

			$profile = GameProfile::select('id', 'user_id', 'class_id', 'first_name', 'last_name', 'age', 'school', 'grade', 'city', 'email', 'nickname1', 'nickname2', 'avatar_id')->find($id);

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

		try {
			$wiped = [];
			// if(!$userId){
			// 	return ResponseHelper::OutputJSON('fail','wrong user id');
			// }

			$profile = GameProfile::find($profileId);
			if (!$profile) {
				return ResponseHelper::OutputJSON('fail', "profile not found");
			}

			if ($nickname1) {
				$nicknameSet = SetNickname1::find($nickname1);
				if (!$nicknameSet) {
					return ResponseHelper::OutputJSON('fail', "nickname not found");
				}
				$wiped['nickname1'] = $profile->nickname1;
				$profile->nickname1 = $nickname1;
			}

			if ($nickname2) {
				$nicknameSet = SetNickname2::find($nickname2);
				if (!$nicknameSet) {
					return ResponseHelper::OutputJSON('fail', "nickname not found");
				}
				$wiped['nickname2'] = $profile->nickname2;
				$profile->nickname2 = $nickname2;
			}

			if ($avatarId) {
				$avatarSet = AvatarSet::find($avatarId);
				if (!$avatarSet) {
					return ResponseHelper::OutputJSON('fail', "avatar not found");
				}
				$wiped['avatar_id'] = $profile->avatar_id;
				$profile->avatar_id = $avatarId;
			}

			$profile->save();

			DatabaseUtilHelper::LogUpdate($userId, $profile->table, $userId, json_encode($wiped));
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
			$gamePro->first_name = "anonymous";
			$gamePro->last_name = "anonymous";
			$gamePro->nickname1 = 1;
			$gamePro->nickname2 = 1;
			$gamePro->avatar_id = 1;
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
		$code = Request::input('game_code');
		$anonymousCode = Request::input('game_code_anonymous');

		if (!$code) {
			return ResponseHelper::OutputJSON('fail', 'missing parameters');
		}

		try {
			$gameCode = GameCode::where('code', $code)->first();
			if (!$gameCode) {
				return ResponseHelper::OutputJSON('fail', 'game code no found');
			}
			$anonymousGameCode = GameCode::where('code', $anonymousCode)->first();
			if (!$anonymousGameCode) {
				return ResponseHelper::OutputJSON('fail', 'anonymous game code no found');
			}

			$profile = GameProfile::find($gameCode->profile_id);
			if (!$profile) {
				return ResponseHelper::OutputJSON('fail', 'profile no found');
			}

			$anonymousProfile = GameProfile::find($anonymousGameCode->profile_id);

			if (!$anonymousProfile) {
				return ResponseHelper::OutputJSON('fail', 'anonymous profile no found');
			}

			//if new game code no record , and anonymous gt record
			if (!$gameCode->played && $anonymousGameCode->played) {
				//show hight score
				$sql = "
					SELECT MAX(`top_score`) AS `top_score` , MAX(`star`) AS `star`
						FROM t0501_game_user_map
							WHERE `profile_id` = :profile_id
				";
				$questions = \DB::SELECT($sql, ['profile_id' => $anonymousGameCode->profile_id]);
				return ResponseHelper::OutputJSON('success', '', [
					'profile_transfer' => '1',
					'profile_anonymous' => [
						'id' => $anonymousProfile->id,
						'user_id' => $anonymousProfile->user_id,
						'class_id' => $anonymousProfile->class_id,
						'first_name' => $anonymousProfile->first_name,
						'last_name' => $anonymousProfile->last_name,
						'school' => $anonymousProfile->school,
						'city' => $anonymousProfile->city,
						'email' => $anonymousProfile->email,
						'nickname1' => $anonymousProfile->nickname1,
						'nickname2' => $anonymousProfile->nickname2,
						'avatar_id' => $anonymousProfile->avatar_id,
						'top_score' => $questions[0]->top_score,
						'star' => $questions[0]->star,
					],
				]);
			}

			// direct play
			return ResponseHelper::OutputJSON('success', '', [
				'profile_transfer' => '0',
				'profile' => $profile,
				'profile_anonymous' => [],
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
		$code = Request::input('game_code');
		$anonymousCode = Request::input('game_code_anonymous');

		try {
			$gameCode = GameCode::where('code', $code)->first();
			$anonymousGameCode = GameCode::where('code', $anonymousCode)->first();

			$profile = GameProfile::find($gameCode->profile_id);
			if (!$profile) {
				return ResponseHelper::OutputJSON('fail', 'profile no found');
			}

			$anonymousProfile = GameProfile::find($anonymousGameCode->profile_id);
			if (!$anonymousProfile) {
				return ResponseHelper::OutputJSON('fail', 'profile no found');
			}
			if (!$gameCode->played && $anonymousGameCode->played) {
				$gamePlay = GamePlay::where('profile_id', $anonymousGameCode->profile_id)->update([
					'type' => 'profile',
					'user_id' => $profile->user_id,
					'profile_id' => $gameCode->profile_id,
					'code' => $code,
				]);

				//update all the record to same value
				$userMap = UserMap::where('profile_id', $anonymousGameCode->profile_id)->update([
					'profile_id' => $gameCode->profile_id,
				]);

				$gameCode->played = '1';
				$gameCode->save();
				$anonymousGameCode->played = '0';
				$anonymousGameCode->save();

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

}
