<?php

namespace App\Controller\Frontend;

use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="front_app_homepage")
     */
    public function indexAction(): Response
    {
        return $this->render('frontend/homepage.html.twig');
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
}
