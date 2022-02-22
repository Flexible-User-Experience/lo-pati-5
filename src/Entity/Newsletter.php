<?php

namespace App\Entity;

use App\Entity\Traits\LegacyIdTrait;
use App\Enum\NewsletterStatusEnum;
use App\Enum\NewsletterTypeEnum;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterRepository")
 */
class Newsletter extends AbstractBase
{
    use LegacyIdTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $subject;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?DateTimeInterface $date = null;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default": 0})
     */
    private int $status = NewsletterStatusEnum::WAITING;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default": 0})
     */
    private ?int $type = NewsletterTypeEnum::NEWS;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default": 0})
     */
    private bool $tested = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $beginSend = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $endSend = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NewsletterPost", mappedBy="newsletter", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position"="ASC"})
     */
    private Collection $posts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NewsletterGroup")
     * @ORM\JoinColumn(name="newsletter_group_id", referencedColumnName="id", nullable=true)
     */
    private ?NewsletterGroup $group = null;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function getDateString(): string
    {
        return AbstractBase::transformDateAsString($this->getDate());
    }

    public function setDate(?DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getStatusTransString(): ?string
    {
        return NewsletterStatusEnum::getEnumArray()[$this->getStatus() ?? 0];
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function getTypeTransString(): ?string
    {
        return NewsletterTypeEnum::getEnumArray()[$this->getType() ?? 0];
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function isTested(): bool
    {
        return $this->tested;
    }

    public function getTested(): bool
    {
        return $this->isTested();
    }

    public function getTestedString(): string
    {
        return self::transformBooleanAsString($this->isTested());
    }

    public function setTested(bool $tested): self
    {
        $this->tested = $tested;

        return $this;
    }

    public function getBeginSend(): ?DateTimeInterface
    {
        return $this->beginSend;
    }

    public function getBeginSendString(): string
    {
        return AbstractBase::transformDateTimeAsString($this->getBeginSend());
    }

    public function setBeginSend(?DateTimeInterface $beginSend): self
    {
        $this->beginSend = $beginSend;

        return $this;
    }

    public function getEndSend(): ?DateTimeInterface
    {
        return $this->endSend;
    }

    public function setEndSend(?DateTimeInterface $endSend): self
    {
        $this->endSend = $endSend;

        return $this;
    }

    public function getPosts(): ?Collection
    {
        return $this->posts;
    }

    public function setPosts(?Collection $posts): self
    {
        $this->posts = $posts;

        return $this;
    }

    public function addPost(NewsletterPost $post): self
    {
        if (!$this->posts->contains($post)) {
            $post->setNewsletter($this);
            $this->posts->add($post);
        }

        return $this;
    }

    public function removePost(NewsletterPost $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
        }

        return $this;
    }

    public function getGroup(): ?NewsletterGroup
    {
        return $this->group;
    }

    public function setGroup(?NewsletterGroup $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function __toString(): string
    {
        return self::transformDateAsString($this->getDate()).AbstractBase::DEFAULT_SEPARATOR.$this->getSubject();
    }
}
