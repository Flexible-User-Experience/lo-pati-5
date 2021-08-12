<?php

namespace App\Command;

use App\Entity\User;
use App\Enum\UserRolesEnum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class UserAdminCreateCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('app:user:admin:create')
            ->setDescription('Create an admin user')
            ->setDefinition([
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the user as super admin'),
            ])
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $superadmin = $input->getOption('super-admin');
        $ur = $this->em->getRepository(User::class);
        $user = $ur->findOneBy([
            'email' => $email,
        ]);
        if (!$user) {
            $user = new User();
        }
        $user
            ->setEmail($email)
            ->setPassword($this->phs->hashPassword($user, $password))
            ->addRole(UserRolesEnum::ROLE_USER)
            ->addRole(UserRolesEnum::ROLE_ADMIN)
        ;
        if ($superadmin) {
            $user->addRole(UserRolesEnum::ROLE_SUPER_ADMIN);
        }
        $this->em->persist($user);
        $this->em->flush();
        $output->writeln(sprintf('Created user <comment>%s</comment>', $email));

        return Command::SUCCESS;
    }
}
