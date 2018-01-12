<?php

namespace AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// exit(var_dump($this->client->getResponse()->getContent()));

abstract class AbstractCrudControllerTest extends WebTestCase
{
    protected $client;
    protected $username = 'admin';
    protected $password = '12345678';
    protected $indexRoute;
    protected $addLink = 'Adicionar';
    protected $addButton = 'Adicionar';
    protected $itemEditFilter;
    protected $itemEditLink;
    protected $editLink = 'Editar';
    protected $editButton = 'Editar';
    protected $itemRemoveLink;
    protected $itemRemoveFilter;
    protected $removeButton = 'Remover';

    public function testCompleteScenario()
    {
        $this->client = static::createClient();

        $crawler = $this->doLogin($this->username, $this->password);

        $crawler = $this->doList($crawler, $this->indexRoute);

        $crawler = $this->doAdd($crawler, $this->addLink, $this->addButton, $this->getAddArrayForm());

        $crawler = $this->doEdit($crawler, $this->itemEditFilter, $this->itemEditLink, $this->editLink, $this->editButton, $this->getEditArrayForm());

        $crawler = $this->doRemove($crawler, $this->editLink, $this->itemRemoveLink, $this->itemRemoveFilter, $this->removeButton);

        $crawler = $this->otherScenarios($crawler);
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

    protected function doList($crawler, $indexRoute)
    {
        $crawler = $this->client->request('GET', '/'.$indexRoute.'/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Unexpected HTTP code for GET /'.$indexRoute);

        $crawler = $this->doAfterList($crawler);

        return $crawler;
    }

    protected function doAdd($crawler, $addLink, $addButton, $addArrayForm)
    {
        $crawler = $this->client->click($crawler->selectLink($addLink)->link());

        $form = $crawler->selectButton($addButton)->form($addArrayForm);

        $this->client->enableProfiler();

        $this->client->submit($form);

        $crawler = $this->doAfterAdd($crawler);

        return $this->client->followRedirect();
    }

    protected function doEdit($crawler, $itemEditFilter, $itemEditLink, $editLink, $editButton, $editArrayForm)
    {
        $this->assertGreaterThan(0, $crawler->filter($itemEditFilter)->count(), 'Faltando elemento '.$itemEditFilter);

        $crawler = $this->client->click($crawler->selectLink($itemEditLink)->link());

        $crawler = $this->doAfterShow($crawler);

        $crawler = $this->client->click($crawler->selectLink($editLink)->link());

        $form = $crawler->selectButton($editButton)->form($editArrayForm);

        $this->client->enableProfiler();

        $this->client->submit($form);

        $crawler = $this->doAfterEdit($crawler);

        return $this->client->followRedirect();
    }

    protected function doRemove($crawler, $editLink, $itemRemoveLink, $itemRemoveFilter, $removeButton)
    {
        $crawler = $this->client->click($crawler->selectLink(stripslashes($itemRemoveLink))->link());

        $crawler = $this->client->click($crawler->selectLink($editLink)->link());

        $this->assertGreaterThan(0, $crawler->filter($itemRemoveFilter)->count(), 'Faltando elemento '.$itemRemoveFilter);

        $this->client->submit($crawler->selectButton($removeButton)->form());

        $this->client->enableProfiler();

        $crawler = $this->doAfterRemove($crawler);

        $crawler = $this->client->followRedirect();

        $this->assertNotRegExp('/'.$itemRemoveLink.'/', $this->client->getResponse()->getContent());

        return $crawler;
    }

    protected function checkSendMail($twig, $obj, $path, $subject, $to, $template, $message)
    {
        $from = 'contato@cinemauff.com.br';

        $this->assertEquals($subject, $message->getSubject());
        $this->assertEquals($from, key($message->getFrom()));
        $this->assertEquals($to, key($message->getTo()));
        $this->assertEquals(
            $twig->render(
                $template.'.html.twig',
                array(
                    'item' => $obj,
                    'url' => $path,
                    'subject' => $subject,
                    'to' => $to,
                )
            ),
            $message->getBody()
        );
    }

    protected function getAddArrayForm() { return; }

    protected function getEditArrayForm() { return; }

    protected function doAfterList($crawler) { return $crawler; }

    protected function doAfterAdd($crawler) { return $crawler; }

    protected function doAfterShow($crawler) { return $crawler; }

    protected function doAfterEdit($crawler) { return $crawler; }

    protected function doAfterRemove($crawler) { return $crawler; }

    protected function otherScenarios($crawler) { return; }
}
