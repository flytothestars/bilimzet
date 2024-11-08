<?php namespace App\Data;

use Carbon\Carbon;

class KazMonths
{
    const NAMES = [
        'қаңтар', 'ақпан', 'наурыз', 'сәуiр', 'мамыр', 'маусым',
        'шiлде', 'тамыз', 'қыркүйек', 'қазан', 'қараша', 'желтоқсан',
    ];

    public static function getMonthName(Carbon $date)
    {
        return self::NAMES[ $date->month - 1 ];
    }
}
