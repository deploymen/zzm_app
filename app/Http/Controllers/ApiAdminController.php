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