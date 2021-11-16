<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_config_calendar_working_day_index", columns={"working_day_number"})})
 * @ORM\Entity(repositoryClass="App\Repository\ConfigCalendarWorkingDayRepository")
 * @UniqueEntity("workingDayNumber")
 */
final class ConfigCalendarWorkingDay extends AbstractBase
{
    use NameTrait;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $workingDayNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $name;

    public function getWorkingDayNumber(): int
    {
        return $this->workingDayNumber;
    }

    public function setWorkingDayNumber(int $workingDayNumber): self
    {
        $this->workingDayNumber = $workingDayNumber;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
