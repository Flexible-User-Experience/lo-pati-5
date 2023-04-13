<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ConditionsController extends AbstractController
{
    /**
     * @Route({"ca": "/politica-de-privacitat", "es": "/politica-de-privacidad"}, name="front_app_privacy_policy")
     */
    public function privacyPolicy(): Response
    {
        return $this->render('frontend/terms/privacy_policy.html.twig');
    }

    /**
     * @Route({"ca": "/accessibilitat", "es": "/accesibilidad"}, name="front_app_accessibility_statement")
     */
    public function accessibilityStatement(): Response
    {
        return $this->render('frontend/terms/accessibility_statement.html.twig');
    }
}
