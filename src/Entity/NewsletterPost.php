<?php

namespace App\Entity;

use App\Entity\Traits\Image1Trait;
use App\Entity\Traits\PositionTrait;
use App\Enum\NewsletterTypeEnum;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterPostRepository")
 * @Vich\Uploadable
 */
class NewsletterPost extends AbstractBase
{
    use Image1Trait;
    use PositionTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private string $title;

    /**
     * @Assert\File(maxSize="10M", mimeTypes={"image/png", "image/jpeg", "image/pjpeg", "image/gif"})
     * @Vich\UploadableField(mapping="newsletter", fileNameProperty="image1FileName")
     */
    private ?File $image1File = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $shortDescription = null;

    /**
     * @ORM\Column(type="text", length=4000, nullable=true)
     */
    private ?string $description = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url
     */
    private ?string $link = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Newsletter", inversedBy="posts")
     */
    private Newsletter $newsletter;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeInterface $date = null;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeInterface $endDate = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $intervalDateText = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $type = NewsletterTypeEnum::NEWS;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

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

    public function getNewsletter(): Newsletter
    {
        return $this->newsletter;
    }

    public function setNewsletter(Newsletter $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getIntervalDateText(): ?string
    {
        return $this->intervalDateText;
    }

    public function setIntervalDateText(?string $intervalDateText): self
    {
        $this->intervalDateText = $intervalDateText;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? $this->getTitle() : AbstractBase::DEFAULT_EMPTY_STRING;
    }
}
