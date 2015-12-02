<?php namespace App\Http\Controllers;

use App;
use DB;
use Exception;
use Config;
use Request;

use App\Models;
use App\Models\User;
use App\Models\UserAccess;

use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\AuthHelper;
use App\Libraries\ResponseHelper;


Class ApiHealthMetricController extends Controller {

	public function UserHealthMetric(){
		// try {
			$userId = Request::input('user_id');
			$medicalMetricId = Request::input('medical_metric_id');

			if(!$userId || !$medicalMetricId){
				return ResponseHelper::OutputJSON('fail' , 'missing parameter');
			}

			$sqlDelete = "
				DELETE FROM `t0103_user_health_metric` WHERE `user_id` = :user_id
			";
			$delete = DB::delete($sqlDelete ,  ['user_id' => $userId] );

			for($i=0; $i<count($medicalMetricId); $i++){
				$m = $medicalMetricId[$i];

				$userHealthMetric = new UserHealthMetric;
				$userHealthMetric->user_id = $userId;
				$userHealthMetric->medical_metric_id = $m;
				$userHealthMetric->save();

		// } catch (Exception $ex) {
		// 	LogHelper::LogToDatabase('TransactionController@createDebt', ['environment' => json_encode([
		// 		'message' => $ex->getMessage(),
		// 		'inputs' => Request::all(),
		// 	])]);
		// 	return ResponseHelper::OutputJSON('exception');
		// }
	}
}

