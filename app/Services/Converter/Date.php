<?php

namespace App\Services\Converter;
use DateTime;

/**
 * This class contains method to convert the date.
 */
class Date
{
    /**
     * Converts the date to d-m-Y format. If the error occures, this method returns initial value.
     *
     * @param $date - the date to convert
     * @return string
     */
    public static function convert($date)
    {
        $date_time = DateTime::createFromFormat('d/m/y', '01/'.$date);
        $isInstance = $date_time instanceof DateTime;
        if (!$isInstance) {
            $res = $date;
        } else {
            $res = $date_time->format('d-m-Y');
        }
        return $res;
    }
}
