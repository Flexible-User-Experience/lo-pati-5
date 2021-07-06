<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PositionTrait;
use App\Entity\Traits\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_subname_index", columns={"name", "menu_level1_id"})})
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

//    /**
//     * @var Page
//     *
//     * @ORM\OneToOne(targetEntity="App\Entity\Page", mappedBy="menuLevel2")
//     */
//    private $page;

    public function isList(): bool
    {
        return $this->isList;
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

//    /**
//     * @return Page
//     */
//    public function getPage()
//    {
//        return $this->page;
//    }
//
//    /**
//     * @param Page $page
//     *
//     * @return MenuLevel2
//     */
//    public function setPage($page)
//    {
//        $this->page = $page;
//
//        return $this;
//    }
}
