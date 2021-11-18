<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait SummaryTrait
{
    /**
     * @ORM\Column(type="string", length=300, nullable=true)
     * @Gedmo\Translatable
     */
    private ?string $summary = null;

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }
}
