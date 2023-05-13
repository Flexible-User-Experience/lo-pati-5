<?php

namespace App\Entity;

use App\Entity\Traits\LegacyIdTrait;
use App\Enum\LanguageEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_newsletter_user_email_index", columns={"email"}), @ORM\UniqueConstraint(name="unique_newsletter_user_token_index", columns={"token"})})
 *
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterUserRepository")
 *
 * @UniqueEntity("email")
 */
class NewsletterUser extends AbstractBase
{
    use LegacyIdTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank()
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank()
     *
     * @Assert\Email()
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $city = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $postalCode = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $phone = null;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?\DateTimeInterface $birthdate = null;

    /**
     * @ORM\Column(type="string", length=2, options={"default": "ca"})
     */
    private string $language = LanguageEnum::CA;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $token;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default": 0})
     */
    private ?int $fail = 0;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\NewsletterGroup", mappedBy="users")
     */
    protected ?Collection $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->resetToken();
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function resetToken(): self
    {
        $this->token = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);

        return $this;
    }

    public function getFail(): ?int
    {
        return $this->fail;
    }

    public function setFail(?int $fail): self
    {
        $this->fail = $fail;

        return $this;
    }

    public function getGroups(): ?Collection
    {
        return $this->groups;
    }

    public function setGroups(?Collection $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    public function addGroup(NewsletterGroup $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $group->addUser($this);
        }

        return $this;
    }

    public function removeGroup(NewsletterGroup $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeUser($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() ? $this->getEmail() : AbstractBase::DEFAULT_EMPTY_STRING;
    }
}
