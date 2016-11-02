<?php

namespace App\Http\Middleware;

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
        $route = $request->route();

        $accessToken = (!$accessToken) ? Request::header('X-access-token') : $accessToken;
        $accessToken = (!$accessToken) ? Request::cookie('access_token') : $accessToken;
        $accessToken = (!$accessToken) ? Session::get('access_token') : $accessToken;

        if (!$accessToken) {
            return Libraries\ResponseHelper::OutputJSON('fail-unauthorised', 'missing access token');
        }

        $adminAccess = Models\AdminAccess::where('access_token', $accessToken)->whereRaw('access_token_expired_at > NOW()')->first();
        if (!$adminAccess) {
            return Libraries\ResponseHelper::OutputJSON('fail-unauthorised', 'invalid access token');
        }

        $admin = Models\User::find($adminAccess->user_id);

        if (!$admin || ($admin->role != $route->role)) {
            return Libraries\ResponseHelper::OutputJSON('fail-unauthorised', 'user not found: ' . $adminAccess->user_id);
        }

        $inputs = \Request::all();
        $inputs['user_id'] = $admin->id;
        $inputs['user_name'] = $admin->name;
        $inputs['user_role'] = $admin->role;

        \Request::replace($inputs);

        return $next($request);
    }

}
