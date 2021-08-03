<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\MenuLevel1;
use App\Entity\Page;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvFetchPageMenuLevel1Command extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:fetch:page:menu:level1');
        $this->setDescription('Read a menu level 1 CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ml1r = $this->em->getRepository(MenuLevel1::class);
        $pr = $this->em->getRepository(Page::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 8) {
                $serachedMenuLevel1Name = $this->readColumn(1, $data);
                $menuLevel1 = $ml1r->findOneBy([
                    'name' => $serachedMenuLevel1Name,
                ]);
                if ($menuLevel1) {
                    $serachedPagePublishDateString = $this->readColumn(6, $data);
                    if ($serachedPagePublishDateString) {
                        $serachedPagePublishDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, $serachedPagePublishDateString);
                        if ($serachedPagePublishDate) {
                            $serachedPageName = self::sanitizeDoubleQuoteEscapeChar($this->readColumn(7, $data));
                            $page = $pr->findOneBy([
                                'publishDate' => $serachedPagePublishDate,
                                'name' => $serachedPageName,
                            ]);
                            if ($page) {
                                $menuLevel1->setPage($page);
                                ++$newRecords;
                            } else {
                                // error page name not found
                                $output->writeln('Page title "'.$serachedPageName.'" <error>NOT FOUND</error>');
                                ++$errors;
                            }
                        } else {
                            // error page publish date not found
                            $output->writeln('Page publish date "'.$serachedPagePublishDate.'" <error>NOT FOUND</error>');
                            ++$errors;
                        }
                    } else {
                        // error invalid page publish date format
                        $output->writeln('Invalid page publish date "'.$serachedPagePublishDateString.'" <error>FORMAT</error>');
                        ++$errors;
                    }
                } else {
                    // error menu level 1 not found
                    $output->writeln('Menu level 1 "'.$serachedMenuLevel1Name.'" <error>NOT FOUND</error>');
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
