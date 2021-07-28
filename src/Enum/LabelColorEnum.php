<?php

namespace App\Enum;

use App\Entity\MenuLevel1;

class LabelColorEnum
{
    public const BLACK = '#151920';
    public const LIGHT_GREY = '#78838C';
    public const RED = '#FF0B22';
    public const TEAL = '#59F3C1';
    public const PURPLE = '#3B1493';
    public const YELLOW = '#FFDF4A';

    public static function getEnumArray(): array
    {
        return [
            self::BLACK,
            self::LIGHT_GREY,
            self::RED,
            self::TEAL,
            self::PURPLE,
            self::YELLOW,
        ];
    }

    public static function getCssEnumArray(): array
    {
        return [
            self::BLACK => 'lp-bg-black',
            self::LIGHT_GREY => 'lp-bg-light-grey',
            self::RED => 'lp-bg-red',
            self::TEAL => 'lp-bg-teal',
            self::PURPLE => 'lp-bg-purple',
            self::YELLOW => 'lp-bg-yellow',
        ];
    }

    public static function getCssClassValueByHexColor(string $hexColor): string
    {
        return array_key_exists($hexColor, self::getCssEnumArray()) ? self::getCssEnumArray()[$hexColor] : self::getCssEnumArray()[MenuLevel1::DEFAULT_COLOR];
    }
}
