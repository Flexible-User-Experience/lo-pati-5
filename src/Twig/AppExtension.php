<?php

namespace App\Twig;

use ReflectionClass;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigTest;

class AppExtension extends AbstractExtension
{
    private TranslatorInterface $ts;

    public function __construct(TranslatorInterface $ts)
    {
        $this->ts = $ts;
    }

    public function getTests(): array
    {
        return [
            new TwigTest('instance_of', [$this, 'isInstanceOf']),
        ];
    }

    public function isInstanceOf($var, $instance): bool
    {
        $reflexionClass = new ReflectionClass($instance);

        return $reflexionClass->isInstance($var);
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('i', [$this, 'integerNumberFormattedString']),
            new TwigFilter('f', [$this, 'floatNumberFormattedString']),
        ];
    }

    public function integerNumberFormattedString(int $value): string
    {
        return number_format($value, 0, '\'', '.');
    }

    public function floatNumberFormattedString(float $value): string
    {
        return number_format($value, 2, '\'', '.');
    }
}
