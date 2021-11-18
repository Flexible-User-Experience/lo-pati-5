<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\ConfigFooterInformationRepository")
 * Gedmo\TranslationEntity(class="LoPati\BlogBundle\Entity\Translation\ConfiguracioTranslation")
 */
class ConfigFooterInformation extends AbstractBase
{
    /**
     * @ORM\Column(type="text", length=10000, nullable=true)
     */
    private ?string $address = null;

    /**
     * @ORM\Column(type="text", length=10000, nullable=true)
     * Gedmo\Translatable
     */
    private ?string $timetable = null;

    /**
     * @ORM\Column(type="text", length=10000, nullable=true)
     * Gedmo\Translatable
     */
    private ?string $organizer = null;

    /**
     * @ORM\Column(type="text", length=10000, nullable=true)
     * Gedmo\Translatable
     */
    private ?string $collaborator = null;

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
