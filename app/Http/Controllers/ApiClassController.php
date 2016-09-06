<?php namespace App\Http\Controllers;

use App;
use Exception;
use Config;
use App\Models;
use App\Models\GameProfile;
use App\Models\GameClass;
use App\Models\UserFlag;
use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\ApiProfileHelper;

use Validator;
use Request;

Class ApiClassController extends Controller {

	public function get() {

		try {
			$userId = Request::input('user_id');
			$GameClass = GameClass::where('user_id', $userId)->get();

			foreach ($GameClass as $class){
				$class->paid = ($class->expired_at > date("Y-m-d H:i:s"))?1:0;
			}
			return ResponseHelper::OutputJSON('success', '', ['game_class' => $GameClass]);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function create() {
		try {
			$userId = Request::input('user_id');
			$className = Request::input('name');

			$userFlag = UserFlag::find($userId);
			$userClass = GameClass::where('user_id' , $userId)->count();

			if($userClass >= $userFlag->class_limit){
				return ResponseHelper::OutputJSON('fail', "limited");
			}

			if (!$className || !$userId) {
				return ResponseHelper::OutputJSON('fail', "missing parameters");
			}

			$classN = GameClass::where('user_id' , $userId)->where('name' , $className)->first();
			if($classN){
				return ResponseHelper::OutputJSON('fail', "class name already exist");
			}

			$gameClass = new GameClass;
			$gameClass->user_id = $userId;
			$gameClass->name = $className;
			$gameClass->save();

			return ResponseHelper::OutputJSON('success', '' , $gameClass);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function update(\Illuminate\Http\Request $request , $id) {
		try {
			if(!$request->name){
				return ResponseHelper::OutputJSON('fail', "missing parameters");
			}

			$gameClass = GameClass::find($id);
			if(!$gameClass){
				return ResponseHelper::OutputJSON("fail", "class not found");
			}

			$validator = Validator::make($request->all(),  [
		        'name' => 'required|min:3|unique:t0112_game_class,name,'.$id.',id,user_id,'.$request->user_id.',deleted_at,NULL',
		    ]);

			if ($validator->fails()) {
				return ResponseHelper::OutputJSON("fail", "class name already exist");
       		}

			$gameClass->name = $request->name;
			// $gameClass->grade = $request->grade;
			// $gameClass->age = $request->age;
			$gameClass->save();

			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function delete($id) {
		$userId = Request::input('user_id');

		try {

			$gameClass = GameClass::find($id);
			if (!$gameClass) {
				return ResponseHelper::OutputJSON('fail', "class not found");
			}

			if($userId == $gameClass->user_id){
				$gameClass->delete();
				return ResponseHelper::OutputJSON('success');
			}	

			return ResponseHelper::OutputJSON('fail','wrong user id');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function addProfile() {

		$userId = Request::input('user_id');
		$profileId = Request::input('profile_id');
		$classId = Request::input('class_id');

		try{

			if(!$profileId || !$userId || !$classId) {
				return ResponseHelper::OutputJSON('fail', "missing parameters");
			}
			
			$gameClass = GameClass::find($classId);
			if(!$gameClass) {
				return ResponseHelper::OutputJSON('fail', "class not found");
			}

			$profile = GameProfile::find($profileId);
			if(!$profile->user_id == $userId) {
				return ResponseHelper::OutputJSON('fail', "profile not found");
			}

			$profile->class_id = $classId;
			$profile->save();

			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function getProfile($classId){
		$userId = Request::input('user_id');

		$gameClass = GameClass::where('id', $classId)->where('user_id' , $userId)->get();
		if(!$gameClass){
			return ResponseHelper::OutputJSON('fail', 'class not found');
		}

		$profiles = ApiProfileHelper::GetProfile($userId, $classId);

		return ResponseHelper::OutputJSON('success', '' , ['profile' => $profiles ]);
	}

	public function getGameClass($classId){
		$userId = Request::input('user_id');
		$profileLimit = 1;
		$unlock = 0;

		$class = GameClass::find($classId);
	
		$profileCount = GameProfile::where('class_id' , $classId)->where('user_id' , $userId)->count();
		$userFlag = UserFlag::find($userId);

		if(!$class){
			return ResponseHelper::OutputJSON('fail', "class no found");
		}

		$pLimit = ($class->expired_at > date("Y-m-d H:i:s"))?50:30;

		if($profileCount >= $pLimit){
			$profileLimit = 0;
		}

		if($userFlag->profile_limit == 50){
			$unlock = 1;
		}

		return ResponseHelper::OutputJSON('success', '', [ 
			'id' => $class->id,
			'user_id' => $class->user_id,
			'name' => $class->name,
			'profile_count' => $profileCount,
			'within_profile_limit' => $profileLimit,
			'unlock' => $unlock,
			'paid' => ($class->expired_at > date("Y-m-d H:i:s"))?1:0,
			]);
	}
}