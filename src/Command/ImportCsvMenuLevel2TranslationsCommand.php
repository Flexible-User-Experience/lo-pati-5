<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\MenuLevel2;
use App\Entity\Translation\MenuLevel2Translation;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvMenuLevel2TranslationsCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:menu:level2:translations');
        $this->setDescription('Import a menu level 2 translations CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ml2r = $this->em->getRepository(MenuLevel2::class);
        $ml2tr = $this->em->getRepository(MenuLevel2Translation::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 5) {
                $serachedMenuLevel2Id = (int) $this->readColumn(1, $data);
                $searchedMenuLevel2 = $ml2r->findOneBy([
                    'legacyId' => $serachedMenuLevel2Id,
                ]);
                if ($searchedMenuLevel2) {
                    $serachedMenuLevel2TranslationLocale = $this->readColumn(2, $data);
                    $serachedMenuLevel2TranslationField = $this->fieldNameConversion($this->readColumn(3, $data));
                    $serachedMenuLevel2Translation = $ml2tr->findOneBy([
                        'object' => $searchedMenuLevel2,
                        'locale' => $serachedMenuLevel2TranslationLocale,
                        'field' => $serachedMenuLevel2TranslationField,
                    ]);
                    if (!$serachedMenuLevel2Translation) {
                        $serachedMenuLevel2Translation = new MenuLevel2Translation();
                        $serachedMenuLevel2Translation
                            ->setObject($searchedMenuLevel2)
                            ->setLocale($serachedMenuLevel2TranslationLocale)
                            ->setField($serachedMenuLevel2TranslationField)
                        ;
                        ++$newRecords;
                        $this->em->persist($serachedMenuLevel2Translation);
                    }
                    $serachedMenuLevel2Translation->setContent($this->readColumn(4, $data));
                    if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                        $this->em->flush();
                    }
                    if ($input->getOption('show-data')) {
                        $output->writeln(implode(self::CSV_DELIMITER, $data));
                    }
                } else {
                    $output->writeln('Menu level 2 #'.$this->readColumn(1, $data).' <error>NOT FOUND ERROR</error>');
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
        if ('nom' === $fieldName) {
            $result = 'name';
        }

        return $result;
    }
}
