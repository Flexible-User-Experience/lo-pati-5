<?php

namespace App\Controller\Frontend;

use App\Entity\Archive;
use App\Entity\MenuLevel1;
use App\Entity\Page;
use App\Repository\ArchiveRepository;
use App\Repository\MenuLevel1Repository;
use App\Repository\PageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

final class ArchiveController extends AbstractController
{
    /**
     * @Route({"ca": "/{menu}/any/{year}", "es": "/{menu}/ano/{year}"}, name="front_app_archive_year_list")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
     * @ParamConverter("archive", class="App\Entity\Archive", options={"mapping": {"year": "year"}})
     */
    public function archiveYearList(MenuLevel1 $menu, Archive $archive, ArchiveRepository $ar, PageRepository $pr, KernelInterface $kernel): Response
    {
        return $this->render(
            'frontend/archive/archive_year_list.html.twig',
            [
                'menu' => $menu,
                'archives' => $ar->getEnabledSortedByYear()->getQuery()->getResult(),
                'archive' => $archive,
                'pages' => $pr->getActiveItemsFromArchive($archive)->getQuery()->getResult(),
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }

    /**
     * @Route({"ca": "/{menu}/any/{year}/pagina/{slug}/{id}", "es": "/{menu}/ano/{year}/pagina/{slug}/{id}"}, name="front_app_archive_year_page_detail")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
     * @ParamConverter("archive", class="App\Entity\Archive", options={"mapping": {"year": "year"}})
     * @ParamConverter("page", class="App\Entity\Page", options={"mapping": {"id": "id"}})
     */
    public function archiveYearPageDetail(MenuLevel1 $menu, Archive $archive, Page $page, ArchiveRepository $ar, MenuLevel1Repository $ml1r, KernelInterface $kernel, int $idMenuArchive): Response
    {
        return $this->render(
            'frontend/archive/archive_year_page_detail.html.twig',
            [
                'menu' => $menu,
                'menu_archive' => $ml1r->find($idMenuArchive),
                'archives' => $ar->getEnabledSortedByYear()->getQuery()->getResult(),
                'archive' => $archive,
                'page' => $page,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }
}
