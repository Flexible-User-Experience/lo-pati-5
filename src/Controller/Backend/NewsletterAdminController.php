<?php

namespace App\Controller\Backend;

use App\Entity\Newsletter;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsletterAdminController extends CRUDController
{
    public function previewAction($id): Response
    {
        /** @var Newsletter $object */
        $object = $this->admin->getObject($id);
        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        return $this->renderWithExtraParams(
            'mail/base_email.html.twig',
            [
                'newsletter' => $object,
                'show_top_bar' => true,
                'show_bottom_bar' => false,
            ]
        );
    }

    /**
     * @throws ModelManagerException
     */
    public function testAction($id): Response // TODO
    {
        $object = $this->admin->getSubject();
        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        $duplicatedObject = clone $object;
//        $duplicatedObject->setName($object->getName().' ('.$this->trans('back.action.duplicated').')');
//        $this->admin->create($duplicatedObject);
        $this->addFlash('sonata_flash_success', $this->trans('back.flash.test'));

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
