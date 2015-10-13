<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use App;
use Session;
use Request;
use Redirect;
use App\Libraries\LogHelper;
use App\Libraries\AuthHelper;
use App\Libraries\ZapZapHelper;
use App\Libraries\EmailHelper;
use App\Libraries\ResponseHelper;
use App\Libraries\DatabaseUtilHelper;

use App\Models;
use App\Models\GameCode;
use App\Models\GameProfile;



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
		dd($request->path());
		$isApi = (strpos($request->path(), 'api/') !== FALSE);
		$route = $request->route();

		$gameCode = Request::cookie('game-code');
		$gameCode = (!$gameCode)?Session::get('game-code'):$gameCode;
		$gameCode = (!$gameCode)?Request::header('X-game-code'):$gameCode;


		if (!$gameCode) {
			if ($isApi) {
				return ResponseHelper::OutputJSON('fail', 'missing game code');
			} else {
				return Redirect::to('/?missing-game-code');
			}
		}

		$gameCodeObj = GameCode::where('code' , $gameCode)->first();


		if(!$gameCodeObj){
			if ($isApi) {
				return ResponseHelper::OutputJSON('fail', 'invalid game code');
			} else {
				return Redirect::to('/?invalid-code');
			}
		}
		$inputs = \Request::all();
		$inputs['game_code'] = $gameCode;
		$inputs['game_code_type'] = $gameCodeObj->type;
	
		$userId = GameProfile::find($gameCodeObj->profile_id);
		if(!$userId){
			if ($isApi) {
				return ResponseHelper::OutputJSON('fail', 'invalid game code');
			} else {
				return Redirect::to('/?invalid-game-code');
			}					
		}
		$inputs['user_id'] = $userId->user_id;

		$inputs['game_code_profile_id'] = $gameCodeObj->profile_id;
				
		Request::replace($inputs);


		return $next($request);
	}

}
