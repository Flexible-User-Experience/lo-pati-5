<?php

namespace App\Menu\Frontend;

use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Repository\MenuLevel1Repository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
    private FactoryInterface $factory;
    private RequestStack $requestStack;

    public function __construct(FactoryInterface $factory, RequestStack $requestStack)
    {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
    }

    public function createMainMenu(MenuLevel1Repository $ml1r): ItemInterface
    {
        $currentRoute = '';
        $menuRoute = null;
        if ($this->requestStack->getCurrentRequest()) {
            $currentRoute = $this->requestStack->getCurrentRequest()->get('_route');
            if ($this->requestStack->getCurrentRequest()->get('menu')) {
                /** @var MenuLevel1 $menuRoute */
                $menuRoute = $this->requestStack->getCurrentRequest()->get('menu');
            }
        }
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills');
        $homepage = $menu->addChild(
            'home',
            [
                'label' => 'Home',
                'route' => 'front_app_homepage',
            ]
        );
        $homepage->setLinkAttribute('class', ($this->isHomepageRouteCurrent($currentRoute) ? 'nav-link active' : 'nav-link'));
        $homepage->setAttribute('class', 'nav-item');
        $ml1Items = $ml1r->getAllSortedByPositionAndName()->getQuery()->getResult();
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
            $item->setLinkAttribute('class', ($this->isMenuLevel1RouteCurrent($currentRoute) && $menuRoute && $menuRoute->getId() === $ml1Item->getId() ? 'nav-link active' : 'nav-link'));
            $item->setAttribute('class', 'nav-item');
            /** @var MenuLevel2 $ml2Item */
            foreach ($ml1Item->getMenuLevel2items() as $ml2Item) {
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
                $submenu->setLinkAttribute('class', 'nav-link'/*($this->isMenuLevel1RouteCurrent($currentRoute) && $menuRoute && $menuRoute->getId() === $ml1Item->getId() ? 'nav-link active' : 'nav-link')*/);
                $submenu->setAttribute('class', 'nav-item');
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
        return 'front_app_menu_level_1' === $route || 'front_app_menu_level_2' === $route;
    }
}
