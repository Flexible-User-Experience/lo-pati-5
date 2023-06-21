<?php

namespace App\Enum;

class LocalesEnum
{
    public const CA = 'ca';
    public const ES = 'es';

    public static function getLocalesArray(): array
    {
        return [
          self::CA,
          self::ES,
        ];
    }
}
