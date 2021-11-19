<?php

namespace App\Command;

use App\Entity\ConfigFooterInformation;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvConfigFooterInformationCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:config:footer:information');
        $this->setDescription('Import a config footer information CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $cfir = $this->em->getRepository(ConfigFooterInformation::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 5) {
                $configFooterInformationItems = $cfir->findAll();
                if (0 === count($configFooterInformationItems)) {
                    $configFooterInformationItem = new ConfigFooterInformation();
                    $configFooterInformationItem
                        ->setAddress(AbstractBaseCommand::sanitizeNewLineEscapeChar($this->readColumn(1, $data)))
                        ->setTimetable(AbstractBaseCommand::sanitizeNewLineEscapeChar($this->readColumn(2, $data)))
                        ->setOrganizer(AbstractBaseCommand::sanitizeNewLineEscapeChar($this->readColumn(3, $data)))
                        ->setCollaborator(AbstractBaseCommand::sanitizeNewLineEscapeChar($this->readColumn(4, $data)))
                    ;
                    ++$newRecords;
                    $this->em->persist($configFooterInformationItem);
                }
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
