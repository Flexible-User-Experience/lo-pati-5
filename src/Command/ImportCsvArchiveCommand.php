<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\Archive;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvArchiveCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:archive');
        $this->setDescription('Read an archive CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ar = $this->em->getRepository(Archive::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 6) {
                $serachedYear = (int) $this->readColumn(1, $data);
                $archive = $ar->findOneBy([
                    'year' => $serachedYear,
                ]);
                if (!$archive) {
                    $archive = new Archive();
                    ++$newRecords;
                }
                $archive
                    ->setYear($serachedYear)
                    ->setActive((bool) $this->readColumn(2, $data))
                    ->setSmallImage1FileName($this->readColumn(3, $data))
                    ->setSmallImage2FileName($this->readColumn(4, $data))
                ;
                $updatedAtDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(5, $data));
                if ($updatedAtDate) {
                    $archive->setUpdatedAt($updatedAtDate);
                }
                $this->em->persist($archive);
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
