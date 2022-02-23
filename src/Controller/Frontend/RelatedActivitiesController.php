<?php

namespace App\Controller\Frontend;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RelatedActivitiesController extends AbstractController
{
    /**
     * @Route("/related-activities/page/{id}", name="front_app_related_activities_by_page", priority=10)
     */
    public function relatedActivitiesByPage(int $id, PageRepository $pr): Response
    {
        $page = $pr->find($id);
        if (!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'frontend/related_activities/by_page.html.twig',
            [
                'related_activities' => $pr->getActiveItemsRelatedByMenuLevel2OrMenuLeve1SortedByPublishDate($page)->getQuery()->getResult(),
            ]
        );
    }

    /**
     * @Route("/previous-editions/page/{id}", name="front_app_previous_editions_by_page", priority=10)
     */
    public function previousEditionsByPage(int $id, PageRepository $pr): Response
    {
        $page = $pr->find($id);
        if (!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'frontend/related_activities/previous_editions.html.twig',
            [
                'previous_editions' => $pr->getPreviousEditionsSortedByPublishDate($page)->getQuery()->getResult(),
            ]
        );
    }
}
