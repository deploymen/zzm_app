<?php

namespace App\Http\Middleware;

use App\Libraries\ResponseHelper;
use App\Models\GameProfile;
use App\Models\StudentIdChange;
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
        $inputs = \Request::all();

        if (!$studentId) {
            return ResponseHelper::OutputJSON('fail-unauthorised', 'missing student id');
        }

        $studentIdObj = GameProfile::where('student_id', $studentId)->first();

        if (!$studentIdObj) {
            $studentIdObj = StudentIdChange::where('student_id', $studentId)->first();

            if (!$studentIdObj) {
                return ResponseHelper::OutputJSON('fail-unauthorised', 'invalid student id');
            }

            $inputs['cmd'] = [
                'name' => 'replace_student_id',
                'param' => [
                    'student_id_from' => $studentId,
                    'student_id_to' => $studentIdObj->profile->student_id,
                ]
            ];

            $inputs['student_id'] = $studentIdObj->profile->student_id;
            $inputs['student_profile_type'] = $studentIdObj->profile->profile_type;
            $inputs['user_id'] = $studentIdObj->profile->user_id;
            $inputs['student_profile_id'] = $studentIdObj->profile->id;
        } else {
            $inputs['student_id'] = $studentIdObj->student_id;
            $inputs['student_profile_type'] = $studentIdObj->profile_type;
            $inputs['user_id'] = $studentIdObj->user_id;
            $inputs['student_profile_id'] = $studentIdObj->id;
        }



        Request::replace($inputs);

        return $next($request);
    }

}
