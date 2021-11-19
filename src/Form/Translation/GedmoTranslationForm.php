<?php

namespace App\Form\Translation;

use Doctrine\Common\Util\ClassUtils;
use Gedmo\Translatable\TranslatableListener;

/**
 * adapted from A2lix\TranslationFormBundle (v1.3).
 */
class GedmoTranslationForm extends TranslationForm
{
    private TranslatableListener $gedmoTranslatableListener;
    private $gedmoConfig;

    public function getGedmoTranslatableListener(): TranslatableListener
    {
        return $this->gedmoTranslatableListener;
    }

    public function setGedmoTranslatableListener(TranslatableListener $gedmoTranslatableListener): void
    {
        $this->gedmoTranslatableListener = $gedmoTranslatableListener;
    }

    private function getGedmoConfig($translatableClass)
    {
        if (isset($this->gedmoConfig[$translatableClass])) {
            return $this->gedmoConfig[$translatableClass];
        }
        $translatableClass = ClassUtils::getRealClass($translatableClass);
        $manager = $this->getManagerRegistry()->getManagerForClass($translatableClass);
        $this->gedmoConfig[$translatableClass] = $this->gedmoTranslatableListener->getConfiguration($manager, $translatableClass);

        return $this->gedmoConfig[$translatableClass];
    }

    public function getTranslationClass($translatableClass)
    {
        $gedmoConfig = $this->getGedmoConfig($translatableClass);

        return $gedmoConfig['translationClass'];
    }

    protected function getTranslatableFields($translatableClass): array
    {
        $gedmoConfig = $this->getGedmoConfig($translatableClass);

        return $gedmoConfig['fields'] ?? [];
    }
}
