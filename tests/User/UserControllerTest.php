<?php

namespace App\Tests\User;

use App\Tests\Admin\AbstractCrudControllerTest;

class UserControllerTest extends AbstractCrudControllerTest
{
    protected $indexRoute = 's/usuarios';
    protected $itemEditFilter = 'h1:contains("TesteU")';
    protected $itemEditLink = 'TesteU';
    protected $itemRemoveLink = 'UEtset';
    protected $itemRemoveFilter = '[value="UEtset"]';


    protected function getAddArrayForm()
    {
        return array(
            'user[username]' => 'TesteU',
            'user[email]' => 'glaubernm@gmail.com',
            'user[plainPassword][first]' => '12345678',
            'user[plainPassword][second]' => '12345678',
            'user[matricula]' => '15455758',
            'user[telefone]' => '21997963685',
            'user[confirmado]' => '0',
            'user[enabled]' => '0',
            'user[professor]' => '0',
            'user[breveCurriculo]' => 'Lorem Ipsum Dolor sit Amet.',
            'user[roles]' => array('ROLE_DEPARTAMENTO'),
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'user[username]' => 'UEtset',
            'user[email]' => 'glaubernm@hotmail.com',
            'user[matricula]' => '1545575899',
            'user[telefone]' => '6297963685',
            'user[confirmado]' => '1',
            'user[enabled]' => '1',
            'user[professor]' => '1',
            'user[breveCurriculo]' => '9Lorem Ipsum Dolor sit Amet.',
            'user[roles]' => array('ROLE_DEPARTAMENTO'),
        );
    }

    protected function doAfterList($crawler)
    {
        $crawler = $this->client->click($crawler->selectLink('Nome Completo')->link());
        $crawler = $this->client->click($crawler->selectLink('Matrícula/SIAPE')->link());
        $crawler = $this->client->click($crawler->selectLink('Ativo')->link());
        $crawler = $this->client->click($crawler->selectLink('Confirmado')->link());
        $crawler = $this->client->click($crawler->selectLink('Professor')->link());

        return $crawler;
    }

    protected function otherScenarios($crawler)
    {
        $crawler = $this->client->request('GET', '/perfil');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), 'Unexpected HTTP code for GET /perfil');

        $crawler = $this->client->click($crawler->selectLink('Editar')->link());

        $form = $crawler->selectButton('Editar')->form(
            array(
                'fos_user_profile_form[username]' => 'admin',
                'fos_user_profile_form[email]' => 'glaubercinema7@gmail.com',
                'fos_user_profile_form[current_password]' => '12345678',
                'fos_user_profile_form[telefone]' => '6297963685',
                'fos_user_profile_form[matricula]' => '1545575899',
                'fos_user_profile_form[breveCurriculo]' => 'Lorem Ipsum Dolor Sit Amet.',
            )
        );

        $this->client->submit($form);

        return $this->client->followRedirect();
    }
}
