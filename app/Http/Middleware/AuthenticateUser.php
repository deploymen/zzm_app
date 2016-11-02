<?php

namespace App\Http\Middleware;

use App\Libraries\ResponseHelper;
use App\Models;
use App\Models\UserAccess;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Request;
use Session;

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

        $accessToken = (!$accessToken) ? Request::header('X-access-token') : $accessToken;
        $accessToken = (!$accessToken) ? Request::cookie('access_token') : $accessToken;
        $accessToken = (!$accessToken) ? Session::get('access_token') : $accessToken;

        if (!$accessToken) {
            return ResponseHelper::OutputJSON('fail-unauthorised', 'missing token.', [
                        Request::cookie('access_token'),
                        Session::get('access_token'),
                        Request::header('X-access-token'),
            ]);
        }

        $userAccess = UserAccess::where('access_token', $accessToken)->whereRaw('access_token_expired_at > NOW()')->first();
        if (!$userAccess) {
            return ResponseHelper::OutputJSON('fail-unauthorised', 'invalid access token');
        }

        $user = Models\User::find($userAccess->user_id);
        if (!$user) {
            return ResponseHelper::OutputJSON('fail-unauthorised', 'user not found: ' . $userAccess->user_id);
        }

        $inputs = Request::all();
        $inputs['user_id'] = $user->id;
        $inputs['user_name'] = $user->name;
        $inputs['user_role'] = $user->role;
        $inputs['user_email'] = $user->email;

        Request::replace($inputs);

        return $next($request);
    }

}
