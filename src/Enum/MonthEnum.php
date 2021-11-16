<?php

namespace App\Enum;

final class MonthEnum
{
    public const JANUARY = 1;
    public const FEBRAURY = 2;
    public const MARCH = 3;
    public const APRIL = 4;
    public const MAY = 5;
    public const JUNE = 6;
    public const JULY = 7;
    public const AUGUST = 8;
    public const SEPTEMBER = 9;
    public const OCTOBER = 10;
    public const NOVEMBER = 11;
    public const DECEMBER = 12;

    public static function getEnumArray(): array
    {
        return [
            self::JANUARY => 'enum.month.january',
            self::FEBRAURY => 'enum.month.febraury',
            self::MARCH => 'enum.month.march',
            self::APRIL => 'enum.month.april',
            self::MAY => 'enum.month.may',
            self::JUNE => 'enum.month.june',
            self::JULY => 'enum.month.july',
            self::AUGUST => 'enum.month.august',
            self::SEPTEMBER => 'enum.month.september',
            self::OCTOBER => 'enum.month.october',
            self::NOVEMBER => 'enum.month.november',
            self::DECEMBER => 'enum.month.december',
        ];
    }

    public static function getReversedEnumArray(): array
    {
        return array_flip(self::getEnumArray());
    }
}
