<?php

namespace App\Controller\Frontend;

use App\Repository\PageRepository;
use App\Repository\VisitingHoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class VisitingHoursController extends AbstractController
{
    /**
     * @Route("/visiting-hours/timetable", name="front_app_visiting_hours_timetable", priority=10)
     */
    public function timetable(VisitingHoursRepository $vhr, PageRepository $pr, ParameterBagInterface $pb): Response
    {
        return $this->render(
            'frontend/visiting_hours/timetable.html.twig',
            [
                'visiting_hours' => $vhr->getVisitingHours(),
                'contact_page' => $pr->find($pb->get('id_page_contact')),
            ]
        );
    }

    /**
     * @Route("/visiting-hours/footer", name="front_app_visiting_hours_footer", priority=10)
     */
    public function footer(VisitingHoursRepository $vhr): Response
    {
        return $this->render(
            'frontend/visiting_hours/footer.html.twig',
            [
                'visiting_hours' => $vhr->getVisitingHours(),
            ]
        );
    }
}
