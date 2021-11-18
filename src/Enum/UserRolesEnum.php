<?php

namespace App\Enum;

final class UserRolesEnum
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    public static function getEnumArray(): array
    {
        return [
            self::ROLE_USER => 'enum.user_roles.user',
            self::ROLE_ADMIN => 'enum.user_roles.admin',
            self::ROLE_SUPER_ADMIN => 'enum.user_roles.super_admin',
        ];
    }

    public static function getReversedEnumArray(): array
    {
        return array_flip(self::getEnumArray());
    }
}
