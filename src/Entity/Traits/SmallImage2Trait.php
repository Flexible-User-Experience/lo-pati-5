<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

trait SmallImage2Trait
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $smallImage2FileName = null;

    public function getSmallImage2File(): ?File
    {
        return $this->smallImage2File;
    }

    public function setSmallImage2File(?File $smallImage2File): self
    {
        $this->smallImage2File = $smallImage2File;
        if (null !== $smallImage2File) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getSmallImage2FileName(): ?string
    {
        return $this->smallImage2FileName;
    }

    public function setSmallImage2FileName(?string $smallImage2FileName): self
    {
        $this->smallImage2FileName = $smallImage2FileName;

        return $this;
    }
}
