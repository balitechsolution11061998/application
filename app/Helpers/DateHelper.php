<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function formatDate($dateString)
    {
        if ($dateString) {
            $date = Carbon::parse($dateString);
            return $date->day . ' ' . [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ][$date->month] . ' ' . $date->year;
        }
        return '';
    }
}
