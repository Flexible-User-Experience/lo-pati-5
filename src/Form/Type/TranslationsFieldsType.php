<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
class TranslationsFieldsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($options['fields'] as $fieldName => $fieldConfig) {
            $fieldType = $fieldConfig['field_type'];
            unset($fieldConfig['field_type']);
            $builder->add($fieldName, $fieldType, $fieldConfig);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'fields' => [],
            'translation_class' => null,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'a2lix_translationsFields';
    }
}
