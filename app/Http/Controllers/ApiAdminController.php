<?php

namespace App\Http\Controllers;

use App\Models\LogPaypalTransaction;
use App\Libraries\ResponseHelper;
use Request;
use Exception;

Class ApiAdminController extends Controller {

    public function getTransaction() {

        try {

            // $ips = [
            // 	'52.76.40.203', //www-1
            // 	'52.2.173.202', //www-2
            // 	'52.8.88.160', //www-3
            // 	'54.169.146.122', //dev
            // 	'115.133.102.188' //hakim
            // ];			
            // $ip = Request::ip();
            // if(!in_array($ip , $ips, true) ) {
            // 	return ResponseHelper::OutputJSON('fail', 'access denied' , [$ip]);
            // }

            $transaction = LogPaypalTransaction::GetTransactionDetail();

            return ResponseHelper::OutputJSON('success', '', $transaction);
        } catch (Exception $ex) {

            LogHelper::LogToDatabase($ex->getMessage(), ['environment' => json_encode([
                    'source' => 'ApiAdminController > getTransaction',
                    'inputs' => Request::all(),
            ])]);
            return ResponseHelper::OutputJSON('exception');
        }
    }

}
