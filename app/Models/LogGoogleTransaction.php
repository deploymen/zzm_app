<?php

namespace App\Models;

use App\Libraries\ResponseHelper;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Google_Client;
use Google_Auth_AssertionCredentials;
use Google_Service_AndroidPublisher;
use DB;

use App\Models\GameProfile;
use App\Models\UserSubsTransaction;

class LogGoogleTransaction extends Eloquent {

    public $table = 't9208_log_google_transaction';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = [];

    protected $fillable = [
                            'user_id', 'profile_id', 'package_name', 'subscription_id', 'token',
                            'kind', 'priceCurrencyCode', 'priceAmountMicros', 'countryCode',
                            'paymentState', 'autoRenewing', 'startTimeMillis', 'expiryTimeMillis',
                            'cancelReason', 'expired_at'
                          ];

    public function studentId() {
        return $this->hasOne('App\Models\GameProfile', 'id', 'profile_id');
    }

    public static function logTransaction($profile_id, array $package, $subscription_data){

        $expiryTimeMillis = $subscription_data['expiryTimeMillis'] / 1000;
        $expiry_time_millis_date = date("Y-m-d H:i:s", $expiryTimeMillis);

        $current = new \DateTime("now");
        $time_from_google = new \DateTime($expiry_time_millis_date);

        $interval = $current->diff($time_from_google);
        $day = $interval->format('%a');

        $expiring_date = $interval->format("INTERVAL {$day} DAY");

        $game_profile = GameProfile::find($profile_id);

        /**
         * Update user expiring date and log receipt
         */
        if ($game_profile) {

            $expiredAt = $expiry_time_millis_date;

            if($game_profile->expired_at > date("Y-m-d H:i:s") ){
                $expiredAt = DB::raw('DATE_ADD("'.$game_profile->expired_at.'", '.$expiring_date.')');
            }

            $game_profile->expired_at = $expiredAt;
            $game_profile->save();

            if (array_key_exists('cancelReason', $subscription_data)){
                $cancelReason = $package['cancelReason'];
            }else{
                $cancelReason = 2;
            }

            LogGoogleTransaction::updateOrCreate([
                'user_id' => $game_profile->user_id, 'profile_id' => $profile_id,
                'package_name' => $package['package_name'], 'subscription_id' => $package['subscription_id'],
                'token' => $package['token'], 'kind' =>  $subscription_data['kind'],
                'priceCurrencyCode' => $subscription_data['priceCurrencyCode'],
                'priceAmountMicros' => $subscription_data['priceAmountMicros'], 'countryCode' => $subscription_data['countryCode'],
                'paymentState' => intval($subscription_data['paymentState']), 'autoRenewing' => $subscription_data['autoRenewing'],
                'startTimeMillis' => $subscription_data['startTimeMillis'], 'expiryTimeMillis' => $subscription_data['expiryTimeMillis'],
                'cancelReason' => $cancelReason, 'expired_at' => $expiry_time_millis_date
            ]);

            UserSubsTransaction::create([
                'user_id' => $game_profile->user_id,
                'package_id' => 'google-in-app-yearly-profile-upgrade-4.99',
                'target_type' => 'profile',
                'target_id' => $profile_id,
                'expired_at' => $expiredAt,
            ]);

            return true;
        }
        return false;
    }



    public static function updateSubscription()
    {

        $client = new Google_Client();
        $client->setApplicationName("Zap Zap Math - K6 Math Games");
        $service_key = file_get_contents($_ENV['GOOGLE_KEY_PATH']);
        $service_id = config('app.google_api_service_id');

        $credentials = new Google_Auth_AssertionCredentials(
            $service_id, ['https://www.googleapis.com/auth/androidpublisher'], $service_key
        );

        $client->setAssertionCredentials($credentials);

        /**
         * instantiate a new Android Publisher service class
         */
        $service = new Google_Service_AndroidPublisher($client);

        $transactions = LogGoogleTransaction::where('expired_at', '<>', '')->get();
        foreach ( $transactions as $transaction ) {

            $user_id = $transaction->user_id;
            $package_name = $transaction->package_name;
            $token = $transaction->token;
            $profile_id = $transaction->profile_id;
            $subscription_id = $transaction->subscription_id;
            $expiryTimeMillis = $transaction->expiryTimeMillis;

            /**
             * get the subscription info info from google
             */
            $subscription = $service->purchases_subscriptions->get($package_name, $subscription_id, $token);

            if (!is_null($subscription)) {

                if (isset($subscription->expiryTimeMillis)) {
                    $seconds_from_db = $expiryTimeMillis / 1000; //Stored milliseconds
                    $seconds_from_request = $subscription->expiryTimeMillis / 1000; //returned milliseconds

                    $old_date = date("Y-m-d H:i:s", $seconds_from_db); //old expire date
                    $returned_seconds_date = date("Y-m-d H:i:s", $seconds_from_request); // new expiring date

                    /**
                     * if new expiring date is greater than old update DB
                     */

                    if (intval($subscription['paymentState']) === 1) {

                        if (strtotime($returned_seconds_date) > strtotime($old_date) && strtotime($returned_seconds_date) >= strtotime("+12 month")){

                            $current = new \DateTime("now");
                            $time_from_google = new \DateTime($returned_seconds_date);

                            $interval = $current->diff($time_from_google);
                            $day = $interval->format('%a');

                            $expiring_date = $interval->format("INTERVAL {$day} DAY");

                            $game_profile = GameProfile::find($profile_id);

                            if ($game_profile) {

                                $expiredAt = DB::raw('DATE_ADD("'.$game_profile->expired_at.'", '.$expiring_date.')');
                                $game_profile->expired_at = $expiredAt;
                                $game_profile->save();

                                UserSubsTransaction::where('user_id', $user_id)
                                    ->where('target_id', $profile_id)
                                    ->update(['expired_at' => $expiredAt]);

                                $transaction->expired_at = $returned_seconds_date;
                                $transaction->expiryTimeMillis = $seconds_from_request;
                                $transaction->paymentState = intval($subscription['paymentState']);
                                $transaction->autoRenewing = $subscription['autoRenewing'];
                                isset($subscription['cancelReason']) ? $transaction->cancelReason = $subscription['cancelReason'] : $transaction->cancelReason = 2;
                                $transaction->save();

                                return true;
                            }

                        }
                    }
                    //end update db
                }
            }

        }

        return null;
    }

}
