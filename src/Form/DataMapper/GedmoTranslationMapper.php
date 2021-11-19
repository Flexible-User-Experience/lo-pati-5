<?php

namespace App\Form\DataMapper;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
class GedmoTranslationMapper implements DataMapperInterface
{
    public function mapDataToForms($viewData, $forms): void
    {
        if (null === $viewData || [] === $viewData) {
            return;
        }
        if (!is_array($viewData) && !is_object($viewData)) {
            throw new UnexpectedTypeException($viewData, 'object, array or empty');
        }
        foreach ($forms as $translationsFieldsForm) {
            $locale = $translationsFieldsForm->getConfig()->getName();
            $tmpFormData = [];
            foreach ($viewData as $translation) {
                if ($locale === $translation->getLocale()) {
                    $tmpFormData[$translation->getField()] = $translation->getContent();
                }
            }
            $translationsFieldsForm->setData($tmpFormData);
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
        $newData = new ArrayCollection();
        foreach ($forms as $translationsFieldsForm) {
            $translationsFieldsConfig = $translationsFieldsForm->getConfig();
            $locale = $translationsFieldsConfig->getName();
            $translationClass = $translationsFieldsConfig->getOption('translation_class');
            foreach ($translationsFieldsForm->getData() as $field => $content) {
                $existingTranslation = $viewData ? $viewData->filter(function ($object) use ($locale, $field) {
                    return $object && ($object->getLocale() === $locale) && ($object->getField() === $field);
                })->first() : null;

                if ($existingTranslation) {
                    $existingTranslation->setContent($content);
                    $newData->add($existingTranslation);
                } else {
                    $translation = new $translationClass();
                    $translation->setLocale($locale);
                    $translation->setField($field);
                    $translation->setContent($content);
                    $newData->add($translation);
                }
            }
        }

        $viewData = $newData;
    }
}
