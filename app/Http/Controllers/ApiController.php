<?php namespace App\Http\Controllers;

use App;
use Exception;
use PDOException;
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

use App\Models;
use App\Models\Subscribe;

class ApiController extends Controller {



	public function subscribe($source = 'pre-launch')
	{

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

	public function subscribeExternal()
	{
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
	
	
}
