<?php

namespace App\Enum;

final class NewsletterTypeEnum
{
    public const NEWS = 0;
    public const EVENTS = 1;
    public const EXPOSITIONS = 2;
    public const RECOMMENDATIONS = 3;

    public static function getEnumArray(): array
    {
        return [
            self::NEWS => 'enum.newsletter_type.news',
            self::EVENTS => 'enum.newsletter_type.events',
            self::EXPOSITIONS => 'enum.newsletter_type.expositions',
            self::RECOMMENDATIONS => 'enum.newsletter_type.recommendations',
        ];
    }

    public static function getReversedEnumArray(): array
    {
        return array_flip(self::getEnumArray());
    }
}
