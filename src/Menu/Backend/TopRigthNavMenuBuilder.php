<?php

namespace App\Menu\Backend;

use App\Entity\User;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Security;

class TopRigthNavMenuBuilder
{
    private FactoryInterface $mf;
    private Security $ss;

    public function __construct(FactoryInterface $mf, Security $ss)
    {
        $this->mf = $mf;
        $this->ss = $ss;
    }

    public function createRigthTopNavMenu(): ItemInterface
    {
        $username = '';
        $user = $this->ss->getUser();
        if ($user instanceof User) {
            $username = $user->getEmail();
        }
        $menu = $this->mf->createItem('topnav');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        $menu
            ->addChild(
                'homepage',
                [
                    'label' => '<i class="fas fa-link"></i>',
                    'route' => 'front_app_homepage',
                ]
            )
            ->setExtras(
                [
                    'safe_label' => true,
                ]
            )
        ;

        if ($username) {
            $menu
                ->addChild(
                    'username',
                    [
                        'label' => '<i class="fas fa-user" style="margin-right:5px"></i> '.$username,
                        'uri' => '#',
                    ]
                )
                ->setExtras(
                    [
                        'safe_label' => true,
                    ]
                )
            ;
        }
        $menu
            ->addChild(
                'logout',
                [
                    'label' => '<i class="fa fa-power-off text-success"></i>',
                    'route' => 'admin_app_logout',
                ]
            )
            ->setExtras(
                [
                    'safe_label' => true,
                ]
            )
        ;

        return $menu;
    }
}
