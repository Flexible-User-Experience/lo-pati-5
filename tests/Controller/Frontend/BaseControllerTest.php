<?php

namespace App\Tests\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = WebTestCase::createClient();
    }

    /**
     * @dataProvider provideUrls
     */
    public function testHomepage(string $url): void
    {
        $this->client->request('GET', $url);
        self::assertResponseIsSuccessful();
    }

    public function provideUrls(): array
    {
        return [
            ['/sitemap/sitemap.default.xml'],
            ['/'],
            ['/menu-1/submenu-1-1'],
            ['/menu-1/submenu-1-2'],
            ['/menu-2/submenu-2-1'],
            ['/menu-2/submenu-2-2'],
            ['/menu-1/submenu-1-1/01-08-2021/page-1'],
            ['/archive/any/2020'],
            ['/politica-de-privacitat'],
            ['/accessibilitat'],
            ['/es/'],
            ['/es/menu-1/submenu-1-1'],
            ['/es/menu-1/submenu-1-2'],
            ['/es/menu-2/submenu-2-1'],
            ['/es/menu-2/submenu-2-2'],
            ['/es/menu-1/submenu-1-1/01-08-2021/page-1'],
            ['/es/politica-de-privacidad'],
            ['/es/accesibilidad'],
            ['/es/archive/ano/2020'],
        ];
    }

    /**
     * @dataProvider provideNotFoundUrls
     */
    public function testNotFoundPages(string $url): void
    {
        $this->client->request('GET', $url);
        self::assertResponseStatusCodeSame(404);
    }

    public function provideNotFoundUrls(): array
    {
        return [
            ['/not-found-page'],
            ['/not-found-page/inside'],
            ['/menu-1/submenu-1-3'],
            ['/menu-3'],
        ];
    }

    /**
     * @dataProvider provideReirectUrls
     */
    public function testRedirectPages(string $url): void
    {
        $this->client->request('GET', $url);
        self::assertResponseStatusCodeSame(302);
    }

    public function provideReirectUrls(): array
    {
        return [
            ['/menu-1'],
            ['/menu-2'],
            ['/es/menu-1'],
            ['/es/menu-2'],
            ['/archive'],
            ['/es/archive'],
        ];
    }
}
