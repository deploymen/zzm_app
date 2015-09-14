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

			$list = GameClass::select('user_id', 'name')
			->where('user_id', $userId)->get();

			return ResponseHelper::OutputJSON('success', '', ['list' => $list->toArray()]);

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

			DatabaseUtilHelper::LogInsert($gameClass->id, $gameClass->table, $gameClass->id);

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}

		return ResponseHelper::OutputJSON('success');
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
			$wiped = [];
		
			if($userId == $gameClass->user_id){

				$wiped['name'] = $gameClass->name;
				$gameClass->name = $className;
				
				$gameClass->save();

				DatabaseUtilHelper::LogUpdate($userId, $gameClass->table, $userId, json_encode($wiped));

				return ResponseHelper::OutputJSON('success', '', $gameClass->toArray());
			}

			return ResponseHelper::OutputJSON('fail','wrong user id');

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

	public function addProfile($id) {

		$userId = Request::input('user_id');

		try{
			$profileId = Request::input('profile_id');

				if(!$profileId) {
					return ResponseHelper::OutputJSON('fail', "missing parameters");
				}

			$profile = GameProfile::find($profileId);

				if(!$profile) {
					return ResponseHelper::OutputJSON('fail', "profile not found");
				}
			
			$classId = GameClass::find($id);
				if(!$classId) {
					return ResponseHelper::OutputJSON('fail', "class not found");
				}
			if($userId == $profile->user_id){	
				$profile->class_id = $id;
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