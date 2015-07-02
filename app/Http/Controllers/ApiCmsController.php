<?php namespace App\Http\Controllers;

use App\Models;
use App\Models\Flag;
use App\Libraries;
use App\Libraries\ResponseHelper;
use Request;

Class ApiCmsController extends Controller {

	public function getFlag() {

		$key = Request::input('key');

		// if(!$key){
		$flag = Flag::find(1)->toArray(); 

		if($key && isset($flag[$key])){
			return ResponseHelper::OutputJSON('success', '', [
				$key => $flag[$key]
			]);
		}else{
			$arrFlag = [];
			foreach ($flag as $k => $v) {
				if($k == 'id'){ continue; }
				$arrFlag[$k] = $v;
			  
			}	
			return ResponseHelper::OutputJSON('success', '', $arrFlag);
		}
	}
}