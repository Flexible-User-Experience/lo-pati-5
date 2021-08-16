<?php

namespace App\Event\Listener;

use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DoctrineUserEventListener
{
    private UserPasswordHasherInterface $phs;

    public function __construct(UserPasswordHasherInterface $phs)
    {
        $this->phs = $phs;
    }

    public function prePersist(User $user): void
    {
        if ($user->getPlainPassword()) {
            $this->rehashUserPasswordField($user, $user->getPlainPassword());
        }
    }

    public function preUpdate(User $user, LifecycleEventArgs $event): void
    {
        if ($user->getPlainPassword()) {
            $this->rehashUserPasswordField($user, $user->getPlainPassword());
            $meta = $event->getObjectManager()->getClassMetadata(get_class($user));
            $event->getObjectManager()->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $user);
        }
    }

    private function rehashUserPasswordField(User $user, string $plainPassword): void
    {
        $user
            ->setPassword($this->phs->hashPassword($user, $plainPassword))
            ->eraseCredentials()
        ;
    }
}
