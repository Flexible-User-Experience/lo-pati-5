<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\Newsletter;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvNewsletterCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:newsletter');
        $this->setDescription('Read a newsletter CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $nr = $this->em->getRepository(Newsletter::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 10) {
                $serachedNewsletterOldDatabaseVersionId = (int) $this->readColumn(0, $data);
                $newsletter = $nr->findOneBy([
                    'oldDatabaseVersionId' => $serachedNewsletterOldDatabaseVersionId,
                ]);
                if (!$newsletter) {
                    $newsletter = new Newsletter();
                    $newsletter->setOldDatabaseVersionId($serachedNewsletterOldDatabaseVersionId);
                    $this->em->persist($newsletter);
                    ++$newRecords;
                }
                $newsletter
                    ->setSubject(self::sanitizeDoubleQuoteEscapeChar($this->readColumn(2, $data)))
                    ->setStatus((int) $this->readColumn(4, $data))
                    ->setType((int) $this->readColumn(5, $data))
                    ->setTested((bool) $this->readColumn(6, $data))
                ;
                $date = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, $this->readColumn(3, $data));
                if ($date) {
                    $newsletter->setDate($date);
                }
                $beginSendDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(7, $data));
                if ($beginSendDate) {
                    $newsletter->setBeginSend($beginSendDate);
                }
                if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                    $this->em->flush();
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
