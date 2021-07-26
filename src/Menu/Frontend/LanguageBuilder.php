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
        $menu->setChildrenAttribute('class', 'navbar-nav mx-5 h-100 language');
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
        if (self::LOCALE_CA === $currentLocale) {
            $catalan->setLinkAttribute('class', 'nav-link active');
            $catalan->setLinkAttribute('aria-current', 'page');
        } else {
            $catalan->setLinkAttribute('class', 'nav-link');
        }
        $catalan->setAttribute('class', 'nav-item');
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
        if (self::LOCALE_ES === $currentLocale) {
            $spanish->setLinkAttribute('class', 'nav-link active');
            $spanish->setLinkAttribute('aria-current', 'page');
        } else {
            $spanish->setLinkAttribute('class', 'nav-link');
        }
        $spanish->setAttribute('class', 'nav-item');

        return $menu;
    }
}
