<?php

namespace App\Command;

use App\Entity\ConfigCalendarWorkingDay;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvConfigCalendarWorkingDayCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:config:calendar:working:day');
        $this->setDescription('Import a config calendar working day CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ccwdr = $this->em->getRepository(ConfigCalendarWorkingDay::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 4) {
                $serachedConfigCalendarWorkingDayNumber = $this->readColumn(1, $data);
                $configCalendarWorkingDay = $ccwdr->findOneBy([
                    'workingDayNumber' => $serachedConfigCalendarWorkingDayNumber,
                ]);
                if (!$configCalendarWorkingDay) {
                    $configCalendarWorkingDay = new ConfigCalendarWorkingDay();
                    ++$newRecords;
                }
                $configCalendarWorkingDay
                    ->setWorkingDayNumber($serachedConfigCalendarWorkingDayNumber)
                    ->setName($this->readColumn(2, $data))
                    ->setActive((bool) $this->readColumn(3, $data))
                ;
                $this->em->persist($configCalendarWorkingDay);
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
