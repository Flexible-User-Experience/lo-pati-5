<?php

namespace App\Controller\Frontend;

use App\Entity\Newsletter;
use App\Entity\NewsletterUser;
use App\Form\Type\NewsletterSubscriptionFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class NewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter/subscribe", name="front_app_newsletter_subscribe_form", priority=10)
     */
    public function form(Request $request, TranslatorInterface $translator): Response
    {
        $newsletterUser = new NewsletterUser();
        $newsletterSubscriptionForm = $this->createForm(NewsletterSubscriptionFormType::class, $newsletterUser, [
            'action' => $this->generateUrl('front_app_newsletter_subscribe_form'),
        ]);
        $newsletterSubscriptionForm->handleRequest($request);
        if ($newsletterSubscriptionForm->isSubmitted() && $newsletterSubscriptionForm->isValid()) {
            $this->addFlash('success', $translator->trans('submitted'));

            return $this->redirectToRoute('front_app_homepage', ['_locale' => $request->getLocale()]);
        }

        return $this->render('frontend/newsletter/form.html.twig',
            [
                'newsletter_subscription_form' => $newsletterSubscriptionForm->createView(),
            ]
        );
    }

    /**
     * @Route("/newsletter/{id}", name="front_app_newsletter_web_version", priority=10)
     * @ParamConverter("id", class="App\Entity\Newsletter", options={"mapping": {"id": "id"}})
     */
    public function showNewsletterWebVersion(Newsletter $newsletter): Response
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
     * @Route("/newsletter/unsubscribe/{token}", name="front_app_newsletter_unsubscribe", priority=10)
     * @ParamConverter("token", class="App\Entity\NewsletterUser", options={"mapping": {"token": "token"}})
     */
    public function newsletterUnsubscribe(NewsletterUser $user, TranslatorInterface $translator): RedirectResponse
    {
        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('notice', $translator->trans('front.newsletter.unsubscribe_success'));

        return $this->redirectToRoute('front_app_homepage');
    }
}
