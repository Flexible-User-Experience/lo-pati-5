<?php

namespace App\Controller\Backend;

use App\Form\Type\AdminLoginFormType;
use App\Model\AdminLogin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminLoginController extends AbstractController
{
    /**
     * @Route("/admin/login", name="admin_app_login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(AdminLoginFormType::class, new AdminLogin());

        return $this->render('backend/security/login.html.twig', [
            Security::LAST_USERNAME => $authenticationUtils->getLastUsername(),
            Security::AUTHENTICATION_ERROR => $authenticationUtils->getLastAuthenticationError(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/logout", name="admin_app_logout")
     */
    public function logoutAction(): void
    {
    }
}
