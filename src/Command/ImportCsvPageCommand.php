<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Entity\Page;
use DateTime;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvPageCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:page');
        $this->setDescription('Read a page CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ml1r = $this->em->getRepository(MenuLevel1::class);
        $ml2r = $this->em->getRepository(MenuLevel2::class);
        $pr = $this->em->getRepository(Page::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 34) {
                $serachedMenuLevel1Name = $this->readColumn(32, $data);
                $menuLevel1 = $ml1r->findOneBy([
                    'name' => $serachedMenuLevel1Name,
                ]);
                if ($menuLevel1) {
                    $serachedMenuLevel2Name = $this->readColumn(33, $data);
                    $menuLevel2 = $ml2r->findOneBy([
                        'name' => $serachedMenuLevel2Name,
                        'menuLevel1' => $menuLevel1,
                    ]);
                    $serachedPageName = self::sanitizeDoubleQuoteEscapeChar($this->readColumn(3, $data));
                    $serachedPagePublishDate = $this->readColumn(8, $data);
                    $publishDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, $serachedPagePublishDate);
                    if ($publishDate) {
                        $page = $pr->findOneBy([
                            'name' => $serachedPageName,
                            'publishDate' => $publishDate,
                        ]);
                        if (!$page) {
                            $page = new Page();
                            $page
                                ->setName($serachedPageName)
                                ->setPublishDate($publishDate)
                            ;
                            $this->em->persist($page);
                            ++$newRecords;
                        }
                        $page
                            ->setSummary($this->readColumn(4, $data))
                            ->setDescription($this->readColumn(5, $data))
                            ->setActive((bool) $this->readColumn(6, $data))
                            ->setIsFrontCover((bool) $this->readColumn(7, $data))
                            ->setShowPublishDate((bool) $this->readColumn(9, $data))
                            ->setRealizationDateString($this->readColumn(11, $data))
                            ->setPlace($this->readColumn(12, $data))
                            ->setLinks($this->readColumn(14, $data))
                            ->setShowSocialNetworksSharingButtons((bool) $this->readColumn(15, $data))
                            ->setVideo($this->readColumn(16, $data))
                            ->setUrlVimeo($this->readColumn(17, $data))
                            ->setUrlFlickr($this->readColumn(18, $data))
                            ->setSmallImage1FileName($this->readColumn(19, $data))
                            ->setSmallImage2FileName($this->readColumn(26, $data))
                            ->setImageFileName($this->readColumn(20, $data))
                            ->setImageCaption($this->readColumn(21, $data))
                            ->setDocument1FileName($this->readColumn(22, $data))
                            ->setTitleDocument1($this->readColumn(23, $data))
                            ->setDocument2FileName($this->readColumn(24, $data))
                            ->setTitleDocument2($this->readColumn(25, $data))
                            ->setAlwaysShowOnCalendar((bool) $this->readColumn(31, $data))
                            ->setMenuLevel1($menuLevel1)
                        ;
                        if ($menuLevel2) {
                            $page->setMenuLevel2($menuLevel2);
                        }
                        $expirationDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, $this->readColumn(10, $data));
                        if ($expirationDate) {
                            $page->setExpirationDate($expirationDate);
                        }
                        $startDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, $this->readColumn(27, $data));
                        if ($startDate) {
                            $page->setStartDate($startDate);
                        }
                        $endDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATE_FORMAT, $this->readColumn(28, $data));
                        if ($endDate) {
                            $page->setEndDate($endDate);
                        }
                        $createdAtDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(29, $data));
                        if ($createdAtDate) {
                            $page->setCreatedAt($createdAtDate);
                        }
                        $updatedAtDate = DateTime::createFromFormat(AbstractBase::DATABASE_IMPORT_DATETIME_FORMAT, $this->readColumn(30, $data));
                        if ($updatedAtDate) {
                            $page->setUpdatedAt($updatedAtDate);
                        }
                        if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                            $this->em->flush();
                        }
                        if ($input->getOption('show-data')) {
                            $output->writeln(implode(self::CSV_DELIMITER, $data));
                        }
                    } else {
                        $output->writeln('Invalid publish date "'.$data[8].'" <error>PARSE ERROR</error>');
                        ++$errors;
                    }
                } else {
                    $output->writeln('Menu level 1 "'.$this->readColumn(32, $data).'" <error>NOT FOUND ERROR</error>');
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
