<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\ConfigFooterInformation;
use App\Entity\Translation\ConfigFooterInformationTranslation;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvConfigFooterInformationTranslationsCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:config:footer:information:translations');
        $this->setDescription('Import a config footer information translations CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $cfi = $this->em->getRepository(ConfigFooterInformation::class);
        $cfitr = $this->em->getRepository(ConfigFooterInformationTranslation::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 5) {
                $serachedConfigFooterInformationId = (int) $this->readColumn(1, $data);
                $searchedConfigFooterInformation = $cfi->find($serachedConfigFooterInformationId);
                if ($searchedConfigFooterInformation) {
                    $serachedConfigFooterInformationTranslationLocale = $this->readColumn(2, $data);
                    $serachedConfigFooterInformationTranslationField = $this->fieldNameConversion($this->readColumn(3, $data));
                    $serachedConfigFooterInformationTranslation = $cfitr->findOneBy([
                        'object' => $searchedConfigFooterInformation,
                        'locale' => $serachedConfigFooterInformationTranslationLocale,
                        'field' => $serachedConfigFooterInformationTranslationField,
                    ]);
                    if (!$serachedConfigFooterInformationTranslation) {
                        $serachedConfigFooterInformationTranslation = new ConfigFooterInformationTranslation();
                        $serachedConfigFooterInformationTranslation
                            ->setObject($searchedConfigFooterInformation)
                            ->setLocale($serachedConfigFooterInformationTranslationLocale)
                            ->setField($serachedConfigFooterInformationTranslationField)
                        ;
                        ++$newRecords;
                        $this->em->persist($serachedConfigFooterInformationTranslation);
                    }
                    $serachedConfigFooterInformationTranslation->setContent(self::sanitizeNewLineEscapeChar($this->readColumn(4, $data)));
                    if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                        $this->em->flush();
                    }
                    if ($input->getOption('show-data')) {
                        $output->writeln(implode(self::CSV_DELIMITER, $data));
                    }
                } else {
                    $output->writeln('Config footer information #'.$this->readColumn(1, $data).' <error>NOT FOUND ERROR</error>');
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
        if ('adresa' === $fieldName) {
            $result = 'address';
        } elseif ('horari' === $fieldName) {
            $result = 'timetable';
        } elseif ('organitza' === $fieldName) {
            $result = 'organizer';
        } elseif ('colabora' === $fieldName) {
            $result = 'collaborator';
        }

        return $result;
    }
}
