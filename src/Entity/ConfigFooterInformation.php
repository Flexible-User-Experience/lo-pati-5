<?php

namespace App\Entity;

use App\Entity\Traits\TranslationsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\ConfigFooterInformationRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translation\ConfigFooterInformationTranslation")
 */
class ConfigFooterInformation extends AbstractBase
{
    use TranslationsTrait;

    /**
     * @ORM\Column(type="text", length=10000, nullable=true)
     * @Gedmo\Translatable
     */
    private ?string $address = null;

    /**
     * @ORM\Column(type="text", length=10000, nullable=true)
     * @Gedmo\Translatable
     */
    private ?string $timetable = null;

    /**
     * @ORM\Column(type="text", length=10000, nullable=true)
     * @Gedmo\Translatable
     */
    private ?string $organizer = null;

    /**
     * @ORM\Column(type="text", length=10000, nullable=true)
     * @Gedmo\Translatable
     */
    private ?string $collaborator = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Translation\ConfigFooterInformationTranslation", mappedBy="object", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private ?Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTimetable(): ?string
    {
        return $this->timetable;
    }

    public function setTimetable(?string $timetable): self
    {
        $this->timetable = $timetable;

        return $this;
    }

    public function getOrganizer(): ?string
    {
        return $this->organizer;
    }

    public function setOrganizer(?string $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getCollaborator(): ?string
    {
        return $this->collaborator;
    }

    public function setCollaborator(?string $collaborator): self
    {
        $this->collaborator = $collaborator;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() ?: self::DEFAULT_EMPTY_STRING;
    }
}
