<?php namespace App\Http\Controllers;

use Config;
use Cookie;
use DB;
use Exception;
use Redirect;
use Request;
use Session;
use Socialite;
use Auth;
use Schoology;

use App\Libraries\AuthHelper;
use App\Libraries\DatabaseUtilHelper;
use App\Libraries\EmailHelper;
use App\Libraries\LogHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\ApiUserHelper;
use App\Libraries\ApiProfileHelper;
use App\Models\GameCode;
use App\Models\GameClass;
use App\Models\GameProfile;
use App\Models\IdCounter;
use App\Models\LogAccountActivate;
use App\Models\LogPasswordReset;
use App\Models\LogSignInUser;
use App\Models\User;
use App\Models\UserAccess;
use App\Models\UserExternalId;
use App\Models\UserSetting;
use Sendinblue\Mailin;

Class AuthSchoologyController extends Controller {

	public function schoology() {
	
		$url = Schoology::authorize();	
		$firstLogin = 0;

		if(Auth::check()){
			$schoologyUser = Auth::user();
			
			$userExternalId = UserExternalId::where('schoology_id' , $schoologyUser['original']['id'])->first();

			if($userExternalId){
				
				$user = User::select('id','role', 'name', 'register_from')->find($userExternalId->user_id);
				$userAccess = UserAccess::where('user_id' , $userExternalId->user_id)->first();

				if($userAccess->access_token == '') {
					$accessToken = AuthHelper::GenerateAccessToken($userAccess->user_id);
					$userAccess->access_token = $accessToken;
					$userAccess->access_token_issue_at = DB::Raw('NOW()');
					$userAccess->access_token_issue_ip = Request::ip();
				} else {
					$accessToken = $userAccess->access_token;
				}

				$userAccess->access_token_expired_at = DB::Raw('DATE_ADD(NOW(), INTERVAL 10 YEAR)');
				$userAccess->save();

				$checkFirstLogin = LogSignInUser::where('username' , $userAccess->username)->where('success' , 1)->first();

				if(!$checkFirstLogin){
					$firstLogin = 1;
				}

				$cookie = Cookie::make('access_token', $userAccess->access_token);

				$log = new LogSignInUser;
				$log->username = $userAccess->username;
				$log->password_sha1 = '';
				$log->success = 1;
				$log->created_ip = Request::ip();
				$log->save();

				setcookie("current_user", json_encode(['user' => $user, 'first_time_login' => $firstLogin]), 0, "/");
				return redirect(url(env('WEBSITE_URL').'/user/auth-redirect'))->withCookie($cookie);
			}

			//check email didnt use
			$userAccess = UserAccess::where('username' , $schoologyUser['original']['email'])->first();

			if(!$userAccess){
				setcookie("current_user", json_encode(['name' => $schoologyUser['original']['name'] , 'email' => $schoologyUser['original']['email'] , 'schoology_id' => $schoologyUser['original']['id']]), 0, "/");

				return redirect(url(env('WEBSITE_URL').'/user/redirect-signup/schoology'));
			}

			//sync account
			$user = User::select('id' , 'role', 'name', 'register_from')->find($userAccess->user_id);
			$userExternalId = UserExternalId::where('user_id' , $userAccess->user_id)->update(['schoology_id' => $schoologyUser['original']['id'] ]);
			$checkFirstLogin = LogSignInUser::where('username' , $userAccess->username)->where('success' , 1)->first();

			if(!$checkFirstLogin){
				$firstLogin = 1;
			}

			$cookie = Cookie::make('access_token', $userAccess->access_token);

			$log = new LogSignInUser;
			$log->username = $userAccess->username;
			$log->password_sha1 = '';
			$log->success = 1;
			$log->created_ip = Request::ip();
			$log->save();

			setcookie("current_user", json_encode(['user' => $user, 'first_time_login' => $firstLogin]), 0, "/");
			return redirect(url(env('WEBSITE_URL').'/user/auth-redirect'))->withCookie($cookie);
		}else{
			return redirect($url);
		}
	}

	public function schoologySignUp(){
        $name = Request::input('name');
        $email = Request::input('email');
        $schoology_id = Request::input('schoology_id');
        $country = Request::input('country');

        $newUser = ApiUserHelper::Register('teacher' , $name , $email , $country , $schoology_id , '' , 'schoology');
        $newProfile = ApiProfileHelper::newProfile($newUser['user_id'] , $newUser['class_id']  , '' , '5_or_younger' , 'default school' , 'preschool' , '', 999 , 999 , 999);

        $user = User::select('id' , 'role', 'name' ,'register_from')->find($newUser['user_id']);
        $userExternalId = UserExternalId::where('user_id' , $newUser['user_id'])->update(['schoology_id' => $schoology_id ]);
        $userAccess = UserAccess::where('user_id' , $user->id)->first();

        $firstLogin = 1;

        $mailin = new Mailin("https://api.sendinblue.com/v2.0","AC0B8IKZ2nw64hSW");
		$data = ["email" => $email,
		        "attributes" => ["NAME"=>$name, "SURNAME"=>""],
		        "listid" => [Config::get('app.send_in_blue_list_id')],
		        "listid_unlink" => []
		    ];

		$mailin->create_update_user($data);

        $cookie = Cookie::make('access_token', $userAccess->access_token);

        $log = new LogSignInUser;
        $log->username = $userAccess->username;
        $log->password_sha1 = '';
        $log->success = 1;
        $log->created_ip = Request::ip();
        $log->save();

        return ResponseHelper::OutputJSON('success', '', ['user' => $user], [
            'X-access-token' => $userAccess->access_token,
        ], [
            'access_token' => $userAccess->access_token,
        ]);

    }

}

