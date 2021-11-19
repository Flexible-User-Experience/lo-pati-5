<?php

namespace App\Command;

use App\Entity\AbstractBase;
use App\Entity\MenuLevel1;
use App\Entity\Translation\MenuLevel1Translation;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvMenuLevel1TranslationsCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:menu:level1:translations');
        $this->setDescription('Import a menu level 1 translations CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ml1r = $this->em->getRepository(MenuLevel1::class);
        $ml1tr = $this->em->getRepository(MenuLevel1Translation::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 5) {
                $serachedMenuLevel1Id = (int) $this->readColumn(1, $data);
                $searchedMenuLevel1 = $ml1r->find($serachedMenuLevel1Id);
                if ($searchedMenuLevel1) {
                    $serachedMenuLevel1TranslationLocale = $this->readColumn(2, $data);
                    $serachedMenuLevel1TranslationField = $this->fieldNameConversion($this->readColumn(3, $data));
                    $serachedMenuLevel1Translation = $ml1tr->findOneBy([
                        'object' => $searchedMenuLevel1,
                        'locale' => $serachedMenuLevel1TranslationLocale,
                        'field' => $serachedMenuLevel1TranslationField,
                    ]);
                    if (!$serachedMenuLevel1Translation) {
                        $serachedMenuLevel1Translation = new MenuLevel1Translation();
                        $serachedMenuLevel1Translation
                            ->setObject($searchedMenuLevel1)
                            ->setLocale($serachedMenuLevel1TranslationLocale)
                            ->setField($serachedMenuLevel1TranslationField)
                        ;
                        ++$newRecords;
                        $this->em->persist($serachedMenuLevel1Translation);
                    }
                    $serachedMenuLevel1Translation->setContent($this->readColumn(4, $data));
                    if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                        $this->em->flush();
                    }
                    if ($input->getOption('show-data')) {
                        $output->writeln(implode(self::CSV_DELIMITER, $data));
                    }
                } else {
                    // error ml1 related entity not found
                    $output->writeln('Menu level 1 #"'.$this->readColumn(1, $data).'" <error>NOT FOUND ERROR</error>');
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
