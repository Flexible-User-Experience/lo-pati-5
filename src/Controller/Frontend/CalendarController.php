<?php

namespace App\Controller\Frontend;

use App\Entity\AbstractBase;
use App\Enum\MonthEnum;
use App\Manager\CalendarManager;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="front_app_calendar", options={"expose": true}, locale="ca")
     */
    public function calendar(CalendarManager $cm, TranslatorInterface $translator): Response
    {
        $now = new DateTimeImmutable();
        $month = (int) $now->format('n');
        $year = (int) $now->format('Y');
        $daysMatrix = $cm->getDaysMatrixByMonthAndYear($month, $year);

        return $this->render('frontend/calendar/calendar.html.twig', [
            'show_week_days_name_in_calendar' => false,
            'max_weeks' => $cm->getMaxWeeksAmountFromDaysMatrix($daysMatrix),
            'month_string' => $translator->trans(MonthEnum::getEnumArray()[$now->format('n')]),
            'month' => $month,
            'year' => $year,
            'days_matrix' => $daysMatrix,
            'hits_matrix' => $cm->getHitDaysMatrix($month, $year),
        ]);
    }

    /**
     * @Route("/agenda/{year}/{month}/{day}", name="front_app_agenda_list", priority=20)
     */
    public function agenda(CalendarManager $cm, $year, $month, $day): Response
    {
        $moment = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, $year.'-'.$month.'-'.$day);
        $pages = $cm->getActivePagesForDate($moment);

        return $this->render('frontend/calendar/agenda.html.twig', [
            'pages' => $pages,
            'moment' => $moment,
        ]);
    }
}
