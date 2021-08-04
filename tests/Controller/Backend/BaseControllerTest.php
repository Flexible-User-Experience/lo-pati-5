<?php

namespace App\Tests\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseControllerTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     */
    public function testHomepage(string $url): void
    {
        $client = WebTestCase::createClient();
        $client->request('GET', $url);
        self::assertResponseIsSuccessful();
    }

    public function provideUrls(): array
    {
        return [
            ['/admin/dashboard'],
            ['/admin/app/menulevel1/list'],
            ['/admin/app/menulevel1/create'],
            ['/admin/app/menulevel1/1/edit'],
            ['/admin/app/menulevel2/list'],
            ['/admin/app/menulevel2/create'],
            ['/admin/app/menulevel2/1/edit'],
            ['/admin/app/page/list'],
            ['/admin/app/page/create'],
            ['/admin/app/page/1/edit'],
            ['/admin/app/page/1/delete'],
            ['/admin/app/newslettergroup/list'],
            ['/admin/app/newslettergroup/create'],
            ['/admin/app/newslettergroup/1/edit'],
            ['/admin/app/newsletteruser/list'],
            ['/admin/app/newsletteruser/create'],
            ['/admin/app/newsletteruser/1/edit'],
        ];
    }

    /**
     * @dataProvider provideNotFoundUrls
     */
    public function testNotFoundPages(string $url): void
    {
        $client = WebTestCase::createClient();
        $client->request('GET', $url);
        self::assertResponseStatusCodeSame(404);
    }

    public function provideNotFoundUrls(): array
    {
        return [
            ['/admin/app/menulevel1/9/edit'],
            ['/admin/app/menulevel1/1/show'],
            ['/admin/app/menulevel1/1/delete'],
            ['/admin/app/menulevel2/9/edit'],
            ['/admin/app/menulevel2/1/show'],
            ['/admin/app/menulevel2/1/delete'],
            ['/admin/app/page/9/edit'],
            ['/admin/app/page/1/show'],
            ['/admin/app/newslettergroup/9/edit'],
            ['/admin/app/newslettergroup/1/show'],
            ['/admin/app/newslettergroup/1/delete'],
            ['/admin/app/newsletteruser/9/edit'],
            ['/admin/app/newsletteruser/1/show'],
            ['/admin/app/newsletteruser/1/delete'],
        ];
    }
}
