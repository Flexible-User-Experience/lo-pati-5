<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait NameTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
