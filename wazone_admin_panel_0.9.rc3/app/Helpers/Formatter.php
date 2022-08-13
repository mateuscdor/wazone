<?php

namespace App\Helpers;

class Formatter {

    public static function pf($phone) {
        $phoneWa = preg_replace('/\D/', '', $phone);

        if (substr($phoneWa, 0, 2) == '08') {
            $phoneWa = substr_replace($phoneWa, '', 0, 1);
            $phoneWa = substr_replace($phoneWa, '62', 0, 0);
        } else if (substr($phoneWa, 0, 4) == '6208') {
            $phoneWa = substr_replace($phoneWa, '', 2, 1);
        } else if (substr($phoneWa, 0, 2) == '52' && substr($phoneWa, 2, 1) != '1') {
            $phoneWa = substr_replace($phoneWa, '1', 2, 0);
        } else if (substr($phoneWa, 0, 2) == '54' && substr($phoneWa, 2, 1) != '9') {
            $phoneWa = substr_replace($phoneWa, '9', 2, 0);
        } else if (substr($phoneWa, 0, 2) == '55' && strlen($phoneWa) === 13) {
            $ddd = substr($phoneWa, 2, 2);
            if ($ddd != '11' && $ddd != '12' && $ddd != '13' && $ddd != '14' && $ddd != '15' &&
                $ddd != '16' && $ddd != '17' && $ddd != '18' && $ddd != '19' && $ddd != '21' &&
                $ddd != '22' && $ddd != '24' && $ddd != '27' && $ddd != '28' && $ddd != '29') 
            {
                // $phoneWa = substr_replace($phoneWa, '', 4, 1);
                $phoneWa = '55' . $ddd . substr($phoneWa, -8);
            }
        }
        return $phoneWa;
    }

    public static function s_wa($phone) {
        return Self::pf($phone) . '@s.whatsapp.net';
    }

    public static function g_us($phone) {
        return Self::pf($phone) . '@g.us';
    }

    public static function c_us($phone) {
        return Self::pf($phone) . '@c.us';
    }
}
?>