<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\Newsletter;
use App\Entity\NewsletterPost;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvNewsletterPostCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:newsletter:post');
        $this->setDescription('Import a newsletter post CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $nr = $this->em->getRepository(Newsletter::class);
        $npr = $this->em->getRepository(NewsletterPost::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 16) {
                if ($input->getOption('show-data')) {
                    $output->writeln(implode(self::CSV_DELIMITER, $data));
                }
                $serachedNewsletterOldDatabaseVersionId = (int) $this->readColumn(15, $data);
                $newsletter = $nr->findOneBy([
                    'oldDatabaseVersionId' => $serachedNewsletterOldDatabaseVersionId,
                ]);
                if ($newsletter) {
                    $serachedNewsletterPostOldDatabaseVersionId = (int) $this->readColumn(0, $data);
                    $newsletterPost = $npr->find($serachedNewsletterPostOldDatabaseVersionId);
                    if (!$newsletterPost) {
                        $newsletterPost = new NewsletterPost();
                        $newsletterPost
                            ->setOldDatabaseVersionId($serachedNewsletterPostOldDatabaseVersionId)
                            ->setNewsletter($newsletter)
                        ;
                        $this->em->persist($newsletterPost);
                        ++$newRecords;
                    }
                    $newsletterPost
                        ->setTitle(AbstractBaseCommand::sanitizeDoubleQuoteEscapeChar($this->readColumn(2, $data)))
                        ->setImage1FileName($this->readColumn(3, $data))
                        ->setShortDescription(AbstractBaseCommand::sanitizeDoubleQuoteEscapeChar($this->readColumn(4, $data)))
                        ->setDescription(AbstractBaseCommand::sanitizeDoubleQuoteEscapeChar($this->readColumn(5, $data)))
                        ->setPosition((int) $this->readColumn(6, $data))
                        ->setLink($this->readColumn(7, $data))
                        ->setIntervalDateText(AbstractBaseCommand::sanitizeDoubleQuoteEscapeChar($this->readColumn(12, $data)))
                        ->setType((int) $this->readColumn(13, $data))
                    ;
                    $date = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, $this->readColumn(8, $data));
                    if ($date) {
                        $newsletterPost->setDate($date);
                    }
                    $createdAtDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(9, $data));
                    if ($createdAtDate) {
                        $newsletterPost->setCreatedAt($createdAtDate);
                    }
                    $updatedAtDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(10, $data));
                    if ($updatedAtDate) {
                        $newsletterPost->setUpdatedAt($updatedAtDate);
                    }
                    $endDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, $this->readColumn(11, $data));
                    if ($endDate) {
                        $newsletterPost->setEndDate($endDate);
                    }
                    if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                        $this->em->flush();
                    }
                } else {
                    // error no related newsletter found
                    $output->writeln('No Newsletter with subject "'.$serachedNewsletterSubject.'" <error>ERROR FOUND</error>');
                    ++$errors;
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
