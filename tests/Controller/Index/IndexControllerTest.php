<?php

namespace App\Tests\Controller\Index;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    protected $client;

    public function testCompleteScenario()
    {
        $this->client = static::createClient();

        $crawler = $this->client->request('GET', '/s/');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode(), 'Unexpected HTTP code for GET /');
    }
}
