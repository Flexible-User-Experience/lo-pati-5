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
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_menu_level2_name_level1_index", columns={"name", "menu_level1_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\MenuLevel2Repository")
 * @UniqueEntity(fields={"name", "menuLevel1"}, errorPath="name")
 */
class MenuLevel2 extends AbstractBase
{
    use NameTrait;
    use PositionTrait;
    use SlugTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"}, unique=false)
     */
    private string $slug;

    /**
     * @ORM\Column(type="boolean", options={"default"=0})
     */
    private bool $isList = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuLevel1", inversedBy="menuLevel2items")
     * @ORM\JoinColumn(name="menu_level1_id", referencedColumnName="id", nullable=false)
     */
    private MenuLevel1 $menuLevel1;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Page")
     */
    private ?Page $page = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="menuLevel2", cascade={"persist", "remove"})
     * @ORM\OrderBy({"publishDate"="ASC"})
     */
    private ?Collection $pages;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function isList(): bool
    {
        return $this->isList;
    }

    public function isListString(): string
    {
        return AbstractBase::transformBooleanAsString($this->isList());
    }

    public function getIsList(): bool
    {
        return $this->isList();
    }

    public function setIsList(bool $isList): self
    {
        $this->isList = $isList;

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

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getPages(): ?Collection
    {
        return $this->pages;
    }

    public function setPages(?Collection $pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages->add($page);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
        }

        return $this;
    }

    public function getHierarchyName(): string
    {
        return $this->getMenuLevel1()->getName().AbstractBase::DEFAULT_HIERARCHY_SEPARATOR.$this->getName();
    }

    public function __toString(): string
    {
        return $this->getId() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
