<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Libraries;
use Models;

class AuthenticateAdmin {

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
		$route = $request->route();

		if ($isApi) {
			$accessToken = \Request::header('X-access-token');
		} else {
			$accessToken = \Session::get('access_token');
		}

		if (!$accessToken) {
			if ($isApi) {
				return Libraries\ResponseHelper::OutputJSON('fail', 'missing access token');
			} else {
				return \Redirect::to('/');
			}
		}

		$adminAccess = Models\AdminAccess::where('access_token', $accessToken)->whereRaw('access_token_expired_at > NOW()')->first();
		if (!$adminAccess) {
			if ($isApi) {
				return Libraries\ResponseHelper::OutputJSON('fail', 'invalid access token');
			} else {
				return \Redirect::to('/');
			}
		}

		$admin = Models\User::find($adminAccess->user_id);

		if (!$admin || ($admin->role != $route->role)) {
			if ($isApi) {
				return Libraries\ResponseHelper::OutputJSON('fail', 'user not found: ' . $adminAccess->user_id);
			} else {
				return \Redirect::to('/');
			}
		}

		$inputs = \Request::all();
		$inputs['user_id'] = $admin->id;
		$inputs['user_name'] = $admin->name;
		$inputs['user_role'] = $admin->role;

		\Request::replace($inputs);

		return $next($request);
	}

}
