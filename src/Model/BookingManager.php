<?php

namespace App\Model;

/**
 *
 */
class BookingManager
{
    public static function reverseDate(string $date): string
    {
        $date= explode("-",$date);
        $date = array_reverse($date);
        $date = implode("-",$date);
        return $date;
    }
}
