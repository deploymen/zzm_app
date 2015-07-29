<?php namespace App\Http\Controllers;

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

use App\Models\GameProfile;
use App\Models\Age;
use App\Models\Grade;


Class PageController extends Controller {

	public function editProfile($id) {
		
		$userId = Request::input('user_id');
	 
		try {

			$profile = GameProfile::select('id','user_id', 'class_id', 'first_name' , 'last_name','age', 'school' ,'grade','city','email','nickname1','nickname2','avatar_id')->find($id);
			$age = Age::select('age','age_name')->get();
			$grade = Grade::select('grade', 'grade_name')->get();

			if(!$profile){
				return ResponseHelper::OutputJSON('fail', 'profile not found');
			}
			$profile->nickName1;
			$profile->nickName2;
			$profile->avatar;
			$profile->gameCode;

			if($userId != $profile->user_id){
				return ResponseHelper::OutputJSON('fail','wrong user id');
			}			
			// return ResponseHelper::OutputJSON('success','',[
			// 	'profile'=>$profile,
			// 	'age' => $age,
			// 	'grade' => $grade

			// 	]);
			return view('contents.website.edit', [
				'profile'=>$profile,
				'age' => $age,
				'grade' => $grade
				]);

		} catch (\Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}

	public function resultProfile($id) {
		
		$userId = Request::input('user_id');
	 
		try {

			$profile = GameProfile::select('id','user_id', 'class_id', 'first_name' , 'last_name', 'school' ,'city','email','nickname1','nickname2','avatar_id')->find($id);

			if(!$profile){
				return ResponseHelper::OutputJSON('fail', 'profile not found');
			}

			$profile->avatar;
			$profile->gameCode;

			if($userId != $profile->user_id){
				return ResponseHelper::OutputJSON('fail','wrong user id');
			}			

			return view('contents.website.profile-results', ['profile'=>$profile]);

		} catch (\Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}
} 
