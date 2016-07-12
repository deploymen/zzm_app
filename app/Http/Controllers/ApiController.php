<?php namespace App\Http\Controllers;

use App;
use Exception;
use PDOException;
use Config;
use Request;
use DB;
use Session;
use App\Libraries;
use App\Libraries\LogHelper;
use App\Libraries\AuthHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\EmailHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\DatabaseUtilHelper;
use Sendinblue\Mailin;

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
				SELECT p.`profile_id`, pr.`first_name` , pr.`last_name`, c.`code`,SEC_TO_TIME(SUM(p.`played_time`)) AS `total_played`, count(DISTINCT  DATE_FORMAT(p.`created_at`,'%m-%d-%Y')) AS `days` , count(r.`id`) AS `total_answered` , ((count(r2.`correct`) / count(r.`id`)) * 100) AS `percentage`
					FROM `t0400_game_play` p, `t0111_game_profile` pr, `t0113_game_code` c, `t0300_game_result` r 
					LEFT JOIN `t0300_game_result` r2 ON r2.`id` = r.`id` AND r2.`correct` = 1
						WHERE p.`user_id` = {$e->id}
						AND r.`play_id` = p.`id`
						AND p.`created_at` > (NOW() - INTERVAL 7 DAY)
						AND pr.`id` = p.`profile_id`
						AND pr.`deleted_at` IS NULL
						AND c.`profile_id` = pr.`id`
						GROUP BY p.`profile_id`

			";

			$results = DB::SELECT($sql);

			if(!$results){
				continue;
			}

			$edmHtml = (string) view('emails.weekly-report', [ 
				'results' => $results,
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

		if(!$request->emails){
			return ResponseHelper::OutputJSON('fail', 'missing parameter');
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return ResponseHelper::OutputJSON('fail', "invalid email format");
		}

		for($i=0; $i<count($request->emails); $i++){
			$email = $request->emails[$i];

			$edmHtml = (string) view('emails.teacher-invite', [ 
				'app_store_address' => config('app.app_store_url'),
				'username' => $email,
				'zapzapmath_portal' => config('app.website_url') . '/user/sign-in',
				'email_support' => config('app.support_email'),
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
		}

		return ResponseHelper::OutputJSON('success');
	}

	public function SendInBlue(){
		$mailin = new Mailin("https://api.sendinblue.com/v2.0","AC0B8IKZ2nw64hSW");
	
	    $data = array( "email" => "example@example.com",
	        "attributes" => ["NAME"=>"wz test", "SURNAME"=>""],
	        "listid" => [6],
	        "listid_unlink" => []
	    );

	    var_export($mailin->create_update_user($data));
	}
	
}
