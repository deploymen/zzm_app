<?php

namespace App\Http\Controllers;
use App\Libraries\ResponseHelper;
use Aws\CloudFront\Exception\Exception;
use Request;
use App\Http\Controllers\Controller;
use App\Models\Voucher\Voucher;
use App\Models\GameClass;
use App\Models\UserSubsTransaction;

class VoucherController extends Controller
{
    public function redeem(){

        $class_id = Request::input('class_id');
        $code = Request::input('code');

        try{
            $checkVoucher = Voucher::where('code', $code)->first();
            $checkClass = GameClass::where('id', $class_id)->first();

            /**
             * Check if voucher code is valid
             */
            if ( $checkVoucher ) {

                /**
                 * Check if class exist
                 */
                if( !$checkClass ) {
                    return ResponseHelper::OutputJSON('fail', '', 'Invalid Class ID');
                }

                /**
                 * Check if Voucher has not been used
                 */
                if ($checkVoucher->status == 1) {
                    return ResponseHelper::OutputJSON('fail', '',"Voucher already used");
                }


                /**
                 * Update Voucher table
                 */
                $checkVoucher->status = 1;
                $checkVoucher->user_id = $checkClass->user_id;
                $checkVoucher->class_id = $checkClass->id;

                /**
                 * Upgrade class to premium
                 */
                if ($checkVoucher->save()) {
                    $expired_date = date('Y-m-d H:i:s', strtotime('+1 year'));
                    $checkClass->expired_at = $expired_date;

                    /**
                     * log transaction
                     */
                    if ( $checkClass->save() ) {
                        $log_sub = new UserSubsTransaction();

                        $log_sub->user_id = $checkClass->user_id;
                        $log_sub->package_id = "2016-nov-conf";
                        $log_sub->target_type = "class";
                        $log_sub->target_id = $checkClass->id;
                        $log_sub->expired_at = $expired_date;

                       if ( $log_sub->save() ) {
                           return ResponseHelper::OutputJSON('success', '', "Profile upgraded to premium");
                       }
                    }
                }

            }else{
                return ResponseHelper::OutputJSON('fail', '','Invalid Voucher');
            }

        }catch (Exception $ex){
            return ResponseHelper::OutputJSON('fail', '', 'exception');
        }

        return ResponseHelper::OutputJSON('fail', '','Unknown Error');
    }
}
