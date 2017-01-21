<?php

namespace AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ResfulCrudControllerTest extends WebTestCase
{
    protected $indexRoute;
    // Add
    protected $addLink;
    protected $addArrayForm = array();
    // Edit
    protected $editFilter;
    protected $editLink;
    protected $editArrayForm = array();
    protected $editButton;
    // Remove
    protected $removeLink;
    protected $removeFilter;
    protected $removeButton;
    // Login
    protected $username = 'glauber';
    protected $password = '12345678';

    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        $crawler = $this->doLogin($this->username, $this->password, $client);

        // Create a new entry in the database
        $crawler = $client->request('GET', '/'.$this->indexRoute.'/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Código de status HTTP inesperado para GET /".$this->indexRoute."/");
        $crawler = $client->click($crawler->selectLink($this->addLink)->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton($this->addLink)->form($this->addArrayForm);

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter($this->editFilter)->count(), 'Faltando elemento '.$this->editFilter);

        // Edit the entity
        $crawler = $client->click($crawler->selectLink($this->editLink)->link());

        $form = $crawler->selectButton($this->editButton)->form($this->editArrayForm);

        $client->submit($form);
        $crawler = $client->followRedirect();

        $crawler = $client->click($crawler->selectLink($this->removeLink)->link());

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter($this->removeFilter)->count(), 'Faltando elemento '.$this->removeFilter);

        // Delete the entity
        $client->submit($crawler->selectButton($this->removeButton)->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/'.$this->removeLink.'/', $client->getResponse()->getContent());

        $this->otherScenarios($client, $crawler, $form);
    }

    private function doLogin($username, $password, $client)
    {
       $crawler = $client->request('GET', '/login');
       $form = $crawler->selectButton('_submit')->form(array(
           '_username'  => $username,
           '_password'  => $password,
       ));
       $client->submit($form);

       // Checa o login
       $this->assertTrue($client->getResponse()->isRedirect());

       return $client->followRedirect();
    }

    protected function otherScenarios($client, $crawler, $form)
    {
        return;
    }
}
