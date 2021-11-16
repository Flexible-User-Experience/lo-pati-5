<?php

namespace App\Controller\Frontend;

use App\Enum\MonthEnum;
use App\Manager\CalendarManager;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CalendarController extends AbstractController
{
    /**
     * @Route("/agenda", name="front_app_calendar", options={"expose": true}, locale="ca")
     */
    public function calendar(CalendarManager $cm, TranslatorInterface $translator): Response
    {
        $now = new DateTimeImmutable();
        $month = (int) $now->format('n');
        $year = (int) $now->format('Y');
        $daysMatrix = [];
        $initDate = getdate(mktime(0, 0, 0, $month, 1, $year));
        $initWeekDay = (int) $initDate['wday'];
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        if (0 === $initWeekDay) {
            $initWeekDay = 7;
        }
        --$initWeekDay; // Reajuste del dia inicial de la setmana (lunes=0, domingo=6)
        $num = 1;
        for ($index = $initWeekDay; $index < ($totalDays + $initWeekDay); ++$index) {
            $daysMatrix[$index] = ['nday' => $num];
            ++$num;
        }

        return $this->render('frontend/calendar/calendar.html.twig', [
            'show_week_days_name_in_calendar' => false,
            'max_weeks' => $cm->getMaxWeeksAmountFromDaysMatrix($daysMatrix),
            'month_string' => $translator->trans(MonthEnum::getEnumArray()[$now->format('n')]),
            'month' => $month,
            'year' => $year,
            'days_matrix' => $daysMatrix,
        ]);
    }
}
