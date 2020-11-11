<?php

namespace App\Model;

class BookingManager
{
    public static function reverseDate(string $date): string
    {
        $date= explode("-",$date);
        $date = array_reverse($date);
        $date = implode("-",$date);
        return $date;
    }

    public static function setDate(string $modifier)
    {
        $date = new \DateTime();
        $date = $date->modify($modifier)->format('Y-m-d');
        return $date;
    }
}
