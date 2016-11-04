<?php

namespace App\Libraries;

class ZapZapHelper {

    public static function GenerateGameCode($seed) {
        $seed = intval($seed);

        $n1 = (floor($seed / pow(36, 6))) % 36;
        $n2 = (floor($seed / pow(36, 5))) % 36;
        $n3 = (floor($seed / pow(36, 4))) % 36;
        $n4 = (floor($seed / pow(36, 3))) % 36;
        $n5 = (floor($seed / pow(36, 2))) % 36;
        $n6 = (floor($seed / pow(36, 1))) % 36;
        $n7 = (floor($seed / pow(36, 0))) % 36;

        $oddSum = ($n1 + $n3 + $n5 + $n7) * 3;
        $evenSum = ($n2 + $n4 + $n6);
        $checkDigit = 36 - (($oddSum + $evenSum) % 36);
        $checkDigit = $checkDigit % 36;

        $c1 = ($n1 < 10) ? $n1 : chr($n1 + 87);
        $c2 = ($n2 < 10) ? $n2 : chr($n2 + 87);
        $c3 = ($n3 < 10) ? $n3 : chr($n3 + 87);
        $c4 = ($n4 < 10) ? $n4 : chr($n4 + 87);
        $c5 = ($n5 < 10) ? $n5 : chr($n5 + 87);
        $c6 = ($n6 < 10) ? $n6 : chr($n6 + 87);
        $c7 = ($n7 < 10) ? $n7 : chr($n7 + 87);
        $c8 = ($checkDigit < 10) ? $checkDigit : chr($checkDigit + 87);

        return $c1 . $c2 . $c3 . $c4 . $c5 . $c6 . $c7 . $c8;
    }

    public static function ValidateGameCode($code) {

        if (!preg_match('/^\w{8}$/', $code)) {
            return false;
        }

        $n1 = (preg_match('/^\d{1}$/', $code[0])) ? intval($code[0]) : (ord($code[0]) - 87);
        $n2 = (preg_match('/^\d{1}$/', $code[1])) ? intval($code[1]) : (ord($code[1]) - 87);
        $n3 = (preg_match('/^\d{1}$/', $code[2])) ? intval($code[2]) : (ord($code[2]) - 87);
        $n4 = (preg_match('/^\d{1}$/', $code[3])) ? intval($code[3]) : (ord($code[3]) - 87);
        $n5 = (preg_match('/^\d{1}$/', $code[4])) ? intval($code[4]) : (ord($code[4]) - 87);
        $n6 = (preg_match('/^\d{1}$/', $code[5])) ? intval($code[5]) : (ord($code[5]) - 87);
        $n7 = (preg_match('/^\d{1}$/', $code[6])) ? intval($code[6]) : (ord($code[6]) - 87);
        $n8 = (preg_match('/^\d{1}$/', $code[7])) ? intval($code[7]) : (ord($code[7]) - 87);

        $oddSum = ($n1 + $n3 + $n5 + $n7) * 3;
        $evenSum = ($n2 + $n4 + $n6);
        $checkDigit = 36 - (($oddSum + $evenSum) % 36);
        $checkDigit = $checkDigit % 36;

        return ($n8 == $checkDigit);
    }

    public static function TestCheckDigit() {
        $seed = rand(1, 10000000000);
        $code = ZapZapHelper::GenerateGameCode($seed);
        echo ZapZapHelper::ValidateGameCode($code);
    }

}
