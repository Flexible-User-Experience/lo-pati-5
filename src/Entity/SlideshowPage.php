<?php

namespace App\Entity;

use App\Entity\Traits\PositionTrait;
use App\Entity\Traits\SummaryTrait;
use App\Entity\Traits\TranslationsTrait;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\SlideshowPageRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translation\SlideshowPageTranslation")
 * @Vich\Uploadable()
 */
class SlideshowPage extends AbstractBase
{
    use PositionTrait;
    use SummaryTrait;
    use TranslationsTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Translatable
     */
    private string $name;

    /**
     * @ORM\Column(type="text", length=4000, nullable=true)
     * @Gedmo\Translatable
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Translatable
     */
    private ?string $realizationDateString = null;

    /**
     * @ORM\Column(type="text", length=4000, nullable=true)
     */
    private ?string $link = null;

    /**
     * @Assert\File(maxSize="10M", mimeTypes={"image/png", "image/jpeg", "image/pjpeg"})
     * @Vich\UploadableField(mapping="image", fileNameProperty="imageFileName")
     */
    private ?File $imageFile = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $imageFileName = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuLevel1")
     */
    private ?MenuLevel1 $menuLevel1 = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuLevel2")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private ?MenuLevel2 $menuLevel2 = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Translation\SlideshowPageTranslation", mappedBy="object", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private ?Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getRealizationDateString(): ?string
    {
        return $this->realizationDateString;
    }

    public function setRealizationDateString(?string $realizationDateString): self
    {
        $this->realizationDateString = $realizationDateString;

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

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(?string $imageFileName): self
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }

    public function getMenuLevel1(): ?MenuLevel1
    {
        return $this->menuLevel1;
    }

    public function setMenuLevel1(?MenuLevel1 $menuLevel1): self
    {
        $this->menuLevel1 = $menuLevel1;

        return $this;
    }

    public function getMenuLevel2(): ?MenuLevel2
    {
        return $this->menuLevel2;
    }

    public function setMenuLevel2(?MenuLevel2 $menuLevel2): self
    {
        $this->menuLevel2 = $menuLevel2;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() && $this->getName() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
