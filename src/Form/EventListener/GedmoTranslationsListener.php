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
class GedmoTranslationsListener implements EventSubscriberInterface
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
        $formOptions = $form->getConfig()->getOptions();
        $childrenOptions = $this->translationForm->getChildrenOptions($translatableClass, $formOptions);
        foreach ($formOptions['locales'] as $locale) {
            if (isset($childrenOptions[$locale])) {
                $form->add(
                    $locale,
                    TranslationsFieldsType::class,
                    [
                        'fields' => $childrenOptions[$locale],
                        'translation_class' => $this->translationForm->getTranslationClass($translatableClass),
                    ]
                );
            }
        }
    }
}
