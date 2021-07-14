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

    public function __toString(): string
    {
        return $this->getId() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
