<?php

namespace App\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="lookup_visiting_hours_unique_idx", columns={"locale", "object_id", "field"})})
 * @ORM\Entity()
 */
class VisitingHoursTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisitingHours", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}
