<?php namespace App\Http\Middleware;

use Closure;
use Request;
use Session;
use App\Libraries\ResponseHelper;

class CmdMiddleware{

    public function handle($request, Closure $next)
    {	
		// $cmd = Session::get('cmd-request');
		$cmd = \Request::input('cmd');
		
        $response = $next($request);
       
      	// $response = json_decode($response->content(), true);

      	// if($cmd){
      	// 	$response['cmd'] = $cmd;
      	// }

        return $response;
    }
}