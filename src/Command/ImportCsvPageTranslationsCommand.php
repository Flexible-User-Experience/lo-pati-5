<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\Page;
use App\Entity\Translation\PageTranslation;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvPageTranslationsCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:page:translations');
        $this->setDescription('Import a page translations CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $pr = $this->em->getRepository(Page::class);
        $ptr = $this->em->getRepository(PageTranslation::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 5) {
                $serachedPageId = (int) $this->readColumn(1, $data);
                $searchedPage = $pr->findOneBy([
                    'legacyId' => $serachedPageId,
                ]);
                if ($searchedPage) {
                    $serachedPageTranslationLocale = $this->readColumn(2, $data);
                    $serachedPageTranslationField = $this->fieldNameConversion($this->readColumn(3, $data));
                    $serachedPageTranslation = $ptr->findOneBy([
                        'object' => $searchedPage,
                        'locale' => $serachedPageTranslationLocale,
                        'field' => $serachedPageTranslationField,
                    ]);
                    if (!$serachedPageTranslation) {
                        $serachedPageTranslation = new PageTranslation();
                        $serachedPageTranslation
                            ->setObject($searchedPage)
                            ->setLocale($serachedPageTranslationLocale)
                            ->setField($serachedPageTranslationField)
                        ;
                        ++$newRecords;
                        $this->em->persist($serachedPageTranslation);
                    }
                    $serachedPageTranslation->setContent(self::sanitizeNewLineEscapeChar($this->readColumn(4, $data)));
                    if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                        $this->em->flush();
                    }
                    if ($input->getOption('show-data')) {
                        $output->writeln(implode(self::CSV_DELIMITER, $data));
                    }
                } else {
                    $output->writeln('Page #'.$this->readColumn(1, $data).' <error>NOT FOUND ERROR</error>');
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

    private function fieldNameConversion(string $fieldName): string
    {
        $result = AbstractBase::DEFAULT_EMPTY_STRING;
        if ('data_realitzacio' === $fieldName) {
            $result = 'realizationDateString';
        } elseif ('descripcio' === $fieldName) {
            $result = 'description';
        } elseif ('lloc' === $fieldName) {
            $result = 'place';
        } elseif ('peuImageGran1' === $fieldName) {
            $result = 'imageCaption';
        } elseif ('resum' === $fieldName) {
            $result = 'summary';
        } elseif ('titol' === $fieldName) {
            $result = 'name';
        }

        return $result;
    }
}
