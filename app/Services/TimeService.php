<?php

namespace App\Services;

class TimeService
{
    public function calculateTimeWorked($start_time, $end_time, $has_break)
    {
        list($startHours, $startMinutes) = explode(':', $start_time);
        list($endHours, $endMinutes) = explode(':', $end_time);
        $startTotalMinutes = (int)$startHours * 60 + (int)$startMinutes;
        $endTotalMinutes = (int)$endHours * 60 + (int)$endMinutes;
        $diffMinutes = $endTotalMinutes - $startTotalMinutes;
        if ($has_break) {
            $diffMinutes -= 30;
        }
        return $diffMinutes / 60.0;
    }
}
