<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function refreshUser(UserInterface $user): User
    {
        assert($user instanceof User);
        if (null === $reloadedUser = $this->findOneUserByFilterOptions(['id' => $user->getId(), 'active' => true])) {
            throw new UserNotFoundException(sprintf('User with ID "%s" could not be reloaded.', $user->getId()));
        }

        return $reloadedUser;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): User
    {
        return $this->loadUserByUsername($identifier);
    }

    private function findOneUserByFilterOptions(array $filterOptions): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy($filterOptions);
    }

    public function loadUserByUsername(string $username): User
    {
        $user = $this->findOneUserByFilterOptions([
            'email' => $username,
            'active' => true,
        ]);
        if (!$user) {
            throw new UserNotFoundException(sprintf('User with "%s" email does not exist.', $username));
        }

        return $user;
    }
}
