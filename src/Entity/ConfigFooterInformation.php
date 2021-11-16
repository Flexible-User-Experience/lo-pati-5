<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\ConfigFooterInformationRepository")
 * Gedmo\TranslationEntity(class="LoPati\BlogBundle\Entity\Translation\ConfiguracioTranslation")
 */
final class ConfigFooterInformation extends AbstractBase
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
    private ?string $colaborator = null;

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

    public function getColaborator(): ?string
    {
        return $this->colaborator;
    }

    public function setColaborator(?string $colaborator): self
    {
        $this->colaborator = $colaborator;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() ? $this->getAddress() : self::DEFAULT_EMPTY_STRING;
    }
}
