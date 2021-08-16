<?php

namespace App\Event\Listener;

use App\Entity\User;
use App\Event\UserSuccessLoginEvent;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class UserSuccessLoginEventListener
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onUserSuccessLogin(UserSuccessLoginEvent $event): void
    {
        /** @var User $user */
        $user = $event->getUser();
        $user
            ->setLastLogin(new DateTimeImmutable())
            ->addLoginCount()
        ;
        $this->em->flush();
    }
}
