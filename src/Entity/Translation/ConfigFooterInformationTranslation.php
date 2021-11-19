<?php

namespace App\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="lookup_config_footer_information_unique_idx", columns={"locale", "object_id", "field"})})
 * @ORM\Entity()
 */
class ConfigFooterInformationTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ConfigFooterInformation", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}
