<?php

namespace App\Menu\Frontend;

use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Repository\MenuLevel1Repository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class MenuBuilder
{
    private FactoryInterface $factory;
    private RequestStack $requestStack;
    private TranslatorInterface $translator;

    public function __construct(FactoryInterface $factory, RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
    }

    public function createMainMenu(MenuLevel1Repository $ml1r): ItemInterface
    {
        $currentRoute = '';
        $menuRoute = null;
        $submenuRoute = null;
        if ($this->requestStack->getCurrentRequest()) {
            $currentRoute = $this->requestStack->getCurrentRequest()->get('_route');
            if ($this->requestStack->getCurrentRequest()->get('menu')) {
                /** @var MenuLevel1 $menuRoute */
                $menuRoute = $this->requestStack->getCurrentRequest()->get('menu');
            }
            if ($this->requestStack->getCurrentRequest()->get('submenu')) {
                /** @var MenuLevel2 $submenuRoute */
                $submenuRoute = $this->requestStack->getCurrentRequest()->get('submenu');
            }
        }
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav mx-5 h-100 menu');
        $homepage = $menu->addChild(
            'home',
            [
                'label' => $this->translator->trans('front.menu.start'),
                'route' => 'front_app_homepage',
            ]
        );
        if ($this->isHomepageRouteCurrent($currentRoute)) {
            $homepage->setCurrent(true);
            $homepage->setLinkAttribute('class', 'nav-link active');
            $homepage->setLinkAttribute('aria-current', 'page');
        } else {
            $homepage->setLinkAttribute('class', 'nav-link');
        }
        $homepage->setAttribute('class', 'nav-item');
        $ml1Items = $ml1r->getEnabledSortedByPositionAndName()->getQuery()->getResult();
        /** @var MenuLevel1 $ml1Item */
        foreach ($ml1Items as $ml1Item) {
            $item = $menu->addChild(
                $ml1Item->getSlug(),
                [
                    'label' => $ml1Item->getName(),
                    'route' => 'front_app_menu_level_1',
                    'routeParameters' => [
                        'menu' => $ml1Item->getSlug(),
                    ],
                ]
            );
            $item->setChildrenAttribute('class', 'nav nav-pills');
            if ($menuRoute && $menuRoute->getId() === $ml1Item->getId()) {
                if ($this->isMenuLevel1RouteCurrent($currentRoute) || $this->isPageDetailRouteCurrent($currentRoute)) {
                    $item->setCurrent(true);
                }
                $item->setLinkAttribute('class', 'nav-link active');
                $item->setLinkAttribute('aria-current', 'page');
                $item->setAttribute('style', 'border-bottom:5px solid '.$ml1Item->getColor());
            } else {
                $item->setLinkAttribute('class', 'nav-link');
                $item->setAttribute('onmouseover', 'this.style.borderBottom=\'solid 5px '.$ml1Item->getColor().'\'');
                $item->setAttribute('onmouseout', 'this.style.borderBottom=\'solid 5px var(--bs-body-color)\'');
            }
            $item->setAttribute('class', 'nav-item text-uppercase');
            /** @var MenuLevel2 $ml2Item */
            foreach ($ml1Item->getMenuLevel2items() as $ml2Item) {
                if ($ml2Item->isActive()) {
                    $submenu = $item->addChild(
                        $ml2Item->getSlug(),
                        [
                            'label' => $ml2Item->getName(),
                            'route' => 'front_app_menu_level_2',
                            'routeParameters' => [
                                'menu' => $ml1Item->getSlug(),
                                'submenu' => $ml2Item->getSlug(),
                            ],
                        ]
                    );
                    if ($menuRoute && $submenuRoute && $menuRoute->getId() === $ml1Item->getId() && $submenuRoute->getId() === $ml2Item->getId()) {
                        $submenu->setCurrent(true);
                        $submenu->setLinkAttribute('class', 'nav-link active');
                        $submenu->setLinkAttribute('aria-current', 'page');
                        $submenu->setAttribute('style', 'border-bottom:5px solid '.$ml1Item->getColor().' !important');
                    } else {
                        $submenu->setLinkAttribute('class', 'nav-link');
                        $submenu->setAttribute('onmouseover', 'this.style.borderBottom=\'solid 5px '.$ml1Item->getColor().'\'');
                        $submenu->setAttribute('onmouseout', 'this.style.borderBottom=\'solid 5px var(--bs-body-bg)\'');
                    }
                    $submenu->setAttribute('class', 'nav-item');
                }
            }
        }

        return $menu;
    }

    private function isHomepageRouteCurrent(string $route): bool
    {
        return 'front_app_homepage' === $route;
    }

    private function isMenuLevel1RouteCurrent(string $route): bool
    {
        return 'front_app_menu_level_1' === $route;
    }

    private function isMenuLevel2RouteCurrent(string $route): bool
    {
        return 'front_app_menu_level_2' === $route;
    }

    private function isPageDetailRouteCurrent(string $route): bool
    {
        return 'front_app_page_detail' === $route;
    }
}
