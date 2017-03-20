<?php

namespace Cinevi\AdminBundle\Tests\Controller;

use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;

class ConfigurationControllerTest extends RestfulCrudControllerTest
{
    // List
    protected $indexRoute = 'configurations';

    public function testCompleteScenario()
    {
        $this->client = static::createClient();

        $crawler = $this->doLogin($this->username, $this->password);

        $crawler = $this->doList($crawler, $this->indexRoute);

        $crawler = $this->doAdd($crawler, $this->addLink, $this->addButton, $this->getAddArrayForm());

        $crawler = $this->doEdit($crawler, $this->itemEditFilter, $this->itemEditLink, $this->editLink, $this->editButton, $this->getEditArrayForm());

        $this->otherScenarios($crawler);
    }

    protected function getAddArrayForm()
    {
        return array(
            'configuration[reservasFechadas]' => '1',
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'configuration[reservasFechadas]' => '0',
        );
    }

    protected function doAdd($crawler, $addLink, $addButton, $addArrayForm)
    {
        $form = $crawler->selectButton($addButton)->form($addArrayForm);

        $this->client->submit($form);

        return $this->client->followRedirect();
    }

    protected function doEdit($crawler, $itemEditFilter, $itemEditLink, $editLink, $editButton, $editArrayForm)
    {
        $crawler = $this->client->click($crawler->selectLink($editLink)->link());

        $form = $crawler->selectButton($editButton)->form($editArrayForm);

        $this->client->submit($form);

        return $this->client->followRedirect();
    }
}
