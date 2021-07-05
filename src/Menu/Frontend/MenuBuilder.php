<?php

namespace App\Menu\Frontend;

use App\Entity\MenuLevel1;
use App\Repository\MenuLevel1Repository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    private FactoryInterface $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(MenuLevel1Repository $ml1r): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills');

        $homepage = $menu->addChild('Home', ['route' => 'front_app_homepage']);
        $homepage->setLinkAttribute('class', 'nav-link');
        $homepage->setAttribute('class', 'nav-item');

        $ml1Items = $ml1r->getAllSortedByPosition()->getQuery()->getResult();
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
            $item->setLinkAttribute('class', 'nav-link');
            $item->setAttribute('class', 'nav-item');
        }

        return $menu;
    }
}
