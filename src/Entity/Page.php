<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SlugTrait;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 * @UniqueEntity(fields={"name", "publishDate"}, errorPath="name")
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
     * @ORM\Column(type="string", length=50)
     */
    private string $type;

    /**
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    private ?string $summary = null;

    /**
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private bool $isFrontCover = false;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $publishDate;

    /**
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private bool $showPublishDate = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
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
    private ?string $urlVideo = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private ?string $urlFlickr = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $largeFooterImage = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $documentName2;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $endDate;

    // TODO set images & documents

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MenuLevel1", inversedBy="page")
     */
    private MenuLevel1 $menuLevel1;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MenuLevel2", inversedBy="page")
     */
    private MenuLevel2 $menuLevel2;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

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

    public function getUrlVideo(): ?string
    {
        return $this->urlVideo;
    }

    public function setUrlVideo(?string $urlVideo): self
    {
        $this->urlVideo = $urlVideo;

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

    public function getLargeFooterImage(): ?string
    {
        return $this->largeFooterImage;
    }

    public function setLargeFooterImage(?string $largeFooterImage): self
    {
        $this->largeFooterImage = $largeFooterImage;

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

    public function getMenuLevel1(): MenuLevel1
    {
        return $this->menuLevel1;
    }

    public function setMenuLevel1(MenuLevel1 $menuLevel1): self
    {
        $this->menuLevel1 = $menuLevel1;

        return $this;
    }

    public function getMenuLevel2(): MenuLevel2
    {
        return $this->menuLevel2;
    }

    public function setMenuLevel2(MenuLevel2 $menuLevel2): self
    {
        $this->menuLevel2 = $menuLevel2;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
