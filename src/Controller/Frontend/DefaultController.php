<?php

namespace App\Controller\Frontend;

use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Entity\Page;
use App\Repository\ArchiveRepository;
use App\Repository\ArtistRepository;
use App\Repository\PageRepository;
use App\Repository\SlideshowPageRepository;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

final class DefaultController extends AbstractController
{
    private const HIGHLIGHTED_HOMEPAGE_ITEMS = 9;

    /**
     * @Route("/", name="front_app_homepage")
     */
    public function index(Request $request, SlideshowPageRepository $spr, PageRepository $pr, PaginatorInterface $pi): Response
    {
        $slides = $spr->getEnabledSortedByPositionAndName()->getQuery()->getResult();
        $highlightedPages = $pi->paginate(
            $pr->getHomepageHighlighted()->getQuery(),
            $request->query->getInt('page', 1),
            self::HIGHLIGHTED_HOMEPAGE_ITEMS,
            [
                'align' => 'center',
            ]
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
     * @Route("/search", name="front_app_search")
     */
    public function search(Request $request, RepositoryManagerInterface $finder): Response
    {
        return $this->render(
            'frontend/partials/full_text_search_results.html.twig',
            [
                'pages' => $finder->getRepository(Page::class)->getFulltextSearchByQueryFilteredByActive($request->query->get('q')),
            ]
        );
    }

    /**
     * @Route({"ca": "/canviar-a-idioma/{locale}", "es": "/cambiar-idioma/{locale}"}, name="front_app_language_switcher")
     */
    public function languageSwitcher(Request $request, string $locale): Response
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirectToRoute('front_app_homepage', ['_locale' => $locale]);
    }

    /**
     * @Route("/{menu}", name="front_app_menu_level_1")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
     */
    public function menuLevel1(MenuLevel1 $menu, ArchiveRepository $ar, KernelInterface $kernel): Response
    {
        if (!$menu->getPage() && $menu->getMenuLevel2items() && !$menu->getMenuLevel2items()->isEmpty()) {
            $firstSubmenu = $menu->getMenuLevel2items()[0];

            return $this->redirectToRoute('front_app_menu_level_2', [
                'menu' => $menu->getSlug(),
                'submenu' => $firstSubmenu->getSlug(),
            ]);
        }
        if ($menu->isArchive()) {
            $archives = $ar->getEnabledSortedByYear()->getQuery()->getResult();

            return $this->render(
                'frontend/archive/archives.html.twig',
                [
                    'menu' => $menu,
                    'archives' => $archives,
                    'show_debug_page_info' => $kernel->isDebug(),
                ]
            );
        }

        return $this->render(
            'frontend/menu_level_1.html.twig',
            [
                'menu' => $menu,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }

    /**
     * @Route("/{menu}/{submenu}", name="front_app_menu_level_2")
     * @Entity("submenu", class="App\Entity\MenuLevel2", expr="repository.getByMenuAndSubmenuSlugs(menu, submenu)")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
     */
    public function menuLevel2(MenuLevel1 $menu, MenuLevel2 $submenu, ArtistRepository $ar, PageRepository $pr, KernelInterface $kernel, int $idPageIrradiador): Response
    {
        if ($submenu->getPage() && $idPageIrradiador === $submenu->getPage()->getId()) {
            $artists = $ar->getEnabledSortedByName()->getQuery()->getResult();

            return $this->render(
                'frontend/artist/artists.html.twig',
                [
                    'menu' => $menu,
                    'submenu' => $submenu,
                    'page' => $submenu->getPage(),
                    'artists' => $artists,
                    'show_debug_page_info' => $kernel->isDebug(),
                    'is_irradiador' => true,
                ]
            );
        }
        if (!$submenu->getPage()) {
            $pages = $pr->getActiveItemsFromMenuLevel2SortedByPublishDate($submenu)->getQuery()->getResult();

            return $this->render(
                'frontend/menu_level_2_pages_list.html.twig',
                [
                    'menu' => $menu,
                    'submenu' => $submenu,
                    'pages' => $pages,
                    'show_debug_page_info' => $kernel->isDebug(),
                    'is_irradiador' => false,
                ]
            );
        }

        return $this->render(
            'frontend/menu_level_2.html.twig',
            [
                'menu' => $menu,
                'submenu' => $submenu,
                'show_debug_page_info' => $kernel->isDebug(),
                'is_irradiador' => false,
            ]
        );
    }

    /**
     * @Route("/{menu}/{submenu}/{date}/{page}", name="front_app_page_detail")
     * @Entity("submenu", class="App\Entity\MenuLevel2", expr="repository.getByMenuAndSubmenuSlugs(menu, submenu)")
     * @Entity("page", class="App\Entity\Page", expr="repository.getByDateAndSlug(date, page)")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
     */
    public function pageDetail(MenuLevel1 $menu, MenuLevel2 $submenu, Page $page, KernelInterface $kernel): Response
    {
        return $this->render(
            'frontend/page_detail.html.twig',
            [
                'menu' => $menu,
                'submenu' => $submenu,
                'page' => $page,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }
}
