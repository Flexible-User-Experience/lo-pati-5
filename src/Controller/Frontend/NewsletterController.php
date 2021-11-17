<?php

namespace App\Controller\Frontend;

use App\Entity\Newsletter;
use App\Entity\NewsletterUser;
use App\Form\Type\NewsletterSubscriptionFormType;
use App\Manager\MailManager;
use App\Repository\NewsletterUserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class NewsletterController extends AbstractController
{
    /**
     * @Route("/newsletter/test-email-template/{nui}", name="front_app_newsletter_test_email_template", priority=10)
     */
    public function test(int $nui, KernelInterface $kernel, NewsletterUserRepository $nur, TranslatorInterface $translator): Response
    {
        if (!$kernel->isDebug()) {
            throw $this->createAccessDeniedException();
        }
        $newsletterUser = $nur->find($nui);
        if (!$newsletterUser) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'mail/newsletter_subscribe_confirmation.html.twig',
            [
                'subject' => $translator->trans('newsletter.email.confirmation.suject_confirmation'),
                'user' => $newsletterUser,
                'show_top_bar' => false,
                'show_bottom_bar' => false,
            ]
        );
    }

    /**
     * @Route("/newsletter/subscribe", name="front_app_newsletter_subscribe_form", priority=10)
     */
    public function form(Request $request, NewsletterUserRepository $nur, MailManager $mm, TranslatorInterface $translator): Response
    {
        $newsletterUser = new NewsletterUser();
        $newsletterSubscriptionForm = $this->createForm(NewsletterSubscriptionFormType::class, $newsletterUser, [
            'action' => $this->generateUrl('front_app_newsletter_subscribe_form'),
            'allow_extra_fields' => true,
        ]);
        $newsletterSubscriptionForm->handleRequest($request);
        if ($newsletterSubscriptionForm->isSubmitted() && $newsletterSubscriptionForm->isValid()) {
            $searchedNewsletterUser = $nur->findOneBy(
                ['email' => $newsletterUser->getEmail()]
            );
            if ($searchedNewsletterUser) {
                // update an existent user
                $searchedNewsletterUser
                    ->setName($newsletterUser->getName())
                    ->setPhone($newsletterUser->getPhone())
                    ->setPostalCode($newsletterUser->getPostalCode())
                    ->setLanguage($request->getLocale())
                    ->setActive(false)
                ;
            } else {
                // create a new user
                $newsletterUser->setActive(false);
                $this->getDoctrine()->getManager()->persist($newsletterUser);
            }
            $this->getDoctrine()->getManager()->flush();
            $subject = $translator->trans('newsletter.email.confirmation.suject_confirmation');
            $mm->sendEmail(
                $subject,
                $this->renderView(
                    'mail/newsletter_subscribe_confirmation.html.twig',
                    [
                        'subject' => $subject,
                        'user' => $newsletterUser,
                        'show_top_bar' => false,
                        'show_bottom_bar' => false,
                    ]
                ),
                $newsletterUser->getEmail(),
                $newsletterUser->getName(),
            );
            $this->addFlash('success', $translator->trans('newsletter.flash.register'));

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
