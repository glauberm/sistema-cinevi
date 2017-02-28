<?php

namespace Cinevi\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class RestfulCrudControllerTest extends WebTestCase
{
    // Login
    protected $username = 'admin';
    protected $password = '12345678';
    // List
    protected $indexRoute;
    // Add
    protected $addLink = 'Adicionar';
    protected $addArrayForm = array();
    protected $addButton = 'Salvar';
    // Edit
    protected $itemFilter;
    protected $itemLink;
    protected $editLink = 'Editar';
    protected $editArrayForm = array();
    protected $editButton = 'Salvar';
    // Remove
    protected $removeLink;
    protected $removeFilter;
    protected $removeButton = 'Remover';

    // exit(var_dump($client->getResponse()->getContent()));

    public function testCompleteScenario()
    {
        $client = static::createClient();

        $crawler = $this->doLogin($this->username, $this->password, $client);
        $crawler = $this->doList($client, $crawler);
        $crawler = $this->doAdd($client, $crawler);
        $crawler = $this->doEdit($client, $crawler);
        $crawler = $this->doRemove($client, $crawler);

        $this->otherScenarios($client, $crawler);
    }

    private function doLogin($username, $password, $client)
    {
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => $username,
            '_password' => $password,
        ));

        $client->submit($form);

        // Checa o login
        $this->assertTrue($client->getResponse()->isRedirect());

        return $client->followRedirect();
    }

    protected function doList($client, $crawler)
    {
        $crawler = $client->request('GET', '/'.$this->indexRoute);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Código de status HTTP inesperado para GET /'.$this->indexRoute);

        return $crawler;
    }

    protected function doAdd($client, $crawler)
    {
        $crawler = $client->click($crawler->selectLink($this->addLink)->link());

        $form = $crawler->selectButton($this->addButton)->form($this->addArrayForm);

        $client->submit($form);

        $crawler = $client->followRedirect();

        return $crawler;
    }

    protected function doEdit($client, $crawler)
    {
        $this->assertGreaterThan(0, $crawler->filter($this->itemFilter)->count(), 'Faltando elemento '.$this->itemFilter);

        $crawler = $client->click($crawler->selectLink($this->itemLink)->link());

        $crawler = $client->click($crawler->selectLink($this->editLink)->link());

        $form = $crawler->selectButton($this->editButton)->form($this->editArrayForm);

        $client->submit($form);

        $crawler = $client->followRedirect();

        return $crawler;
    }

    protected function doRemove($client, $crawler)
    {
        $crawler = $client->click($crawler->selectLink($this->removeLink)->link());

        $crawler = $client->click($crawler->selectLink($this->editLink)->link());

        $this->assertGreaterThan(0, $crawler->filter($this->removeFilter)->count(), 'Faltando elemento '.$this->removeFilter);

        $client->submit($crawler->selectButton($this->removeButton)->form());

        $crawler = $client->followRedirect();

        $this->assertNotRegExp('/'.$this->removeLink.'/', $client->getResponse()->getContent());

        return $crawler;
    }

    protected function otherScenarios($client, $crawler)
    {
        return;
    }
}
