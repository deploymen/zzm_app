<?php namespace App\Http\Controllers;

use App;
use Exception;
use PDOException;
use Config;
use Request;
use DB;
use Session;
use PHPExcel;
use PHPExcel_IOFactory;
use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\AuthHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\EmailHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\DatabaseUtilHelper;

use App\Models;
use App\Models\Subscribe;
use App\Models\LaunchNotification;
use App\Models\AppVersion;
use App\Models\User;
use App\Models\GameProfile;

class ApiController extends Controller {

	public function subscribe($source = 'pre-launch'){

		$email = Request::input("email");
		$ip = Request::ip();
		$secret = 'SAK6B2WE8688VT69G9DZ';

		$emails =  Subscribe::where('email' , $email)->first();


		if (!$email) {
			return ResponseHelper::OutputJSON('fail', "missing parameters");
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ResponseHelper::OutputJSON('fail', "invalid email format");
		}

		if($emails){
				return ResponseHelper::OutputJSON('fail', "no double subscribe");
		}

		try {

			$res = file_get_contents("http://api.apigurus.com/iplocation/v1.8/locateip?key={$secret}&ip={$ip}&format=json&compact=y");			
			$ipDetail = json_decode($res, true);


			$subscribe = new Subscribe;
			$subscribe->email = $email;
			$subscribe->ip = $ip;
			if(isset($ipDetail['geolocation_data']))
			{ 
				$geolocationData = $ipDetail['geolocation_data'];
				$subscribe->ip_detail = json_encode($geolocationData );
				$subscribe->ip_country = $geolocationData['country_name'];
	
			}
			$subscribe->source = $source;			
			$subscribe->save();
			DatabaseUtilHelper::LogInsert(0, 't0101_subscribe', $subscribe->id);

			if($source == 'pre-launch' || $source == 'mathexpression'){
				$secretKey = sha1(time() . $email);

					$edmHtml = (string) view('emails.prelaunch-thank-you', [
						'social_media_links' => Config::get('app.fanpage_url')
					]);

					EmailHelper::SendEmail([
						'about' => 'Welcome',
						'subject' => 'The Mathventure Begins Here!',
						'body' => $edmHtml,
						'bodyHtml' => $edmHtml,
						'toAddresses' => [$email],
					]);
			}
			

		} catch (PDOException $ex) {
			if ($ex->errorInfo[1] == 1062) {
				return ResponseHelper::OutputJSON('exception');
			}else{
			 	throw $ex;			 	
			}
		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment'=>json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}		


		return ResponseHelper::OutputJSON('success');
	}

	public function subscribeExternal(){
		$source = Request::input('source', 'unknown');
		$callback = Request::input('callback', 'welldone');
		$this->subscribe($source);

		$response = "{$callback}('welldone');";
		die($response); 
	}

	public function contactUs(){

		$email = Request::input("email");
		$message = Request::input("message");

		if (!$email || !$message) {
			return ResponseHelper::OutputJSON('fail', "missing parameters");
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ResponseHelper::OutputJSON('fail', "invalid email format");
		}

		try {
			$contactUs = new ModelsContactUs;
			$contactUs->email = $email;
			$contactUs->message = $message;

			$contactUs->save();
			DatabaseUtilHelper::LogInsert(0, 't0102_contact_us', $contactUs->id);

			//send email?

		} catch (PDOException $ex) {
			if ($ex->errorInfo[1] == 1062) {
				return ResponseHelper::OutputJSON('exception');
			}else{
			 	throw $ex;			 	
			}
		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment'=>json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}	

		return ResponseHelper::OutputJSON('success');
	}
	
	public function launchNotification(){
		$email = Request::input("email");
		$newsLetter = Request::input("news_letter");
		$launchNotified = Request::input("launch_notified");

		$ip = Request::ip();
		$secret = 'SAK6B2WE8688VT69G9DZ';

		try {

			if (!$email) {
				return ResponseHelper::OutputJSON('fail', "missing parameter");
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return ResponseHelper::OutputJSON('fail', "invalid email format");
			}

			$emails =  LaunchNotification::where('email' , $email)->first();

			if(!$emails){
				$emails = new LaunchNotification;
				$emails->email = $email;

				$res = file_get_contents("http://api.apigurus.com/iplocation/v1.8/locateip?key={$secret}&ip={$ip}&format=json&compact=y");			
				$ipDetail = json_decode($res, true);

				$emails->ip = $ip;
				if(isset($ipDetail['geolocation_data']))
				{ 
					$geolocationData = $ipDetail['geolocation_data'];
					$emails->ip_detail = json_encode($geolocationData );
					$emails->ip_country = $geolocationData['country_name'];
				}
			}

			if($newsLetter){
				$emails->news_letter = $newsLetter;
			}

			if($launchNotified){
				$emails->launch_notified = $launchNotified;
			}
		
			$emails->save();

			DatabaseUtilHelper::LogInsert(0, 't0101_launch_notification', $emails->id);

			return ResponseHelper::OutputJSON('success');

		} catch (Exception $ex) {
			LogHelper::LogToDatabase($ex->getMessage(), ['environment'=>json_encode([
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}		
	}

	public function getVersion(){
		$deviceOs = Request::input('device_os');
		$osVersion = Request::input('os_version');
		$zzmVersion = Request::input('zzm_version');

		if(!$deviceOs || !$zzmVersion || !$osVersion){
			return ResponseHelper::OutputJSON('fail', 'missing parameter');
		}

		$appVersion = AppVersion::where('device_os', $deviceOs)->where('zzm_version' , $zzmVersion)->first();
		if(!$appVersion){
			return ResponseHelper::OutputJSON('fail', 'version not found');
		}

		return ResponseHelper::OutputJSON('success', '' , [
			'device_os' => $deviceOs,
			'zzm_version' => $zzmVersion,
			'api_version' => $appVersion->api_version,
			]);
	}

	public function weeklyReport(){
		$email = User::where('activated', 1)->select('id' , 'role', 'email')->get();

		for($j=0; $j<count($email); $j++){
			$e = $email[$j];
			$mail = $email[$j]->email;

			if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
				continue;
			}

			if($e->role == 'parent'){
				$profile = GameProfile::where('user_id' , $e->id);

				if(count($profile) == 1){
					$coc = 'child';
				}else{
					$coc = 'children';
				}

			}else{
				$coc = 'class';
			}

			$sql = "
				SELECT SEC_TO_TIME(SUM(p.`played_time`)) AS `total_played`, count(DISTINCT  DATE_FORMAT(p.`created_at`,'%m-%d-%Y')) AS `days` , count(r.`id`) AS `total_answered` , ((count(r2.`correct`) / count(r.`id`)) * 100) AS `percentage`
					FROM `t0400_game_play` p, `t0300_game_result` r 
					LEFT JOIN `t0300_game_result` r2 ON r2.`id` = r.`id` AND r2.`correct` = 1
						WHERE p.`user_id` = {$e->id}
						AND r.`play_id` = p.`id`
						AND p.`created_at` > (NOW() - INTERVAL 7 DAY)
						GROUP BY `user_id`

			";

			$results = DB::SELECT($sql);

			if(!$results){
				continue;
			}

			$result = $results[0];

			$time = explode(':' , $result->total_played);
			$percentage = explode('.', $result->percentage);

			$edmHtml = (string) view('emails.weekly-report', [ 
				'coc' => $coc,
				'hour' => $time[0],
				'minute' => $time[1],
				'days' => $result->days,
				'total_answered' => $result->total_answered,
				'percentage' => $percentage[0],
				'zapzapmath_portal' => config('app.website_url') . '/user/sign-in',
				'zzm_url' => config('app.website_url'),
				'social_media_links' => config('app.fanpage_url'),
			]);

			EmailHelper::SendEmail([
				'about' => 'Zap Zap Math',
				'subject' => 'Weekly Report',
				'body' => $edmHtml,
				'bodyHtml' => $edmHtml,
				'toAddresses' => [$mail],
			]);
		}

		return ResponseHelper::OutputJSON('success');
		
	}

	public function InviteTeacher(\Illuminate\Http\Request $request){
		$userId = Request::input('user_id');
		$userEmail = Request::input('user_email');

		$success = 0; //temporory 
		if(!$request->emails){ //need update validation
			return ResponseHelper::OutputJSON('fail', 'missing parameter');
		}

		$user = User::find($userId);

		for($j=0; $j<count($request->emails); $j++){
			$email = $request->emails[$j];

			if(!$email){
				return ResponseHelper::OutputJSON('fail','missing parameter');
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return ResponseHelper::OutputJSON('fail','invalid email format');
			}

			$uEmail = explode('@' , $userEmail);
			$domain = explode('@' , $email);

			if($uEmail[1] != $domain[1]){
				return ResponseHelper::OutputJSON('fail','invalid email domain');
			}
		}

		for($i=0; $i<count($request->emails); $i++){
			$email = $request->emails[$i];
		
			$edmHtml = (string) view('emails.teacher-invite', [ 
				'name' => $user->name,
				'zzm_url' => config('app.website_url'),
				'social_media_links' => config('app.fanpage_url'),
			]);

			EmailHelper::SendEmail([
				'about' => 'Zap Zap Math',
				'subject' => 'Assist our school to get Zap Zap Math for free!',
				'body' => $edmHtml,
				'bodyHtml' => $edmHtml,
				'toAddresses' => [$email],
			]);

			$success = $success+1;
		}

		return ResponseHelper::OutputJSON('success','' , ['sent' => $success]);

	}

	public function MostActiveList() {

		try{
			$today = date("m-d-y");
			$sql = "
				SELECT u.`role` , u.`name` , u.`city` AS `user_city` , u.`email` , p.`code` , pr.`id` AS `profile_id` , pr.`first_name` , pr.`age`, pr.`school`, pr.`grade`, pr.`city` AS `profile_city`, pr.`country` , count(p.`id`) AS `rount_play`
					FROM `t0400_game_play` p , `t0101_user` u , `t0111_game_profile` pr
				    	WHERE p.`created_at` > (NOW() - INTERVAL 7 DAY)
				        	AND p.`user_id` = u.`id`
				            AND p.`profile_id` = pr.`id`
				        GROUP BY p.`code`
				        ORDER BY `rount_play` DESC
				        LIMIT 50
			";

			$results = DB::SELECT($sql);

			$objPHPExcel = new PHPExcel(); 
			$objPHPExcel->setActiveSheetIndex(0); 
		
			$rowCount = 1; 
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,'role');
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,'user name');
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'city');
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'e-mail');
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,'status');
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,'game-code');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,'profile id');
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,'student name');
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,'age');
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,'school');
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount,'grade');
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,'city');
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,'country');
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,'round of games played');
			
			
			for($i=0; $i<count($results); $i++){
				$da = $results[$i];

				$objPHPExcel->getActiveSheet()->setCellValue('A'.(2+$i), $da->role);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.(2+$i), $da->name);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.(2+$i), $da->user_city);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.(2+$i), $da->email);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.(2+$i), $da->code);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.(2+$i), $da->profile_id);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.(2+$i), $da->first_name);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.(2+$i), $da->age);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.(2+$i), $da->school);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.(2+$i), $da->grade);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.(2+$i), $da->profile_city);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.(2+$i), $da->country);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.(2+$i), $da->rount_play);
	
			}
				

			$obj_Writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$obj_Writer->save('/var/www/weekly-report/'.$today.'.xlsx');
	
			return Libraries\ResponseHelper::OutputJSON('success');
		} catch (\Exception $ex) {
			Libraries\LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'inputs' => \Request::all(),
			])]);
			return Libraries\ResponseHelper::OutputJSON('exception');
		}	
	}
}
