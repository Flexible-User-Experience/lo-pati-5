<?php

namespace App\Command;

use App\Entity\Artist;
use App\Entity\Translation\ArtistTranslation;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvArtistTranslationsCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:artist:translations');
        $this->setDescription('Import an artist translations CSV file');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Repository inits
        $ar = $this->em->getRepository(Artist::class);
        $atr = $this->em->getRepository(ArtistTranslation::class);

        // Print CSV rows
        $beginTimestamp = new DateTimeImmutable();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (false !== ($data = $this->readRow($fr))) {
            if (count($data) >= 5) {
                $serachedArtistId = (int) $this->readColumn(1, $data);
                $searchedArtist = $ar->findOneBy([
                    'legacyId' => $serachedArtistId,
                ]);
                if ($searchedArtist) {
                    $serachedArtistTranslationLocale = $this->readColumn(2, $data);
                    $serachedArtistTranslationField = $this->readColumn(3, $data);
                    $serachedArtistTranslation = $atr->findOneBy([
                        'object' => $searchedArtist,
                        'locale' => $serachedArtistTranslationLocale,
                        'field' => $serachedArtistTranslationField,
                    ]);
                    if (!$serachedArtistTranslation) {
                        $serachedArtistTranslation = new ArtistTranslation();
                        $serachedArtistTranslation
                            ->setObject($searchedArtist)
                            ->setLocale($serachedArtistTranslationLocale)
                            ->setField($serachedArtistTranslationField)
                        ;
                        ++$newRecords;
                        $this->em->persist($serachedArtistTranslation);
                    }
                    $serachedArtistTranslation->setContent(self::sanitizeNewLineEscapeChar($this->readColumn(4, $data)));
                    if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                        $this->em->flush();
                    }
                    if ($input->getOption('show-data')) {
                        $output->writeln(implode(self::CSV_DELIMITER, $data));
                    }
                } else {
                    $output->writeln('Artist #'.$this->readColumn(1, $data).' <error>NOT FOUND ERROR</error>');
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
