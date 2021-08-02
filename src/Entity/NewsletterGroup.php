<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterGroupRepository")
 * @UniqueEntity("name")
 */
class NewsletterGroup extends AbstractBase
{
    use NameTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private string $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\NewsletterUser", inversedBy="groups", orphanRemoval=true)
     * @ORM\OrderBy({"email"="ASC"})
     */
    private ?Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getUsers(): ?Collection
    {
        return $this->users;
    }

    public function setUsers(?Collection $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function addUser(NewsletterUser $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(NewsletterUser $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? $this->name : AbstractBase::DEFAULT_EMPTY_STRING;
    }
}
