<?php

namespace App\Manager;

final class CalendarManager
{
    public function getMaxWeeksAmountFromDaysMatrix($daysMatrix): int
    {
        $maxWeeks = 6;
        $index = 35;
        $found = false;
        while (!$found && $index < 42) {
            if (isset($daysMatrix[$index])) {
                $found = true;
            }
            ++$index;
        }
        if (false === $found) {
            $maxWeeks = 5;
        }

        return $maxWeeks;
    }
}
