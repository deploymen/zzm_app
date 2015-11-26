<?php namespace App\Http\Controllers;

use App;
use Exception;
use Config;
use Request;
use App\Models;
use App\Models\GameProfile;
use App\Models\GameClass;
use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\ResponseHelper;


Class ApiClassController extends Controller {

	public function get() {

		try {
			$userId = Request::input('user_id');
			$GameClass = GameClass::where('user_id', $userId)->get();

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
			$className = Request::input('class_name');

			if (!$className || !$userId) {
				return ResponseHelper::OutputJSON('fail', "missing parameters");
			}

			$gameClass = new GameClass;
			$gameClass->user_id = $userId;
			$gameClass->name = $className;
			$gameClass->save();

			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}

	}

	public function update($id) {
		try {
			$userId = Request::input('user_id');
			$className = Request::input('class_name');

			if(!$className){
				return ResponseHelper::OutputJSON('fail', "missing parameters");
			}
			
			$gameClass = GameClass::find($id);
			if(!$gameClass){
				return ResponseHelper::OutputJSON('fail', "class not found");
			}
		
			if(!$gameClass->user_id == $userId){
				return ResponseHelper::OutputJSON('fail', "user id not math");
			}

			$gameClass->name = $className;
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

	public function removeProfile($id) {

		
		$userId = Request::input('user_id');

		try{

			$profile = GameProfile::find($id);

				if(!$profile) {
					return ResponseHelper::OutputJSON('fail', "profile not found");
				}
			
			if($userId == $profile->user_id){	
				$profile->class_id = 0;
				$profile->save();

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

}