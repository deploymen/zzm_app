<?php namespace App\Http\Middleware;

use Closure;
use Request;
use Session;
use App\Libraries\ResponseHelper;

class AfterMiddleware{

    public function handle($request, Closure $next)
    {	
    	$studentId = Request::cookie('student-id');
		$studentId = (!$studentId) ? Session::get('student-id') : $studentId;
		$studentId = (!$studentId) ? Request::header('X-student-id') : $studentId;

        $response = $next($request);
      	$response = json_decode($response->content(), true);

      	// if(config::get('app.server_maintenance')){
      	// 	return ResponseHelper::OutputJSON('fail' , 'server maintenance');
      	// }

      	// if(){ // check student_id change
      		$response['cmd'] = [
	      		'name' => 'replace_student_id',
	      		'param' => [
	      			'student_id_from' => '123',
	      			'student_id_to' => '345',
	      		]
	      	];
      	// }

        return $response;
    }
}