<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\Slideshow;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvSlideshowCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:slideshow');
        $this->setDescription('Read a slideshow CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $sr = $this->em->getRepository(Slideshow::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 10) {
                $serachedName = $this->readColumn(1, $data);
                $slideshow = $sr->findOneBy([
                    'name' => $serachedName,
                ]);
                if (!$slideshow) {
                    $slideshow = new Slideshow();
                    ++$newRecords;
                }
                $slideshow
                    ->setName($serachedName)
                    ->setImageAltName($this->readColumn(2, $data))
                    ->setDescription($this->readColumn(3, $data))
                    ->setLink($this->readColumn(4, $data))
                    ->setPosition((int) $this->readColumn(5, $data))
                    ->setImage1FileName($this->readColumn(7, $data))
                    ->setActive((bool) $this->readColumn(6, $data))
                ;
                $createdAtDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(8, $data));
                if ($createdAtDate) {
                    $slideshow->setCreatedAt($createdAtDate);
                }
                $updatedAtDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(9, $data));
                if ($updatedAtDate) {
                    $slideshow->setUpdatedAt($updatedAtDate);
                }
                $this->em->persist($slideshow);
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
