<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\VisitingHours;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class InitializeVisitingHoursCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('app:initialize:visiting:hours')
            ->setDescription('Create an empty VisitingHours record')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $vhr = $this->em->getRepository(VisitingHours::class);
        $items = $vhr->findAll();
        if (0 === count($items)) {
            $visitingHours = new VisitingHours();
            $visitingHours
                ->setName(AbstractBase::DEFAULT_EMPTY_STRING)
                ->setTextLine1(AbstractBase::DEFAULT_EMPTY_STRING)
                ->setTextLine2(AbstractBase::DEFAULT_EMPTY_STRING)
            ;
            $this->em->persist($visitingHours);
            $this->em->flush();
            $output->writeln('<info>Created an empty VisitingHours record.</info>');
        } else {
            $output->writeln('<error>Previously VisitingHours record exist, nothing done.</error>');
        }

        return Command::SUCCESS;
    }
}
