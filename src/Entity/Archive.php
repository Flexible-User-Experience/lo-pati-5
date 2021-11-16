<?php

namespace App\Entity;

use App\Entity\Traits\SmallImage1Trait;
use App\Entity\Traits\SmallImage2Trait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_archive_year_index", columns={"year"})})
 * @ORM\Entity(repositoryClass="App\Repository\ArchiveRepository")
 * @UniqueEntity(fields={"year"}, errorPath="year")
 * @Vich\Uploadable()
 */
final class Archive extends AbstractBase
{
    use SmallImage1Trait;
    use SmallImage2Trait;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private int $year;

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? (string) $this->getYear() : AbstractBase::DEFAULT_EMPTY_STRING;
    }
}
