<?php

namespace App\Command;

use App\Entity\User;
use Exception;
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

    /**
     * @throws Exception
     */
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if (!$input->getArgument('email')) {
            $email = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose an email:',
                function ($email) {
                    if (empty($email)) {
                        throw new Exception('Email can not be empty');
                    }

                    return $email;
                }
            );
            $input->setArgument('email', $email);
        }
        if (!$input->getArgument('password')) {
            $password = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a password:',
                function ($password) {
                    if (empty($password)) {
                        throw new Exception('Password can not be empty');
                    }

                    return $password;
                }
            );
            $input->setArgument('password', $password);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $superadmin = $input->getOption('super-admin');
        $user = new User();
        $user
            ->setEmail($email)
            ->addRole('ROLE_USER')
            ->addRole('ROLE_ADMIN')
        ;
        if ($superadmin) {
            $user->addRole('ROLE_SUPER_ADMIN');
        }

//        $manipulator = $this->getContainer()->get('fos_user.util.user_manipulator');
//        $manipulator->create($username, $password, $email, !$inactive, $superadmin);
        $output->writeln(sprintf('Created user <comment>%s</comment>', $email));

        return Command::SUCCESS;
    }
}
