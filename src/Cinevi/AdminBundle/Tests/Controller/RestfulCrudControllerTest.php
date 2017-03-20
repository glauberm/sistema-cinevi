<?php

namespace Cinevi\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class RestfulCrudControllerTest extends WebTestCase
{
    protected $client;
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

    // exit(var_dump($this->client->getResponse()->getContent()));

    public function testCompleteScenario()
    {
        $this->client = static::createClient();

        $crawler = $this->doLogin($this->username, $this->password);

        $crawler = $this->doList($crawler, $this->indexRoute);

        $crawler = $this->doAdd($crawler, $this->addLink, $this->addButton, $this->getAddArrayForm());

        $crawler = $this->doEdit($crawler, $this->itemEditFilter, $this->itemEditLink, $this->editLink, $this->editButton, $this->getEditArrayForm());

        $crawler = $this->doRemove($crawler, $this->editLink, $this->itemRemoveLink, $this->itemRemoveFilter, $this->removeButton);

        $this->otherScenarios($crawler);
    }

    protected function doLogin($username, $password)
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => $username,
            '_password' => $password,
        ));

        $this->client->submit($form);

        // Checa o login
        $this->assertTrue($this->client->getResponse()->isRedirect());

        return $this->client->followRedirect();
    }

    protected function doList($crawler, $indexRoute)
    {
        $crawler = $this->client->request('GET', '/'.$indexRoute);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Código de status HTTP inesperado para GET /'.$indexRoute);

        return $crawler;
    }

    protected function doAdd($crawler, $addLink, $addButton, $addArrayForm)
    {
        $crawler = $this->client->click($crawler->selectLink($addLink)->link());

        $form = $crawler->selectButton($addButton)->form($addArrayForm);

        $this->client->submit($form);

        return $this->client->followRedirect();
    }

    protected function doEdit($crawler, $itemEditFilter, $itemEditLink, $editLink, $editButton, $editArrayForm)
    {
        $this->assertGreaterThan(0, $crawler->filter($itemEditFilter)->count(), 'Faltando elemento '.$itemEditFilter);

        $crawler = $this->client->click($crawler->selectLink($itemEditLink)->link());

        $crawler = $this->client->click($crawler->selectLink($editLink)->link());

        $form = $crawler->selectButton($editButton)->form($editArrayForm);

        $this->client->submit($form);

        return $this->client->followRedirect();
    }

    protected function doRemove($crawler, $editLink, $itemRemoveLink, $itemRemoveFilter, $removeButton)
    {
        $crawler = $this->client->click($crawler->selectLink(stripslashes($itemRemoveLink))->link());

        $crawler = $this->client->click($crawler->selectLink($editLink)->link());

        $this->assertGreaterThan(0, $crawler->filter($itemRemoveFilter)->count(), 'Faltando elemento '.$itemRemoveFilter);

        $this->client->submit($crawler->selectButton($removeButton)->form());

        $crawler = $this->client->followRedirect();

        $this->assertNotRegExp('/'.$itemRemoveLink.'/', $this->client->getResponse()->getContent());

        return $crawler;
    }

    protected function otherScenarios($crawler)
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
