<?php

namespace App\Entity;

use App\Entity\Traits\Image1Trait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PositionTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\SlideshowRepository")
 * @Vich\Uploadable()
 */
class Slideshow extends AbstractBase
{
    use Image1Trait;
    use NameTrait;
    use PositionTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $imageAltName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private ?string $link;

    /**
     * @Assert\File(maxSize="10M", mimeTypes={"image/png", "image/jpeg", "image/pjpeg"})
     * @Vich\UploadableField(mapping="slideshow", fileNameProperty="image1FileName")
     */
    private ?File $image1File = null;

    public function getImageAltName(): ?string
    {
        return $this->imageAltName;
    }

    public function setImageAltName(?string $imageAltName): self
    {
        $this->imageAltName = $imageAltName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? $this->name : AbstractBase::DEFAULT_EMPTY_STRING;
    }
}
