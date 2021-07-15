<?php

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

trait SmallImage1Trait
{
    /**
     * @Assert\File(maxSize="10M", mimeTypes={"image/png", "image/jpeg", "image/pjpeg"})
     * @Vich\UploadableField(mapping="image", fileNameProperty="smallImage1FileName")
     */
    private ?File $smallImage1File = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $smallImage1FileName = null;

    public function getSmallImage1File(): ?File
    {
        return $this->smallImage1File;
    }

    public function setSmallImage1File(?File $smallImage1File): self
    {
        $this->smallImage1File = $smallImage1File;
        if (null !== $smallImage1File) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getSmallImage1FileName(): ?string
    {
        return $this->smallImage1FileName;
    }

    public function setSmallImage1FileName(?string $smallImage1FileName): self
    {
        $this->smallImage1FileName = $smallImage1FileName;

        return $this;
    }
}
