<?php

namespace App\Controller\Backend;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsletterAdminController extends CRUDController
{
    /**
     * @throws ModelManagerException
     */
    public function previewAction($id): Response
    {
        $object = $this->admin->getSubject();
        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }
        $duplicatedObject = clone $object;
//        $duplicatedObject->setName($object->getName().' ('.$this->trans('back.action.duplicated').')');
//        $this->admin->create($duplicatedObject);
        $this->addFlash('sonata_flash_success', $this->trans('back.flash.preview'));

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    /**
     * @throws ModelManagerException
     */
    public function testAction($id): Response
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
