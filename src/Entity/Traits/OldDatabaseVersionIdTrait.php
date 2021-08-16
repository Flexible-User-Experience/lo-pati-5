<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait OldDatabaseVersionIdTrait
{
    /**
     * @ORM\Column(type="integer", nullable=false, options={"default": 0})
     */
    private int $oldDatabaseVersionId = 0;

    public function getOldDatabaseVersionId(): int
    {
        return $this->oldDatabaseVersionId;
    }

    public function setOldDatabaseVersionId(int $oldDatabaseVersionId): self
    {
        $this->oldDatabaseVersionId = $oldDatabaseVersionId;

        return $this;
    }
}
