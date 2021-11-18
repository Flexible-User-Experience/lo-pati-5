<?php

namespace App\Tests\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SuperAdminUserControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = $this->getSuperAdminAuthenticatedClient();
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
            ['/admin/app/newslettergroup/1/delete'],
            ['/admin/app/newsletteruser/list'],
            ['/admin/app/newsletteruser/create'],
            ['/admin/app/newsletteruser/1/edit'],
            ['/admin/app/newsletteruser/1/delete'],
            ['/admin/app/newsletter/list'],
            ['/admin/app/newsletter/create'],
            ['/admin/app/newsletter/1/edit'],
            ['/admin/app/newsletter/1/delete'],
            ['/admin/app/newsletterpost/list'],
            ['/admin/app/newsletter/create'],
            ['/admin/app/newsletterpost/1/edit'],
            ['/admin/app/newsletterpost/1/delete'],
            ['/admin/app/artist/list'],
            ['/admin/app/artist/create'],
            ['/admin/app/artist/1/edit'],
            ['/admin/app/artist/1/delete'],
            ['/admin/app/archive/list'],
            ['/admin/app/archive/create'],
            ['/admin/app/archive/1/edit'],
            ['/admin/app/configfooterinformation/list'],
            ['/admin/app/configfooterinformation/1/edit'],
            ['/admin/app/configcalendarworkingday/list'],
            ['/admin/app/user/list'],
            ['/admin/app/user/create'],
            ['/admin/app/user/1/edit'],
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
            ['/admin/app/newsletteruser/9/edit'],
            ['/admin/app/newsletteruser/1/show'],
            ['/admin/app/newsletter/9/edit'],
            ['/admin/app/newsletter/1/show'],
            ['/admin/app/newsletterpost/9/edit'],
            ['/admin/app/newsletterpost/1/show'],
            ['/admin/app/artist/9/edit'],
            ['/admin/app/artist/1/show'],
            ['/admin/app/archive/9/edit'],
            ['/admin/app/archive/1/show'],
            ['/admin/app/archive/1/delete'],
            ['/admin/app/configfooterinformation/create'],
            ['/admin/app/configfooterinformation/9/edit'],
            ['/admin/app/configfooterinformation/1/show'],
            ['/admin/app/configfooterinformation/1/delete'],
            ['/admin/app/configcalendarworkingday/create'],
            ['/admin/app/configcalendarworkingday/9/edit'],
            ['/admin/app/configcalendarworkingday/1/show'],
            ['/admin/app/configcalendarworkingday/1/delete'],
            ['/admin/app/user/9/edit'],
            ['/admin/app/user/1/show'],
            ['/admin/app/user/1/delete'],
        ];
    }

    private function getSuperAdminAuthenticatedClient(): KernelBrowser
    {
        return WebTestCase::createClient([], [
            'PHP_AUTH_USER' => 'user2@user.com',
            'PHP_AUTH_PW'   => 'password2',
        ]);
    }
}
