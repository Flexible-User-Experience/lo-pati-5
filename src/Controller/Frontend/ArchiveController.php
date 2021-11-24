<?php

namespace App\Controller\Frontend;

use App\Entity\Archive;
use App\Entity\MenuLevel1;
use App\Entity\Page;
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
    public function archiveYearList(MenuLevel1 $menu, Archive $archive, PageRepository $pr, KernelInterface $kernel): Response
    {
        $pages = $pr->getActiveItemsFromArchive($archive)->getQuery()->getResult();

        return $this->render(
            'frontend/archive/archive_year_list.html.twig',
            [
                'menu' => $menu,
                'archive' => $archive,
                'pages' => $pages,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }

    /**
     * @Route({"ca": "/{menu}/any/{year}/pagina/{slug}/{id}", "es": "/{menu}/año/{year}/pagina/{slug}/{id}"}, name="front_app_archive_year_page_detail")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
     * @ParamConverter("archive", class="App\Entity\Archive", options={"mapping": {"year": "year"}})
     * @ParamConverter("page", class="App\Entity\Page", options={"mapping": {"id": "id"}})
     */
    public function archiveYearPageDetail(MenuLevel1 $menu, Archive $archive, Page $page, PageRepository $pr, KernelInterface $kernel): Response
    {
        return $this->render(
            'frontend/archive/archive_year_page_detail.html.twig',
            [
                'menu' => $menu,
                'archive' => $archive,
                'page' => $page,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }
}
