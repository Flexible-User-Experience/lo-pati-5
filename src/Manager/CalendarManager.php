<?php

namespace App\Manager;

use App\Entity\AbstractBase;
use App\Entity\Page;
use App\Repository\ConfigCalendarWorkingDayRepository;
use App\Repository\PageRepository;

final class CalendarManager
{
    private ConfigCalendarWorkingDayRepository $ccwdr;
    private PageRepository $pr;

    public function __construct(ConfigCalendarWorkingDayRepository $ccwdr, PageRepository $pr)
    {
        $this->ccwdr = $ccwdr;
        $this->pr = $pr;
    }

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

    public function getHitDaysMatrix($month, $year): array
    {
        // Marca els hits d'esdeveniments de periodes de dates i esdeveniments d'una sola data
        $pages = $this->pr->getActiveItemsFromMonthAndYear($month, $year);
        $hitsMatrix = [];
        $monthString = (string) $month;
        if ($month < 10) {
            $monthString = '0'.$monthString;
        }
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        /** @var Page $page */
        foreach ($pages as $page) {
            for ($i = 1; $i < $totalDays + 1; ++$i) {
                $dayString = (string) $i;
                if ($i < 10) {
                    $dayString = '0'.$dayString;
                }
                $currentDayString = $year.'-'.$monthString.'-'.$dayString;
                if ($page->getStartDate() && $page->getEndDate() && $currentDayString >= $page->getStartDate()->format(AbstractBase::DATABASE_IMPORT_DATE_FORMAT) && $currentDayString <= $page->getEndDate()->format(AbstractBase::DATABASE_IMPORT_DATE_FORMAT)) {
                    $iMod6 = date_format(date_create_from_format('Y-m-d', $currentDayString), 'w'); // get the number day of week (0=sunday, 1=monday .. 6=saturday)
                    $found = false;
                    foreach ($workingDays as $workingDay) {
                        if ($workingDay->getId() == $iMod6) {
                            $found = true;
                            break;
                        }
                    }
                    if ((!$item1->getAlwaysShowOnCalendar() && $found) || $item1->getAlwaysShowOnCalendar()) {
                        if ($item1->getStartDate() == $item1->getEndDate()) {
                            $hitsMatrix[$i] = 'hit-single';
                        }
                        if (isset($hitsMatrix[$i])) {
                            if ('hit-single' != $hitsMatrix[$i]) {
                                $hitsMatrix[$i] = 'hit-period';
                            }
                        } else {
                            $hitsMatrix[$i] = 'hit-period';
                        }
                    }
                }
            }
        }
    }

    public function getDaysMatrixByMonthAndYear(int $month, int $year): array
    {
        $daysMatrix = [];
        $dayNumber = 1;
        $initDate = getdate(mktime(0, 0, 0, $month, 1, $year));
        $initWeekDay = (int) $initDate['wday'];
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        if (0 === $initWeekDay) {
            $initWeekDay = 7;
        }
        --$initWeekDay;
        for ($index = $initWeekDay; $index < ($totalDays + $initWeekDay); ++$index) {
            $daysMatrix[$index] = ['nday' => $dayNumber];
            ++$dayNumber;
        }

        return $daysMatrix;
    }

    public function getActiveWorkingDaysItems(): array
    {
        return $this->ccwdr->getActiveWorkingDaysSortedByNumber();
    }
}
