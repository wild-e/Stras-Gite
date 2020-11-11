<?php

namespace App\Model;

class BookingManager
{

    public static function setDate(string $modifier)
    {
        $date = new \DateTime();
        $date = $date->modify($modifier)->format('Y-m-d');
        return $date;
    }
}
