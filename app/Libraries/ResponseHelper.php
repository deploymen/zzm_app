<?php

namespace App\Libraries;

use Response;

class ResponseHelper {

    public static function OutputJSON($status, $message = "", $data = [], $headers = [], $cookies = []) {
        $payload = array(
            'status' => $status,
        );

        $statusCode = 200;
        $ip = $_SERVER['REMOTE_ADDR'];

        if ($status == 'exception') {
            $statusCode = 500;
        }
        if ($status == 'fail-unauthorised') {
            $statusCode = 401;
            $status == 'fail';
        }

        if ($message != "") {
            $payload['message'] = $message;
        }

        if (count($data) > 0) {
            $payload['data'] = $data;
        }

        $response = response()->json($payload, $statusCode, $headers); //JSON_NUMERIC_CHECK
        //cookies
        foreach ($cookies as $key => $value) {
            $response->withCookie(cookie($key, $value, 60));
        }
        return $response;
    }

    public static function OnlyJson($data) {

        $statusCode = 200;
        $response = Response::make($data, $statusCode);
        $response->header('Content-Type', 'application/json');
        return $response;
    }

    public static function FuncReturn($status, $message = "") {
        return [
            'status' => $status,
            'message' => $message,
        ];
    }

}
