<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait DescriptionTrait
{
    /**
     * @ORM\Column(type="text", length=4000)
     */
    private string $description;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
