<?php namespace App\Http\Middleware;

use App;
use App\Libraries\ResponseHelper;
use App\Models\GameCode;
use App\Models\GameProfile;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Request;
use Session;

class AuthenticateGamePlay {

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

		$gameCode = Request::cookie('game-code');
		$gameCode = (!$gameCode) ? Session::get('game-code') : $gameCode;
		$gameCode = (!$gameCode) ? Request::header('X-game-code') : $gameCode;

		if (!$gameCode) {
			return ResponseHelper::OutputJSON('fail-unauthorised', 'missing game code');
		}

		$gameCodeObj = GameCode::where('code', $gameCode)->first();

		if (!$gameCodeObj) {
			return ResponseHelper::OutputJSON('fail-unauthorised', 'invalid game code');
		}

		$inputs = \Request::all();
		$inputs['game_code'] = $gameCode;
		$inputs['game_code_type'] = $gameCodeObj->type;

		$userId = GameProfile::find($gameCodeObj->profile_id);
		if (!$userId) {
			return ResponseHelper::OutputJSON('fail-unauthorised', 'invalid game code');
		}
		$inputs['user_id'] = $userId->user_id;

		$inputs['game_code_profile_id'] = $gameCodeObj->profile_id;

		Request::replace($inputs);

		return $next($request);
	}

}
