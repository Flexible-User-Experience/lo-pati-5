<?php

namespace App\Controller\Frontend;

use App\Entity\Archive;
use App\Entity\Artist;
use App\Entity\MenuLevel1;
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
     * @ParamConverter("artist", class="App\Entity\Archive", options={"mapping": {"slug": "slug"}})
     */
    public function artistDetail(MenuLevel1 $menu, Archive $archive, Artist $artist, KernelInterface $kernel): Response
    {
        return $this->render(
            'frontend/artist/artist_detail.html.twig',
            [
                'menu' => $menu,
                'archive' => $archive,
                'page' => $page,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }
}
