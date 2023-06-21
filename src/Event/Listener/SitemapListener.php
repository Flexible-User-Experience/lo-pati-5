<?php

namespace App\Event\Listener;

use App\Entity\AbstractBase;
use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Entity\Page;
use App\Enum\LocalesEnum;
use App\Repository\MenuLevel1Repository;
use App\Repository\PageRepository;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapListener implements EventSubscriberInterface
{
    private UrlGeneratorInterface $router;
    private MenuLevel1Repository $ml1r;
    private PageRepository $pr;

    public function __construct(UrlGeneratorInterface $router, MenuLevel1Repository $ml1r, PageRepository $pr)
    {
        $this->router = $router;
        $this->ml1r = $ml1r;
        $this->pr = $pr;
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
            // Locales iterator
            foreach (LocalesEnum::getLocalesArray() as $locale) {
                // Homepage
                $url = $this->makeUrl('front_app_homepage', $locale);
                $event
                    ->getUrlContainer()
                    ->addUrl($this->makeUrlConcrete($url), 'default')
                ;
                // Menu Level 1
                $ml1Items = $this->ml1r->getEnabledSortedByPositionAndName()->getQuery()->getResult();
                /** @var MenuLevel1 $ml1Item */
                foreach ($ml1Items as $ml1Item) {
                    $url = $this->makeUrl(
                        'front_app_menu_level_1',
                        $locale,
                        [
                            'menu' => $ml1Item->getSlug(),
                        ]
                    );
                    $event
                        ->getUrlContainer()
                        ->addUrl($this->makeUrlConcrete($url), 'default')
                    ;
                    // Menu Level 2
                    /** @var MenuLevel2 $ml2Item */
                    foreach ($ml1Item->getMenuLevel2items() as $ml2Item) {
                        if ($ml2Item->isActive()) {
                            $url = $this->makeUrl(
                                'front_app_menu_level_2',
                                $locale,
                                [
                                    'menu' => $ml1Item->getSlug(),
                                    'submenu' => $ml2Item->getSlug(),
                                ]
                            );
                            $event
                                ->getUrlContainer()
                                ->addUrl($this->makeUrlConcrete($url), 'default')
                            ;
                            // Pages
                            $pages = $this->pr->getActiveItemsFromMenuLevel2SortedByPublishDate($ml2Item)->getQuery()->getResult();
                            /** @var Page $page */
                            foreach ($pages as $page) {
                                if ($page->isActive() && $page->getPublishDate()) {
                                    $url = $this->makeUrl(
                                        'front_app_page_detail',
                                        $locale,
                                        [
                                            'menu' => $ml1Item->getSlug(),
                                            'submenu' => $ml2Item->getSlug(),
                                            'date' => $page->getPublishDate()->format(AbstractBase::DATAGRID_TYPE_DATE_FORMAT),
                                            'page' => $page->getSlug(),
                                        ]
                                    );
                                    $event
                                        ->getUrlContainer()
                                        ->addUrl($this->makeUrlConcrete($url), 'default')
                                    ;
                                }
                            }
                        }
                    }
                }
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

    private function makeUrl(string $routeName, string $locale = LocalesEnum::CA, array $params = null): string
    {
        $baseParams = [
            '_locale' => $locale,
        ];
        if ($params) {
            $baseParams = array_merge($baseParams, $params);
        }

        return $this->router->generate(
            $routeName,
            $baseParams,
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
