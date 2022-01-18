<?php

namespace App\Command;

use App\Entity\NewsletterGroup;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvNewsletterGroupCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:newsletter:group');
        $this->setDescription('Import a newsletter group CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ngr = $this->em->getRepository(NewsletterGroup::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 3) {
                $serachedNewsletterGroupName = $this->readColumn(1, $data);
                $newsletterGroup = $ngr->findOneBy([
                    'legacyId' => (int) $this->readColumn(0, $data),
                ]);
                if (!$newsletterGroup) {
                    $newsletterGroup = new NewsletterGroup();
                    $newsletterGroup->setName($serachedNewsletterGroupName);
                    $newsletterGroup->setLegacyId((int) $this->readColumn(0, $data));
                    $this->em->persist($newsletterGroup);
                    ++$newRecords;
                } else {
                    $newsletterGroup->setActive((bool) $this->readColumn(2, $data));
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
