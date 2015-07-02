<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Request;
use Redirect;
use Session;
use App\Libraries;
use App\Libraries\ResponseHelper;

use App\Models;
use App\Models\UserAccess;

class AuthenticateUser {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth) {
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$isApi = (strpos($request->path(), 'api/') !== FALSE);

		$accessToken = false;

		$accessToken = (!$accessToken)?Request::header('X-access-token'):$accessToken;
		$accessToken = (!$accessToken)?Request::cookie('access_token'):$accessToken;
		$accessToken = (!$accessToken)?Session::get('access_token'):$accessToken;

		if (!$accessToken) {
			if ($isApi) {
				return ResponseHelper::OutputJSON('fail', 'missing token.' ,[
					Request::cookie('access_token'),
					Session::get('access_token'),
					Request::header('X-access-token'),
				]);
			} else {
				return Redirect::to('/user/signin?no-access');
			}
		}
		
		$userAccess = UserAccess::where('access_token', $accessToken)->whereRaw('access_token_expired_at > NOW()')->first();
		if (!$userAccess) {
			if ($isApi) {
				return ResponseHelper::OutputJSON('fail', 'invalid access token');
			} else {
				return Redirect::to('/user/signin?no-access');
			}
		}

		$user = Models\User::find($userAccess->user_id);
		if (!$user) {
			if ($isApi) {
				return ResponseHelper::OutputJSON('fail', 'user not found: ' . $userAccess->user_id);
			} else {
				return Redirect::to('/user/signin?no-access');
			}
		}

		$inputs = Request::all();
		$inputs['user_id'] = $user->id;
		$inputs['user_name'] = $user->name;
		$inputs['user_role'] = $user->role;

		Request::replace($inputs);

		return $next($request);
	}

}
