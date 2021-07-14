<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PositionTrait;
use App\Entity\Traits\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_name_index", columns={"name"})})
 * @ORM\Entity(repositoryClass="App\Repository\MenuLevel1Repository")
 * @UniqueEntity(fields={"name"}, errorPath="name")
 */
class MenuLevel1 extends AbstractBase
{
    use NameTrait;
    use PositionTrait;
    use SlugTrait;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private string $slug;

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
     * @ORM\OneToOne(targetEntity="App\Entity\Page", mappedBy="menuLevel1")
     */
    private ?Page $page = null;

    public function __construct()
    {
        $this->menuLevel2items = new ArrayCollection();
    }

    public function isArchive(): bool
    {
        return $this->isArchive;
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
        return $this->getId() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
