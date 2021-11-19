<?php

namespace App\Form\Translation;

/**
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
interface TranslationFormInterface
{
    public function getChildrenOptions($class, $options);

    public function guessMissingChildOptions($guesser, $class, $property, $options);
}
