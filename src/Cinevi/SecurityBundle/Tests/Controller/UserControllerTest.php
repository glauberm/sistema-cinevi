<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;

class UserControllerTest extends RestfulCrudControllerTest
{
    // List
    protected $indexRoute = 'users';
    // Edit
    protected $itemEditFilter = 'a:contains("TesteU")';
    protected $itemEditLink = 'TesteU';
    // Remove
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
}
