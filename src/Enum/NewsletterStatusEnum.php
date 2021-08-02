<?php

namespace App\Enum;

class NewsletterStatusEnum
{
    public const WAITING = 0;
    public const SENDING = 1;
    public const SENDED = 2;

    public static function getEnumArray(): array
    {
        return [
            self::WAITING => 'enum.newsletter_status.wating',
            self::SENDING => 'enum.newsletter_status.sending',
            self::SENDED => 'enum.newsletter_status.sended',
        ];
    }

    public static function getReversedEnumArray(): array
    {
        return array_flip(self::getEnumArray());
    }
}
