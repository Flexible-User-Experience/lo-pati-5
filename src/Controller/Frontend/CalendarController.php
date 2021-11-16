<?php

namespace App\Controller\Frontend;

use App\Enum\MonthEnum;
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
    public function calendar(TranslatorInterface $translator): Response
    {
        $now = new DateTimeImmutable();

        return $this->render('frontend/calendar/calendar.html.twig', [
            'month_string' => $translator->trans(MonthEnum::getEnumArray()[$now->format('n')]),
            'month' => $now->format('n'),
            'year' => $now->format('Y'),
        ]);
    }
}
