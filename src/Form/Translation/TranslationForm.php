<?php

namespace App\Form\Translation;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\FormTypeGuesserInterface;

/**
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
abstract class TranslationForm implements TranslationFormInterface
{
    private ?FormTypeGuesserInterface $typeGuesser;
    private Registry $managerRegistry;

    public function __construct(FormRegistry $formRegistry, Registry $managerRegistry)
    {
        $this->typeGuesser = $formRegistry->getTypeGuesser();
        $this->managerRegistry = $managerRegistry;
    }

    public function getManagerRegistry(): Registry
    {
        return $this->managerRegistry;
    }

    public function getChildrenOptions($class, $options): array
    {
        $childrenOptions = [];

        // Clean some options
        unset($options['inherit_data'], $options['translatable_class']);

        // Custom options by field
        foreach (array_unique(array_merge(array_keys($options['fields']), $this->getTranslatableFields($class))) as $child) {
            $childOptions = ($options['fields'][$child] ?? []) + ['required' => $options['required']];

            if (!isset($childOptions['display']) || $childOptions['display']) {
                $childOptions = $this->guessMissingChildOptions($this->typeGuesser, $class, $child, $childOptions);

                // Custom options by locale
                if (isset($childOptions['locale_options'])) {
                    $localesChildOptions = $childOptions['locale_options'];
                    unset($childOptions['locale_options']);

                    foreach ($options['locales'] as $locale) {
                        $localeChildOptions = $localesChildOptions[$locale] ?? [];
                        if (!isset($localeChildOptions['display']) || $localeChildOptions['display']) {
                            $childrenOptions[$locale][$child] = $localeChildOptions + $childOptions;
                        }
                    }

                    // General options for all locales
                } else {
                    foreach ($options['locales'] as $locale) {
                        $childrenOptions[$locale][$child] = $childOptions;
                    }
                }
            }
        }

        return $childrenOptions;
    }

    public function guessMissingChildOptions($guesser, $class, $property, $options)
    {
        if (!isset($options['field_type']) && ($typeGuess = $guesser->guessType($class, $property))) {
            $options['field_type'] = $typeGuess->getType();
        }

//        if (!isset($options['pattern']) && ($patternGuess = $guesser->guessPattern($class, $property))) {
//            $options['pattern'] = $patternGuess->getValue();
//        }

//        if (!isset($options['max_length']) && ($maxLengthGuess = $guesser->guessMaxLength($class, $property))) {
//            $options['max_length'] = $maxLengthGuess->getValue();
//        }

        return $options;
    }
}
