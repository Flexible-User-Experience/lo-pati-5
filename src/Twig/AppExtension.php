<?php

namespace App\Twig;

use App\Entity\AbstractBase;
use App\Entity\Newsletter;
use App\Enum\NewsletterStatusEnum;
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
            new TwigFilter('draw_newsletter_status', [$this, 'drawNewsletterStatusHtmlSpan']),
            new TwigFilter('i', [$this, 'integerNumberFormattedString']),
            new TwigFilter('f', [$this, 'floatNumberFormattedString']),
        ];
    }

    public function drawNewsletterStatusHtmlSpan(Newsletter $newsletter): string
    {
        $class = 'default';
        $text = AbstractBase::DEFAULT_EMPTY_STRING;
        if (NewsletterStatusEnum::WAITING === $newsletter->getStatus()) {
            $class = 'info';
            $text = '<i class="fa fa-clock-o" style="margin-right:5px"></i>'.$this->ts->trans(NewsletterStatusEnum::getEnumArray()[$newsletter->getStatus()]);
        } elseif (NewsletterStatusEnum::SENDING === $newsletter->getStatus()) {
            $class = 'warning';
            $text = '<i class="fa fa-paper-plane-o" style="margin-right:5px"></i>'.$this->ts->trans(NewsletterStatusEnum::getEnumArray()[$newsletter->getStatus()]);
        } elseif (NewsletterStatusEnum::SENDED === $newsletter->getStatus()) {
            $class = 'success';
            $text = '<i class="fa fa-check-square-o" style="margin-right:5px"></i>'.$this->ts->trans(NewsletterStatusEnum::getEnumArray()[$newsletter->getStatus()]);
        }

        return '<span class="label label-'.$class.'">'.$text.'</span>';
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
