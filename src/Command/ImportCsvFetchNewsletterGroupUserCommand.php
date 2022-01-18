<?php

namespace App\Command;

use App\Entity\NewsletterGroup;
use App\Entity\NewsletterUser;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvFetchNewsletterGroupUserCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:fetch:newsletter:group:user');
        $this->setDescription('Fetch a newsletter group has user CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ngr = $this->em->getRepository(NewsletterGroup::class);
        $nur = $this->em->getRepository(NewsletterUser::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 4) {
                $serachedNewsletterGroupName = $this->readColumn(2, $data);
                $newsletterGroup = $ngr->findOneBy([
                    'legacyId' => (int) $this->readColumn(0, $data),
                ]);
                if ($newsletterGroup) {
                    $serachedNewsletterUserEmail = $this->readColumn(3, $data);
                    $newsletterUser = $nur->findOneBy([
                        'legacyId' => (int) $this->readColumn(1, $data),
                    ]);
                    if ($newsletterUser) {
                        $newsletterGroup->addUser($newsletterUser);
                        ++$newRecords;
                    } else {
                        // error newsletter user not found
                        $output->writeln('Newsletter user "'.$serachedNewsletterUserEmail.'" <error>NOT FOUND</error>');
                        ++$errors;
                    }
                } else {
                    // error newsletter group not found
                    $output->writeln('Newsletter group "'.$serachedNewsletterGroupName.'" <error>NOT FOUND</error>');
                    ++$errors;
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
