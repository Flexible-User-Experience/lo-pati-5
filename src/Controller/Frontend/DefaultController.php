<?php

namespace App\Controller\Frontend;

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
     */
    public function menuLevel1Action(string $menu): Response
    {
        return $this->render(
            'frontend/menu_level_1.html.twig',
            [
                'menu' => $menu,
            ]
        );
    }
}
