<?php namespace App\Http\Middleware;

use App;
use App\Libraries\ResponseHelper;
use App\Models\GameCode;
use App\Models\GameProfile;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Request;
use Session;

class AuthenticateStudent {

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
		$route = $request->route();

		$studentId = Request::cookie('student-id');
		$studentId = (!$studentId) ? Session::get('student-id') : $studentId;
		$studentId = (!$studentId) ? Request::header('X-student-id') : $studentId;

		if (!$studentId) {
			return ResponseHelper::OutputJSON('fail-unauthorised', 'missing student id');
		}

		$studentIdObj = GameProfile::where('student_id', $studentId)->first();

		if (!$studentIdObj) {
			return ResponseHelper::OutputJSON('fail-unauthorised', 'invalid student id');
		}

		$inputs = \Request::all();
		$inputs['student_id'] = $studentId;
		$inputs['student_profile_type'] = $studentIdObj->type;

		$inputs['user_id'] = $studentIdObj->user_id;

		$inputs['student_profile_id'] = $studentIdObj->id;

		Request::replace($inputs);

		return $next($request);
	}

}
