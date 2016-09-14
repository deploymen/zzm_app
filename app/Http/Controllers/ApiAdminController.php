<?php namespace App\Http\Controllers;

use App\Models;
use App\Models\Flag;
use App\Models\LogPaypalTransaction;
use App\Libraries;
use App\Libraries\ResponseHelper;
use Request;

Class ApiAdminController extends Controller {

	public function getTransaction() {

		try{
			$ips = [
				'52.76.40.203',
				'52.2.173.202',
				'52.8.88.160',
			];

			$ip = Request::ip();

			if(!in_array($ip , $ips, true) ) {
				
				return ResponseHelper::OutputJSON('fail', 'access denied' , [$ip]);
			}

			$transaction = LogPaypalTransaction::GetTransactionDetail();

			return ResponseHelper::OutputJSON('success', '' , $transaction);

		} catch (Exception $ex) {

			LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
				'source' => 'ApiAdminController > getTransaction',
				'inputs' => Request::all(),
			])]);
			return ResponseHelper::OutputJSON('exception');
		}
	}
}