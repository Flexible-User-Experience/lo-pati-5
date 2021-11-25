<?php

namespace App\Controller\Frontend;

use App\Entity\Artist;
use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Repository\ArtistRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

final class ArtistController extends AbstractController
{
    /**
     * @Route({"ca": "/{menu}/{submenu}/artista/{slug}", "es": "/{menu}/{submenu}/{slug}"}, name="front_app_artist_detail")
     * @Entity("submenu", class="App\Entity\MenuLevel2", expr="repository.getByMenuAndSubmenuSlugs(menu, submenu)")
     * @ParamConverter("menu", class="App\Entity\MenuLevel1", options={"mapping": {"menu": "slug"}})
     */
    public function artistDetail(MenuLevel1 $menu, MenuLevel2 $submenu, string $slug, ArtistRepository $ar, KernelInterface $kernel): Response
    {
        $artists = $ar->getEnabledSortedByName()->getQuery()->getResult();
        $found = false;
        /** @var Artist $artist */
        foreach ($artists as $artist) {
            if ($artist->getSlug() === $slug) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $this->createNotFoundException();
        }

        return $this->render(
            'frontend/artist/artist_detail.html.twig',
            [
                'menu' => $menu,
                'submenu' => $submenu,
                'artists' => $artists,
                'artist' => $artist,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }
}
