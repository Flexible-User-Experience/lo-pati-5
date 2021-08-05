<?php

namespace App\Command;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Core\Security;

abstract class AbstractBaseCommand extends Command
{
    public const CSV_DELIMITER = ',';
    public const CSV_ENCLOSURE = '"';
    public const CSV_ESCAPE = '\\';
    public const CSV_BATCH_WINDOW = 100;

    protected Security $ss;
    protected EntityManagerInterface $em;
    protected Filesystem $fss;
    protected ?ConsoleCustomStyle $io = null;

    public function __construct(Security $ss, EntityManagerInterface $em, Filesystem $fss)
    {
        parent::__construct();
        $this->ss = $ss;
        $this->em = $em;
        $this->fss = $fss;
    }

    protected function configure(): void
    {
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
        $this->addOption('show-data', 's', InputOption::VALUE_NONE, 'Show readed data information');
        $this->addOption('dry-run', 'd', InputOption::VALUE_NONE, 'Don\'t persist changes into database');
    }

    public function init(): self
    {
        ini_set('auto_detect_line_endings', true);

        return $this;
    }

    /**
     * Load column data (index) from searched array (row) if exists, else throws an exception.
     *
     * @throws Exception
     */
    protected function readColumn(int $index, array $row): ?string
    {
        if (!array_key_exists($index, $row)) {
            throw new Exception('Column index '.$index.' doesn\'t exists');
        }

        return '\\N' !== $row[$index] ? $row[$index] : null;
    }

    /**
     * Read line (row) from CSV file.
     */
    protected function readRow($fr)
    {
        return fgetcsv($fr, 0, self::CSV_DELIMITER, self::CSV_ENCLOSURE, self::CSV_ESCAPE);
    }

    /**
     * Get current timestamp string with format Y/m/d H:i:s.
     */
    protected function getTimestampString(): string
    {
        return (new DateTimeImmutable())->format('Y/m/d H:i:s');
    }

    public function printCommandHeaderWelcomeAndGetConsoleStyle(InputInterface $input, OutputInterface $output): ConsoleCustomStyle
    {
        $this->io = new ConsoleCustomStyle($input, $output);
        $this->io->title('Welcome to '.$this->getName().' command line tool');

        return $this->io;
    }

    protected function initialValidation(InputInterface $input, OutputInterface $output)
    {
        // Welcome
        $this->printCommandHeaderWelcomeAndGetConsoleStyle($input, $output);

        // Initializations
        $this->init();

        // File validations
        $output->writeln('<comment>loading data, please wait...</comment>');
        $filename = $input->getArgument('filename');
        if (!$this->fss->exists($filename)) {
            throw new InvalidArgumentException('The file '.$filename.' does not exists');
        }
        $fr = fopen($filename, 'rb');
        if (!$fr) {
            throw new InvalidArgumentException('The file '.$filename.' exists but can not be readed');
        }

        return $fr;
    }

    protected function printTotals(OutputInterface $output, int $rowsRead, int $newRecords, DateTimeInterface $beginTimestamp, DateTimeInterface $endTimestamp, int $errors = 0, bool $isDryRunModeEnabled = false): void
    {
        // Print totals
        if ($isDryRunModeEnabled) {
            $this->io->note('--dry-run mode enabled (nothing changes in database)');
        }
        $output->writeln('<comment>'.$rowsRead.' rows read.</comment>');
        $output->writeln('<comment>'.$newRecords.' new records.</comment>');
        $output->writeln('<comment>'.($rowsRead - $newRecords - $errors).' updated records.</comment>');
        if ($errors > 0) {
            $output->writeln('<comment>'.$errors.' errors found</comment>');
        }
        $this->io->success('Total ellapsed time: '.$beginTimestamp->diff($endTimestamp)->format('%H:%I:%S'));
    }

    protected static function sanitizeDoubleQuoteEscapeChar($text): string
    {
        return str_replace('\"', '"', $text);
    }

    protected static function sanitizeNewLineEscapeChar($text): string
    {
        return str_replace('\\', '', $text);
    }

    protected static function sanitizeLinksWithoutProtocol($text): string
    {
        if (0 !== strpos($text, 'https://')) {
            $text = 'https://'.$text;
        }

        return $text;
    }
}
