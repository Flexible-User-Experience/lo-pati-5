<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\Artist;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvArtistCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:artist');
        $this->setDescription('Read an artist CSV file');
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
        $this->addOption('show-data', 's', InputOption::VALUE_NONE, 'Show readed data information');
        $this->addOption('dry-run', 'd', InputOption::VALUE_NONE, 'Don\'t persist changes into database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ar = $this->em->getRepository(Artist::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 17) {
                $serachedName = $this->readColumn(1, $data);
                $artist = $ar->findOneBy([
                    'name' => $serachedName,
                ]);
                if (!$artist) {
                    $artist = new Artist();
                    ++$newRecords;
                }
                $artist
                    ->setName($serachedName)
                    ->setCity($this->readColumn(2, $data))
                    ->setYear((int) $this->readColumn(3, $data))
                    ->setCategory($this->readColumn(4, $data))
                    ->setSummary($this->readColumn(5, $data))
                    ->setDescription($this->readColumn(6, $data))
                    ->setImage1FileName($this->readColumn(8, $data))
                    ->setImage2FileName($this->readColumn(9, $data))
                    ->setImage3FileName($this->readColumn(10, $data))
                    ->setImage4FileName($this->readColumn(11, $data))
                    ->setImage5FileName($this->readColumn(12, $data))
                    ->setWebpage($this->readColumn(15, $data))
                    ->setDocument1FileName($this->readColumn(16, $data))
                    ->setActive((bool) $this->readColumn(7, $data))
                ;
                $createdAtDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(13, $data));
                if ($createdAtDate) {
                    $artist->setCreatedAt($createdAtDate);
                }
                $updatedAtDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(14, $data));
                if ($updatedAtDate) {
                    $artist->setUpdatedAt($updatedAtDate);
                }
                $this->em->persist($artist);
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
