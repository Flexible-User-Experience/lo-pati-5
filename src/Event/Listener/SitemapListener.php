<?php

namespace App\Event\Listener;

use App\Enum\LanguageEnum;
use App\Enum\LocalesEnum;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapListener implements EventSubscriberInterface
{
    private UrlGeneratorInterface $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }

    public function populate(SitemapPopulateEvent $event): void
    {
        $section = $event->getSection();
        if (is_null($section) || 'default' === $section) {
            // locales iterator
            foreach (LocalesEnum::getLocalesArray() as $locale) {
                // Homepage
                $url = $this->makeUrl('front_app_homepage', $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default')
                ;
                // Privacy Policy view
                $url = $this->makeUrl('front_app_privacy_policy', $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url, 0.1), 'default')
                ;
                // Accessibility view
                $url = $this->makeUrl('front_app_accessibility_statement', $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url, 0.1), 'default')
                ;
            }
        }
    }

    private function makeUrl(string $routeName, string $locale = LanguageEnum::CA): string
    {
        return $this->router->generate(
            $routeName,
            [
                '_locale' => $locale,
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    private function makeUrlConcrete(string $url, int $priority = 1, \DateTimeInterface $date = null): UrlConcrete
    {
        return new UrlConcrete(
            $url,
            $date ?? new \DateTimeImmutable(),
            UrlConcrete::CHANGEFREQ_WEEKLY,
            $priority
        );
    }
}
