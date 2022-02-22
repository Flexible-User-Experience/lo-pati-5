<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait LegacyIdTrait
{
    /**
     * @ORM\Column(type="integer", nullable=true, unique=true)
     */
    private ?int $legacyId = null;

    public function getLegacyId(): ?int
    {
        return $this->legacyId;
    }

    public function setLegacyId(?int $legacyId): self
    {
        $this->legacyId = $legacyId;

        return $this;
    }
}
