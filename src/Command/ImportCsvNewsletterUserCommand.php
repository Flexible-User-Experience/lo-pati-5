<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\NewsletterUser;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvNewsletterUserCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:newsletter:user');
        $this->setDescription('Import a newsletter user CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $nur = $this->em->getRepository(NewsletterUser::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 13) {
                $serachedNewsletterUserEmail = $this->readColumn(1, $data);
                $newsletterUser = $nur->findOneBy([
                    'legacyId' => (int) $this->readColumn(0, $data),
                ]);
                $createdDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(4, $data));
                if ($createdDate) {
                    $searchedNewsletterUserActive = (bool) $this->readColumn(5, $data);
                    $searchedNewsletterUserFail = (int) $this->readColumn(6, $data);
                    if (true === $searchedNewsletterUserActive && 0 === $searchedNewsletterUserFail) {
                        if (!$newsletterUser) {
                            $newsletterUser = new NewsletterUser();
                            $newsletterUser
                                ->setCreatedAt($createdDate)
                                ->setUpdatedAt($createdDate)
                                ->setEmail($serachedNewsletterUserEmail)
                                ->setLegacyId((int) $this->readColumn(0, $data))
                            ;
                            $this->em->persist($newsletterUser);
                            ++$newRecords;
                        } else {
                            $newsletterUser
                                ->setLanguage($this->readColumn(2, $data))
                                ->setToken($this->readColumn(3, $data))
                                ->setActive(true)
                                ->setFail($searchedNewsletterUserFail)
                                ->setName($this->readColumn(7, $data))
                                ->setCity($this->readColumn(8, $data))
                                ->setPhone($this->readColumn(9, $data))
                                ->setPostalCode($this->readColumn(11, $data))
                            ;
                        }
                        if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                            $this->em->flush();
                        }
                    } else {
                        $output->writeln('User avoided due to inactive mark detected or fails amount > 0 <error>ERROR</error>');
                        ++$errors;
                    }
                } else {
                    $output->writeln('Invalid created date "'.$data[4].'" <error>PARSE ERROR</error>');
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
