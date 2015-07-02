<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Libraries;
use Models;

class AuthenticateTeacher {

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

		$role = \Request::input('user_role');

		switch ($role) {
			case 'teacher':break;
			default:
				if ($isApi) {
					 return Libraries\ResponseHelper::OutputJSON('fail', "invalid role");
				} else {
					return \Redirect::to('/user/signin?no-access');
				}
		}

		return $next($request);
	}

}
