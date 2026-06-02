<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Safely format a date - handles both string and Carbon instances
     * 
     * @param mixed $date
     * @param string $format
     * @return string
     */
    public static function safeFormat($date, $format = 'd M Y')
    {
        try {
            if ($date === null) {
                return '-';
            }

            if ($date instanceof Carbon) {
                return $date->format($format);
            }

            if (is_string($date)) {
                return Carbon::parse($date)->format($format);
            }

            return (string) $date;
        } catch (\Exception $e) {
            return '-';
        }
    }
}
