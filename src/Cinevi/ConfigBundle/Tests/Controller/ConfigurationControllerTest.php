<?php

namespace Cinevi\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConfigurationControllerTest extends WebTestCase
{
    protected $client;
    protected $username = 'admin';
    protected $password = '12345678';
    protected $indexRoute = 's/configuracoes';
    protected $editLink = 'Editar';
    protected $editButton = 'Salvar';

    public function testCompleteScenario()
    {
        $this->client = static::createClient();

        $crawler = $this->doLogin($this->username, $this->password);

        $crawler = $this->doEdit($crawler, $this->indexRoute, $this->editLink, $this->editButton, $this->getEditArrayForm());
    }

    protected function doLogin($username, $password)
    {
        $crawler = $this->client->request('GET', '/entrar');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => $username,
            '_password' => $password,
        ));

        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect());

        return $this->client->followRedirect();
    }

    protected function getEditArrayForm()
    {
        return array(
            'config[reservasFechadas]' => '1',
        );
    }

    protected function doEdit($crawler, $indexRoute, $editLink, $editButton, $editArrayForm)
    {
        $crawler = $this->client->request('GET', '/'.$indexRoute);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Unexpected HTTP code for GET /'.$indexRoute);

        $crawler = $this->client->click($crawler->selectLink($editLink)->link());

        $form = $crawler->selectButton($editButton)->form($editArrayForm);

        $this->client->submit($form);

        return $this->client->followRedirect();
    }
}
