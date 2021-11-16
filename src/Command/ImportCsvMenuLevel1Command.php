<?php

namespace App\Command;

use App\Entity\MenuLevel1;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvMenuLevel1Command extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:menu:level1');
        $this->setDescription('Import a menu level 1 CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ml1r = $this->em->getRepository(MenuLevel1::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 6) {
                $serachedMenuLevel1Name = $this->readColumn(1, $data);
                $menuLevel1 = $ml1r->findOneBy([
                    'name' => $serachedMenuLevel1Name,
                ]);
                if (!$menuLevel1) {
                    $menuLevel1 = new MenuLevel1();
                    ++$newRecords;
                }
                $menuLevel1
                    ->setName($serachedMenuLevel1Name)
                    ->setPosition((int) $this->readColumn(2, $data))
                    ->setActive((bool) $this->readColumn(3, $data))
                    ->setIsArchive((bool) $this->readColumn(5, $data))
                ;
                $this->em->persist($menuLevel1);
                if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                    $this->em->flush();
                }
                if ($input->getOption('show-data')) {
                    $output->writeln(implode(self::CSV_DELIMITER, $data));
                }
            } else {
                $output->writeln('Not enough columns at "'.implode(self::CSV_DELIMITER, $data).'" <error>ERROR FOUND</error>');
                ++$errors;
            }
            ++$rowsRead;
        }
        if (!$input->getOption('dry-run')) {
            $this->em->flush();
        }

        // Print totals
        $endTimestamp = new DateTimeImmutable();
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp, $errors, $input->getOption('dry-run'));

        return Command::SUCCESS;
    }
}
