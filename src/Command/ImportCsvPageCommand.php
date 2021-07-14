<?php

namespace App\Command;

use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Entity\Page;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportCsvPageCommand extends AbstractBaseCommand
{
    protected function configure(): void
    {
        $this->setName('app:import:page');
        $this->setDescription('Read a page CSV file');
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
        $this->addOption('show-data', 's', InputOption::VALUE_NONE, 'Show readed data information');
        $this->addOption('dry-run', 'd', InputOption::VALUE_NONE, 'Don\'t persist changes into database');
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
//                    $output->writeln($this->readColumn(32, $data));
//                    $output->writeln('ML1ID# '.$menuLevel1->getId());
//                    $output->writeln($this->readColumn(33, $data));
                    $serachedMenuLevel2Name = $this->readColumn(33, $data);
                    $menuLevel2 = $ml2r->findOneBy([
                        'name' => $serachedMenuLevel2Name,
                        'menuLevel1' => $menuLevel1,
                    ]);
                    if ($menuLevel2) {
                        $serachedMenuLevel1Name = $this->readColumn(32, $data);
                        $menuLevel1 = $ml1r->findOneBy([
                            'name' => $serachedMenuLevel1Name,
                        ]);

//                        $menuLevel2
//                            ->setMenuLevel1($menuLevel1)
//                            ->setName($serachedMenuLevel2Name)
//                            ->setPosition((int) $this->readColumn(3, $data))
//                            ->setActive((bool) $this->readColumn(4, $data))
//                            ->setIsList((bool) $this->readColumn(5, $data))
//                        ;
//                        $this->em->persist($menuLevel2);
                        if (0 === $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                            $this->em->flush();
                        }
                        if ($input->getOption('show-data')) {
                            $output->writeln(implode(self::CSV_DELIMITER, $data));
                        }
                    } else {
                        $output->writeln('Menu level 2 "'.$this->readColumn(33, $data).'" (with Menu level 1 = '.$this->readColumn(32, $data).') <error>NOT FOUND ERROR</error>');
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
