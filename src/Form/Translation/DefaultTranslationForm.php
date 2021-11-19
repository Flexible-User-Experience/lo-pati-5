<?php

namespace App\Form\Translation;

use Doctrine\Common\Util\ClassUtils;

/**
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
class DefaultTranslationForm extends TranslationForm
{
    protected function getTranslatableFields($translationClass): array
    {
        $translationClass = ClassUtils::getRealClass($translationClass);
        $manager = $this->getManagerRegistry()->getManagerForClass($translationClass);
        $metadataClass = $manager->getMetadataFactory()->getMetadataFor($translationClass);
        $fields = [];
        foreach ($metadataClass->fieldMappings as $fieldMapping) {
            if (!in_array($fieldMapping['fieldName'], ['id', 'locale'])) {
                $fields[] = $fieldMapping['fieldName'];
            }
        }

        return $fields;
    }
}
