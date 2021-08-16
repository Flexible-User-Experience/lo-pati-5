<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

trait Document2Trait
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $document2FileName = null;

    public function getDocument2File(): ?File
    {
        return $this->document2File;
    }

    public function setDocument2File(?File $document2File): self
    {
        $this->document2File = $document2File;
        if (null !== $document2File) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getDocument2FileName(): ?string
    {
        return $this->document2FileName;
    }

    public function setDocument2FileName(?string $document2FileName): self
    {
        $this->document2FileName = $document2FileName;

        return $this;
    }
}
