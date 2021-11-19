<?php

namespace App\Form\Type;

use App\Form\DataMapper\IndexByTranslationMapper;
use App\Form\EventListener\DefaultTranslationsListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Regroup by locales, all translations fields
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
class TranslationsType extends AbstractType
{
    private DefaultTranslationsListener $translationsListener;
    private array $locales;
    private ?array $required = null;

    public function __construct(DefaultTranslationsListener $translationsListener, array $locales, ?array $required = null)
    {
        $this->translationsListener = $translationsListener;
        $this->locales = $locales;
        $this->required = $required;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setDataMapper(new IndexByTranslationMapper());
        $builder->addEventSubscriber($this->translationsListener);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'by_reference' => false,
            'required' => $this->required,
            'locales' => $this->locales,
            'fields' => [],
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'a2lix_translations';
    }
}
