<?php

namespace App\Menu\Frontend;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class LanguageBuilder
{
    public const LOCALE_CA = 'ca';
    public const LOCALE_ES = 'es';

    private FactoryInterface $factory;
    private RequestStack $requestStack;

    public function __construct(FactoryInterface $factory, RequestStack $requestStack)
    {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
    }

    public function createLanguageMenu(): ItemInterface
    {
        $currentLocale = self::LOCALE_CA;
        if ($this->requestStack->getCurrentRequest()) {
            $currentLocale = $this->requestStack->getCurrentRequest()->getLocale();
        }
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav ms-auto me-5 h-100 language');
        if (self::LOCALE_CA === $currentLocale) {
            $catalan = $menu->addChild(
                self::LOCALE_CA,
                [
                    'label' => 'CAT',
                    'uri' => '#',
                ]
            );
            $catalan->setLinkAttribute('class', 'nav-link active disabled');
            $catalan->setLinkAttribute('aria-current', 'page');
            $catalan->setLinkAttribute('aria-disabled', 'true');
        } else {
            $catalan = $menu->addChild(
                self::LOCALE_CA,
                [
                    'label' => 'CAT',
                    'route' => 'front_app_language_switcher',
                    'routeParameters' => [
                        'locale' => self::LOCALE_CA,
                    ],
                ]
            );
            $catalan->setLinkAttribute('class', 'nav-link');
        }
        $catalan->setAttribute('class', 'nav-item');
        if (self::LOCALE_ES === $currentLocale) {
            $spanish = $menu->addChild(
                self::LOCALE_ES,
                [
                    'label' => 'ESP',
                    'uri' => '#',
                ]
            );
            $spanish->setLinkAttribute('class', 'nav-link active disabled');
            $spanish->setLinkAttribute('aria-current', 'page');
            $spanish->setLinkAttribute('aria-disabled', 'true');
        } else {
            $spanish = $menu->addChild(
                self::LOCALE_ES,
                [
                    'label' => 'ESP',
                    'route' => 'front_app_language_switcher',
                    'routeParameters' => [
                        'locale' => self::LOCALE_ES,
                    ],
                ]
            );
            $spanish->setLinkAttribute('class', 'nav-link');
        }
        $spanish->setAttribute('class', 'nav-item');

        return $menu;
    }
}
