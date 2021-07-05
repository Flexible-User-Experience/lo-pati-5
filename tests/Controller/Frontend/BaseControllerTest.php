<?php

namespace App\Tests\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseControllerTest extends WebTestCase
{
    public function testHomepage(): void
    {
        $client = WebTestCase::createClient();
        $client->request('GET', '/');
        self::assertResponseIsSuccessful();
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
            ['/not-found-page'],
            ['/not-found-page/inside'],
        ];
    }
}
