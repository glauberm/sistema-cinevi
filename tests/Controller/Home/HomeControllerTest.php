<?php

namespace App\Tests\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    protected $client;

    public function testCompleteScenario()
    {
        $this->client = static::createClient();

        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Unexpected HTTP code for GET /');
    }
}
