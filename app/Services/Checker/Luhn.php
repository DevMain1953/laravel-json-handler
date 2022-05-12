<?php

namespace App\Services\Checker;

/**
 * This class contains method to check number of credit card using Luhn algorithm.
 */
class Luhn
{
    /**
     * Validates the number of credit card.
     *
     * @param $digit - the number to check
     * @param $create - flag that determines the format of return value.
     * If $create is set to true, return the input + the checksum.
     * @return mixed
     */
    function check($digit, $create = false)
    {
        $segments = str_split($digit, 15);
        $digits = str_split($segments[0], 1);
        foreach ($digits as $k => $d) {
            if ($k % 2 == 0) {
                $digits[$k] *= 2;
                if (strlen($digits[$k]) > 1) {
                    $split = str_split($digits[$k]);
                    $digits[$k] = array_sum($split);
                }
            }
        }
        $digits = array_sum($digits)*9;
        $digits = str_split($digits);
        $checksum = $digits[max(array_keys($digits))];

        if ($create == false) {
            if (!isset($segments[1])) {
                return "Invalid input length.";
            }
            if ($checksum == $segments[1]) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return $segments[0].$checksum;
        }
    }
}
