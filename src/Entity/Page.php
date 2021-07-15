<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SlugTrait;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="published_date_name_unique_idx", columns={"name", "publish_date"})})
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 * @UniqueEntity(fields={"name", "publishDate"}, errorPath="name")
 * @Vich\Uploadable()
 */
class Page extends AbstractBase
{
    use DescriptionTrait;
    use NameTrait;
    use SlugTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private string $slug;

    /**
     * @ORM\Column(type="text", length=300, nullable=true)
     */
    private ?string $summary = null;

    /**
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private bool $isFrontCover = false;

    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $publishDate;

    /**
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private bool $showPublishDate = false;

    /**
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private bool $alwaysShowOnCalendar = false;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeInterface $expirationDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $realizationDateString = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $place = null;

    /**
     * @ORM\Column(type="text", length=4000, nullable=true)
     */
    private ?string $links = null;

    /**
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private bool $showSocialNetworksSharingButtons = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $video = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private ?string $urlVimeo = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private ?string $urlFlickr = null;

    /**
     * @Assert\File(maxSize="10M", mimeTypes={"image/png", "image/jpeg", "image/pjpeg"})
     * @Vich\UploadableField(mapping="image", fileNameProperty="smallImage1FileName")
     */
    private ?File $smallImage1File = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $smallImage1FileName = null;

    /**
     * @Assert\File(maxSize="10M", mimeTypes={"image/png", "image/jpeg", "image/pjpeg"})
     * @Vich\UploadableField(mapping="image", fileNameProperty="smallImage2FileName")
     */
    private ?File $smallImage2File = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $smallImage2FileName = null;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $imageCaption = null;

    /**
     * @Assert\File(maxSize="16M")
     * @Vich\UploadableField(mapping="document", fileNameProperty="document1FileName")
     */
    private ?File $document1File = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $document1FileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $titleDocument1 = null;

    /**
     * @Assert\File(maxSize="16M")
     * @Vich\UploadableField(mapping="document", fileNameProperty="document2FileName")
     */
    private ?File $document2File = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $document2FileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $titleDocument2 = null;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeInterface $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeInterface $endDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuLevel1")
     */
    private ?MenuLevel1 $menuLevel1 = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuLevel2", inversedBy="pages")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=true)
     */
    private ?MenuLevel2 $menuLevel2 = null;

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function isFrontCover(): bool
    {
        return $this->isFrontCover;
    }

    public function setIsFrontCover(bool $isFrontCover): self
    {
        $this->isFrontCover = $isFrontCover;

        return $this;
    }

    public function getPublishDate(): DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function isShowPublishDate(): bool
    {
        return $this->showPublishDate;
    }

    public function setShowPublishDate(bool $showPublishDate): self
    {
        $this->showPublishDate = $showPublishDate;

        return $this;
    }

    public function isAlwaysShowOnCalendar(): bool
    {
        return $this->alwaysShowOnCalendar;
    }

    public function setAlwaysShowOnCalendar(bool $alwaysShowOnCalendar): self
    {
        $this->alwaysShowOnCalendar = $alwaysShowOnCalendar;

        return $this;
    }

    public function getExpirationDate(): ?DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(?DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

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

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getLinks(): ?string
    {
        return $this->links;
    }

    public function setLinks(?string $links): self
    {
        $this->links = $links;

        return $this;
    }

    public function isShowSocialNetworksSharingButtons(): bool
    {
        return $this->showSocialNetworksSharingButtons;
    }

    public function setShowSocialNetworksSharingButtons(bool $showSocialNetworksSharingButtons): self
    {
        $this->showSocialNetworksSharingButtons = $showSocialNetworksSharingButtons;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getUrlVimeo(): ?string
    {
        return $this->urlVimeo;
    }

    public function setUrlVimeo(?string $urlVimeo): self
    {
        $this->urlVimeo = $urlVimeo;

        return $this;
    }

    public function getUrlFlickr(): ?string
    {
        return $this->urlFlickr;
    }

    public function setUrlFlickr(?string $urlFlickr): self
    {
        $this->urlFlickr = $urlFlickr;

        return $this;
    }

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

    public function getImageCaption(): ?string
    {
        return $this->imageCaption;
    }

    public function setImageCaption(?string $imageCaption): self
    {
        $this->imageCaption = $imageCaption;

        return $this;
    }

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

    public function getTitleDocument1(): ?string
    {
        return $this->titleDocument1;
    }

    public function setTitleDocument1(?string $titleDocument1): self
    {
        $this->titleDocument1 = $titleDocument1;

        return $this;
    }

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

    public function getTitleDocument2(): ?string
    {
        return $this->titleDocument2;
    }

    public function setTitleDocument2(?string $titleDocument2): self
    {
        $this->titleDocument2 = $titleDocument2;

        return $this;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

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
        return $this->getId() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
