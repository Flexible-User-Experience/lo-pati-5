<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

trait Document1Trait
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $document1FileName = null;

    public function getDocument1File(): ?File
    {
        return $this->document1File;
    }

    public function setDocument1File(?File $document1File): self
    {
        $this->document1File = $document1File;
        if (null !== $document1File) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getDocument1FileName(): ?string
    {
        return $this->document1FileName;
    }

    public function setDocument1FileName(?string $document1FileName): self
    {
        $this->document1FileName = $document1FileName;

        return $this;
    }
}
