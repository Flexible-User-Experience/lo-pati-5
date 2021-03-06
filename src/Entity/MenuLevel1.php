<?php

namespace App\Entity;

use App\Entity\Traits\LegacyIdTrait;
use App\Entity\Traits\PositionTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TranslationsTrait;
use App\Enum\LabelColorEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_menu_level1_name_index", columns={"name"})})
 * @ORM\Entity(repositoryClass="App\Repository\MenuLevel1Repository")
 * @UniqueEntity(fields={"name"}, errorPath="name")
 * @Gedmo\TranslationEntity(class="App\Entity\Translation\MenuLevel1Translation")
 */
class MenuLevel1 extends AbstractBase
{
    use LegacyIdTrait;
    use PositionTrait;
    use SlugTrait;
    use TranslationsTrait;

    public const DEFAULT_COLOR = LabelColorEnum::TEAL;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Translatable
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private string $slug;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "#59F3C1"})
     */
    private string $color = self::DEFAULT_COLOR;

    /**
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private bool $isArchive = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MenuLevel2", mappedBy="menuLevel1")
     * @ORM\OrderBy({"position"="ASC", "name"="ASC"})
     */
    private ?Collection $menuLevel2items;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Page", cascade={"persist", "remove"})
     */
    private ?Page $page = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Translation\MenuLevel1Translation", mappedBy="object", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private ?Collection $translations;

    public function __construct()
    {
        $this->menuLevel2items = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getCssBackgroudClassColor(): string
    {
        return LabelColorEnum::getCssClassValueByHexColor($this->getColor());
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function isArchive(): bool
    {
        return $this->isArchive;
    }

    public function isArchiveString(): string
    {
        return AbstractBase::transformBooleanAsString($this->isArchive());
    }

    public function getIsArchive(): bool
    {
        return $this->isArchive();
    }

    public function setIsArchive(bool $isArchive): self
    {
        $this->isArchive = $isArchive;

        return $this;
    }

    public function getMenuLevel2items(): ?Collection
    {
        return $this->menuLevel2items;
    }

    public function setMenuLevel2items(?Collection $menuLevel2items): self
    {
        $this->menuLevel2items = $menuLevel2items;

        return $this;
    }

    public function addMenuLevel2Item(MenuLevel2 $menuLevel2Item): self
    {
        if (!$this->menuLevel2items->contains($menuLevel2Item)) {
            $this->menuLevel2items->add($menuLevel2Item);
            $menuLevel2Item->setMenuLevel1($this);
        }

        return $this;
    }

    public function removeMenuLevel2Item(MenuLevel2 $menuLevel2Item): self
    {
        $this->menuLevel2items->removeElement($menuLevel2Item);

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() && $this->getName() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
