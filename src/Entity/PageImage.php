<?php

namespace App\Entity;

use App\Entity\Traits\Image1Trait;
use App\Entity\Traits\PositionTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\PageImageRepository")
 * @Vich\Uploadable()
 */
class PageImage extends AbstractBase
{
    use Image1Trait;
    use PositionTrait;

    /**
     * @Assert\File(maxSize="10M", mimeTypes={"image/png", "image/jpeg", "image/pjpeg"})
     * @Vich\UploadableField(mapping="image", fileNameProperty="image1FileName")
     */
    private ?File $image1File = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $imageAltName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private Page $page;

    public function __construct()
    {
        $this->position = 1;
    }

    public function getImageAltName(): ?string
    {
        return $this->imageAltName;
    }

    public function setImageAltName(?string $imageAltName): self
    {
        $this->imageAltName = $imageAltName;

        return $this;
    }

    public function getPage(): Page
    {
        return $this->page;
    }

    public function setPage(Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? (string) $this->getId() : AbstractBase::DEFAULT_EMPTY_STRING;
    }
}
