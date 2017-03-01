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
    protected $addButton = 'Salvar';
    // Edit
    protected $itemEditFilter;
    protected $itemEditLink;
    protected $editLink = 'Editar';
    protected $editButton = 'Salvar';
    // Remove
    protected $itemRemoveLink;
    protected $itemRemoveFilter;
    protected $removeButton = 'Remover';

    // exit(var_dump($client->getResponse()->getContent()));

    public function testCompleteScenario()
    {
        $client = static::createClient();

        $crawler = $this->doLogin($this->username, $this->password, $client);

        $crawler = $this->doList($client, $crawler, $this->indexRoute);

        $crawler = $this->doAdd($client, $crawler, $this->addLink, $this->addButton, $this->getAddArrayForm());

        $crawler = $this->doEdit($client, $crawler, $this->itemEditFilter, $this->itemEditLink, $this->editLink, $this->editButton, $this->getEditArrayForm());

        $crawler = $this->doRemove($client, $crawler, $this->editLink, $this->itemRemoveLink, $this->itemRemoveFilter, $this->removeButton);

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

    protected function doList($client, $crawler, $indexRoute)
    {
        $crawler = $client->request('GET', '/'.$indexRoute);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Código de status HTTP inesperado para GET /'.$indexRoute);

        return $crawler;
    }

    protected function doAdd($client, $crawler, $addLink, $addButton, $addArrayForm)
    {
        $crawler = $client->click($crawler->selectLink($addLink)->link());

        $form = $crawler->selectButton($addButton)->form($addArrayForm);

        $client->submit($form);

        return $client->followRedirect();
    }

    protected function doEdit($client, $crawler, $itemEditFilter, $itemEditLink, $editLink, $editButton, $editArrayForm)
    {
        $this->assertGreaterThan(0, $crawler->filter($itemEditFilter)->count(), 'Faltando elemento '.$itemEditFilter);

        $crawler = $client->click($crawler->selectLink($itemEditLink)->link());

        $crawler = $client->click($crawler->selectLink($editLink)->link());

        $form = $crawler->selectButton($editButton)->form($editArrayForm);

        $client->submit($form);

        return $client->followRedirect();
    }

    protected function doRemove($client, $crawler, $editLink, $itemRemoveLink, $itemRemoveFilter, $removeButton)
    {
        $crawler = $client->click($crawler->selectLink($itemRemoveLink)->link());

        $crawler = $client->click($crawler->selectLink($editLink)->link());

        $this->assertGreaterThan(0, $crawler->filter($itemRemoveFilter)->count(), 'Faltando elemento '.$itemRemoveFilter);

        $client->submit($crawler->selectButton($removeButton)->form());

        $crawler = $client->followRedirect();

        $this->assertNotRegExp('/'.$itemRemoveLink.'/', $client->getResponse()->getContent());

        return $crawler;
    }

    protected function otherScenarios($client, $crawler)
    {
        return $crawler;
    }

    protected function getAddArrayForm()
    {
        return;
    }

    protected function getEditArrayForm()
    {
        return;
    }
}
