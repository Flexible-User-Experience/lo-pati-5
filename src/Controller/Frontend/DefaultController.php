<?php

namespace App\Controller\Frontend;

use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Entity\Newsletter;
use App\Entity\NewsletterUser;
use App\Entity\Page;
use App\Repository\PageRepository;
use App\Repository\SlideshowRepository;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

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
            6,
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
    public function searchAction(Request $request, RepositoryManagerInterface $finder): Response
    {
        $pages = $finder->getRepository(Page::class)->find($request->query->get('q'));

        return $this->render(
            'frontend/partials/full_text_search_results.html.twig',
            [
                'pages' => $pages,
            ]
        );
    }

    /**
     * @Route("/newsletter/{id}", name="front_app_newsletter_web_version")
     * @ParamConverter("id", class="App\Entity\Newsletter", options={"mapping": {"id": "id"}})
     */
    public function newsletterWebAction(Newsletter $newsletter): Response
    {
        return $this->render(
            'mail/newsletter.html.twig',
            [
                'newsletter' => $newsletter,
                'show_top_bar' => false,
                'show_bottom_bar' => false,
            ]
        );
    }

    /**
     * @Route("/newsletter/unsubscribe/{token}", name="front_app_newsletter_unsubscribe")
     * @ParamConverter("token", class="App\Entity\NewsletterUser", options={"mapping": {"token": "token"}})
     */
    public function newsletterUnsubscribeAction(NewsletterUser $user, TranslatorInterface $translator): RedirectResponse
    {
        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('notice', $translator->trans('front.newsletter.unsubscribe_success'));

        return $this->redirectToRoute('front_app_homepage');
    }

    /**
     * @Route({"ca": "/canviar-a-idioma/{locale}", "es": "/cambiar-idioma/{locale}"}, name="front_app_language_switcher")
     */
    public function languageSwitcherAction(Request $request, string $locale): Response
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirectToRoute('front_app_homepage', ['_locale' => $locale]);
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
     * @Entity("submenu", class="App\Entity\MenuLevel2", expr="repository.getByMenuAndSubmenuSlugs(menu, submenu)")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
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
     * @Entity("submenu", class="App\Entity\MenuLevel2", expr="repository.getByMenuAndSubmenuSlugs(menu, submenu)")
     * @Entity("page", class="App\Entity\Page", expr="repository.getByDateAndSlug(date, page)")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
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
