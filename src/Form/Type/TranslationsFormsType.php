<?php

namespace App\Form\Type;

use App\Form\DataMapper\IndexByTranslationMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
class TranslationsFormsType extends AbstractType
{
    private array $locales;
    private ?array $required = null;

    public function __construct(array $locales, ?array $required)
    {
        $this->locales = $locales;
        $this->required = $required;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setDataMapper(new IndexByTranslationMapper());
        $formOptions = $options['form_options'] ?? [];
        foreach ($options['locales'] as $locale) {
            $builder->add($locale, $options['form_type'], $formOptions);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'by_reference' => false,
            'required' => $this->required,
            'locales' => $this->locales,
            'form_type' => null,
            'form_options' => null,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'a2lix_translationsForms';
    }
}
