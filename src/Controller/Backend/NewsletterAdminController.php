<?php

namespace App\Controller\Backend;

use App\Entity\Newsletter;
use App\Manager\MailManager;
use App\Model\SendGridEmailToken;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsletterAdminController extends CRUDController
{
    public function previewAction($id): Response
    {
        /** @var Newsletter $object */
        $newsletter = $this->admin->getObject($id);
        if (!$newsletter) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        return $this->renderWithExtraParams(
            'mail/newsletter_preview.html.twig',
            [
                'newsletter' => $newsletter,
                'show_top_bar' => true,
                'show_bottom_bar' => false,
            ]
        );
    }

    public function testAction($id, MailManager $mm, string $emailAddressTest1, string $emailAddressTest2, string $emailAddressTest3): RedirectResponse
    {
        /** @var Newsletter $newsletter */
        $newsletter = $this->admin->getObject($id);
        if (!$newsletter) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        $content = $this->renderView(
            'mail/newsletter_preview.html.twig',
            [
                'newsletter' => $newsletter,
                'show_top_bar' => false,
                'show_bottom_bar' => false,
            ]
        );
        $emailDestinationList = [
            new SendGridEmailToken($emailAddressTest1, 'fake-token-1'),
            new SendGridEmailToken($emailAddressTest2, 'fake-token-2'),
            new SendGridEmailToken($emailAddressTest3, 'fake-token-3'),
        ];
        $sendingSuccessStatus = $mm->sendGridBatchDelivery('[TEST] '.$newsletter->getSubject(), $content, $emailDestinationList);
        if (false === $sendingSuccessStatus) {
            $this->addFlash('sonata_flash_error', $this->trans('back.flash.newsletter_email_test_failure'));
        } else {
            $newsletter->setTested(true);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('sonata_flash_success', $this->trans('back.flash.newsletter_email_test_success', ['%emails%' => $emailAddressTest1.', '.$emailAddressTest2.' '.$this->trans('mail.and').' '.$emailAddressTest3]));
        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    public function sendAction($id): Response // TODO
    {
        /** @var Newsletter $object */
        $newsletter = $this->admin->getObject($id);
        if (!$newsletter) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        return $this->renderWithExtraParams(
            'mail/newsletter_preview.html.twig',
            [
                'newsletter' => $newsletter,
                'show_top_bar' => true,
                'show_bottom_bar' => false,
            ]
        );
    }
}
