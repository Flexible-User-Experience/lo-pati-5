<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermsController extends AbstractController
{
    /**
     * @Route("/politica-de-privacitat", name="front_app_privacy_policy")
     */
    public function privacyPolicyAction(): Response
    {
        return $this->render('frontend/terms/privacy_policy.html.twig');
    }
}
