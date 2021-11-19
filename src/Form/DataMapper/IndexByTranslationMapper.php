<?php

namespace App\Form\DataMapper;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
class IndexByTranslationMapper implements DataMapperInterface
{
    public function mapDataToForms($viewData, $forms): void
    {
        if (null === $viewData || [] === $viewData) {
            return;
        }
        if (!is_array($viewData) && !is_object($viewData)) {
            throw new UnexpectedTypeException($viewData, 'object, array or empty');
        }
        foreach ($forms as $form) {
            $form->setData($viewData->get($form->getConfig()->getName()));
        }
    }

    public function mapFormsToData($forms, &$viewData): void
    {
        if (null === $viewData) {
            return;
        }
        if (!is_array($viewData) && !is_object($viewData)) {
            throw new UnexpectedTypeException($viewData, 'object, array or empty');
        }
        $viewData = $viewData ?: new ArrayCollection();
        foreach ($forms as $form) {
            if (is_object($translation = $form->getData()) && !$translation->getId()) {
                $locale = $form->getConfig()->getName();
                $translation->setLocale($locale);

                $viewData->set($locale, $translation);
            }
        }
    }
}
