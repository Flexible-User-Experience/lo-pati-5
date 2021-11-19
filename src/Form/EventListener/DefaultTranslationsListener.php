<?php

namespace App\Form\EventListener;

use App\Form\Translation\TranslationForm;
use App\Form\Type\TranslationsFieldsType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
class DefaultTranslationsListener implements EventSubscriberInterface
{
    private TranslationForm $translationForm;

    public function __construct(TranslationForm $translationForm)
    {
        $this->translationForm = $translationForm;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
        ];
    }

    public function preSetData(FormEvent $event): void
    {
        $form = $event->getForm();
        $translatableClass = $form->getParent()->getConfig()->getDataClass();
        $translationClass = $translatableClass::getTranslationEntityClass();
        $formOptions = $form->getConfig()->getOptions();
        $childrenOptions = $this->translationForm->getChildrenOptions($translationClass, $formOptions);
        foreach ($formOptions['locales'] as $locale) {
            if (isset($childrenOptions[$locale])) {
                $form->add(
                    $locale,
                    TranslationsFieldsType::class,
                    [
                        'data_class' => $translationClass,
                        'fields' => $childrenOptions[$locale],
                    ]
                );
            }
        }
    }
}
