<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

class AppExtension extends AbstractExtension
{
    public function getTests(): array
    {
        return [
            new TwigTest('instance_of', [AppRuntime::class, 'isInstanceOf']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('has_highlited_image', [AppRuntime::class, 'hasHighlitedImage']),
            new TwigFunction('is_highlited_image_squared', [AppRuntime::class, 'isHighlitedImageSquared']),
            new TwigFunction('get_highlited_image_filter', [AppRuntime::class, 'getHighlitedImageFilter']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('draw_page_template_type', [AppRuntime::class, 'drawPageTemplateTypeHtmlSpan']),
            new TwigFilter('draw_newsletter_status', [AppRuntime::class, 'drawNewsletterStatusHtmlSpan']),
            new TwigFilter('draw_user_roles', [AppRuntime::class, 'drawUserRolesHtmlSpan']),
            new TwigFilter('i', [AppRuntime::class, 'integerNumberFormattedString']),
            new TwigFilter('f', [AppRuntime::class, 'floatNumberFormattedString']),
        ];
    }
}
