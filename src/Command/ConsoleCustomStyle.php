<?php

namespace App\Command;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ConsoleCustomStyle extends SymfonyStyle
{
    private BufferedOutput $bufferedOutput;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        parent::__construct($input, $output);
        $this->bufferedOutput = new BufferedOutput($output->getVerbosity(), false, clone $output->getFormatter());
    }

    public function title($message): void
    {
        $this->writeln([
            sprintf('<info>%s</info>', OutputFormatter::escapeTrailingBackslash($message)),
            sprintf('<info>%s</info>', str_repeat('=', Helper::strlenWithoutDecoration($this->getFormatter(), $message))),
        ]);
    }

    public function section($message): void
    {
        $this->autoPrependBlock();
        $this->writeln([
            sprintf('<info>%s</info>', OutputFormatter::escapeTrailingBackslash($message)),
            sprintf('<info>%s</info>', str_repeat('-', Helper::strlenWithoutDecoration($this->getFormatter(), $message))),
        ]);
    }

    public function table(array $headers, array $rows): void
    {
        $style = clone Table::getStyleDefinition('box');
        $style->setCellHeaderFormat('<info>%s</info>');
        $style->setCellRowFormat('<comment>%s</comment>');
        $table = new Table($this);
        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->setStyle($style);
        $table->render();
    }

    public function text($message): void
    {
        $messages = is_array($message) ? array_values($message) : [$message];
        foreach ($messages as $iteratedMessage) {
            $this->writeln(sprintf('<comment>%s</comment>', $iteratedMessage));
        }
    }

    public function error($message): void
    {
        $this->block($message, 'ERROR', 'fg=black;bg=red', ' ', true);
    }

    private function autoPrependBlock(): void
    {
        $chars = substr(str_replace(PHP_EOL, "\n", $this->bufferedOutput->fetch()), -2);
        if (!isset($chars[0])) {
            $this->newLine();

            return;
        }
        $this->newLine(2 - substr_count($chars, "\n"));
    }
}
