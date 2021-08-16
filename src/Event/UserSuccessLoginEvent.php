<?php

namespace App\Event;

use Symfony\Component\Security\Core\User\UserInterface;

class UserSuccessLoginEvent
{
    public const NAME = 'app.user_success_login_event';

    private UserInterface $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
