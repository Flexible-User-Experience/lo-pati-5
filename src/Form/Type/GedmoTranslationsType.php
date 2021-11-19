<?php

namespace App\Form\Type;

use App\Form\DataMapper\GedmoTranslationMapper;
use App\Form\EventListener\GedmoTranslationsListener;
use App\Form\Translation\GedmoTranslationForm;
use Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Regroup by locales, all translations fields (Gedmo)
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
class GedmoTranslationsType extends AbstractType
{
    private GedmoTranslationsListener $translationsListener;
    private GedmoTranslationForm $translationForm;
    private array $locales;
    private ?array $required;

    public function __construct(GedmoTranslationsListener $translationsListener, GedmoTranslationForm $translationForm, array $locales, array $required = null)
    {
        $this->translationsListener = $translationsListener;
        $this->translationForm = $translationForm;
        $this->locales = $locales;
        $this->required = $required;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Simple way is enough
        if (!$options['inherit_data']) {
            $builder->setDataMapper(new GedmoTranslationMapper());
            $builder->addEventSubscriber($this->translationsListener);
        } else {
            if (!$options['translatable_class']) {
                throw new Exception("If you want include the default locale with translations locales, you need to fill the 'translatable_class' option");
            }
            $childrenOptions = $this->translationForm->getChildrenOptions($options['translatable_class'], $options);
            $defaultLocale = (array) $this->translationForm->getGedmoTranslatableListener()->getDefaultLocale();
            $builder
                ->add(
                    'defaultLocale',
                    GedmoTranslationsLocalesType::class,
                    [
                        'locales' => $defaultLocale,
                        'fields_options' => $childrenOptions,
                        'inherit_data' => true,
                    ]
                )
                ->add(
                    $builder->getName(),
                    GedmoTranslationsLocalesType::class,
                    [
                        'locales' => array_diff($options['locales'], $defaultLocale),
                        'fields_options' => $childrenOptions,
                        'inherit_data' => false,
                        'translation_class' => $this->translationForm->getTranslationClass($options['translatable_class']),
                    ]
                )
            ;
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['simple_way'] = !$options['inherit_data'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $translatableListener = $this->translationForm->getGedmoTranslatableListener();
        $resolver->setDefaults([
            'required' => $this->required,
            'locales' => $this->locales,
            'fields' => [],
            'translatable_class' => null,
            // inherit_data is needed only if there is no persist of default locale and default locale is required to display
            'inherit_data' => function (Options $options) use ($translatableListener) {
                return !$translatableListener->getPersistDefaultLocaleTranslation() && (in_array($translatableListener->getDefaultLocale(), $options['locales'], true));
            },
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'a2lix_translations_gedmo';
    }
}
