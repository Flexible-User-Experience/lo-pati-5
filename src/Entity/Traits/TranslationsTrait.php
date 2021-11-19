<?php

namespace App\Entity\Traits;

use Doctrine\Common\Collections\Collection;

trait TranslationsTrait
{
    public function getTranslations(): ?Collection
    {
        return $this->translations;
    }

    public function setTranslations(?Collection $translations): self
    {
        $this->translations = $translations;

        return $this;
    }

    public function addTranslation($translation): self
    {
        if ($translation->getContent()) {
            $translation->setObject($this);
            $this->translations->add($translation);
        }

        return $this;
    }

    public function removeTranslation($translation): self
    {
        $this->translations->removeElement($translation);

        return $this;
    }
}
