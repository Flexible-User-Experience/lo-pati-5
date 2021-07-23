<?php

namespace App\Controller\Frontend;

use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Entity\Page;
use App\Repository\PageRepository;
use App\Repository\SlideshowRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="front_app_homepage")
     */
    public function indexAction(Request $request, SlideshowRepository $sr, PageRepository $pr, PaginatorInterface $pi): Response
    {
        $slides = $sr->getEnabledSortedByPositionAndName()->getQuery()->getResult();
        $highlightedPages = $pi->paginate(
            $pr->getHomepageHighlighted()->getQuery(),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render(
            'frontend/homepage.html.twig',
            [
                'slides' => $slides,
                'highlighted_pages' => $highlightedPages,
            ]
        );
    }

    /**
     * @Route("/{menu}", name="front_app_menu_level_1")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
     */
    public function menuLevel1Action(MenuLevel1 $menu): Response
    {
        return $this->render(
            'frontend/menu_level_1.html.twig',
            [
                'menu' => $menu,
            ]
        );
    }

    /**
     * @Route("/{menu}/{submenu}", name="front_app_menu_level_2")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
     * @Entity("submenu", class="App\Entity\MenuLevel2", expr="repository.getByMenuAndSubmenuSlugs(menu, submenu)")
     */
    public function menuLevel2Action(MenuLevel1 $menu, MenuLevel2 $submenu): Response
    {
        return $this->render(
            'frontend/menu_level_2.html.twig',
            [
                'menu' => $menu,
                'submenu' => $submenu,
            ]
        );
    }

    /**
     * @Route("/{menu}/{submenu}/{date}/{page}", name="front_app_page_detail")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
     * @Entity("submenu", class="App\Entity\MenuLevel2", expr="repository.getByMenuAndSubmenuSlugs(menu, submenu)")
     * @Entity("page", class="App\Entity\Page", expr="repository.getByDateAndSlug(date, page)")
     */
    public function pageDetailAction(MenuLevel1 $menu, MenuLevel2 $submenu, Page $page): Response
    {
        return $this->render(
            'frontend/page_detail.html.twig',
            [
                'menu' => $menu,
                'submenu' => $submenu,
                'page' => $page,
            ]
        );
    }
}
