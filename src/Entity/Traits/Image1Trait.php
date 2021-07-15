<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

trait Image1Trait
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $image1FileName = null;

    public function getImage1File(): ?File
    {
        return $this->image1File;
    }

    public function setImage1File(?File $image1File): self
    {
        $this->image1File = $image1File;
        if (null !== $image1File) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getImage1FileName(): ?string
    {
        return $this->image1FileName;
    }

    public function setImage1FileName(?string $image1FileName): self
    {
        $this->image1FileName = $image1FileName;

        return $this;
    }
}
