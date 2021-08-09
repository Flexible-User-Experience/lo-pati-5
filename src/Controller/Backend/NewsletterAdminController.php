<?php

namespace App\Controller\Backend;

use App\Entity\Newsletter;
use App\Manager\MailManager;
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

    public function testAction($id, MailManager $mm): RedirectResponse
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
        $sendingSuccessStatus = $mm->sendNewsletterEmailTest('[TEST] '.$newsletter->getSubject(), $content);

//        $result = $ms->batchDelivery('[TEST] '.$object->getSubject(), $this->getTestEmailsDestinationList(), $content); // TODO
        if (false === $sendingSuccessStatus) {
            $this->addFlash('sonata_flash_error', $this->trans('back.flash.newsletter_email_test_failure'));
        } else {
            $newsletter->setTested(true);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('sonata_flash_success', $this->trans('back.flash.newsletter_email_test_success'));
//     'S\'ha enviat correctament un email de test a les bústies: '.$this->getParameter('email_address_test_1').', '.$this->getParameter('email_address_test_2').' i '.$this->getParameter('email_address_test_3')
        }

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
