<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use App\Entity\Traits\TranslationsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\VisitingHoursRepository")
 * @Gedmo\TranslationEntity(class="App\Entity\Translation\VisitingHoursTranslation")
 */
class VisitingHours extends AbstractBase
{
    use NameTrait;
    use TranslationsTrait;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Translatable
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Translatable
     */
    private string $textLine1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Translatable
     */
    private ?string $textLine2 = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Translation\VisitingHoursTranslation", mappedBy="object", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private ?Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getTextLine1(): string
    {
        return $this->textLine1;
    }

    public function setTextLine1(string $textLine1): self
    {
        $this->textLine1 = $textLine1;

        return $this;
    }

    public function getTextLine2(): ?string
    {
        return $this->textLine2;
    }

    public function setTextLine2(?string $textLine2): self
    {
        $this->textLine2 = $textLine2;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() && $this->getName() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
