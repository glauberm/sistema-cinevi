<?php

namespace App\Tests\Controller\Almoxarifado;

use Doctrine\ORM\EntityManager;
use App\Tests\Controller\Admin\AbstractCrudControllerTest;
use App\Entity\Categoria;

/**
 * @TODO: Email tests.
 */
class EquipamentoControllerTest extends AbstractCrudControllerTest
{
    protected $indexRoute = 's/reservaveis';
    protected $itemEditFilter = 'a:contains("TesteE")';
    protected $itemEditLink = 'TesteE';
    protected $itemRemoveLink = 'EEtset';
    protected $itemRemoveFilter = '[value="EEtset"]';
    private $em;
    private $categoriaId;

    protected function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $categoria = new Categoria();
        $categoria->setNome('CategoriaX');

        $this->em->persist($categoria);
        $this->em->flush();

        $this->categoriaId = $categoria->getId();
    }

    protected function getAddArrayForm()
    {
        return array(
            'equipamento[codigo]' => '2.99',
            'equipamento[nome]' => 'TesteE',
            'equipamento[categoria]' => $this->categoriaId,
            'equipamento[manutencao]' => '0',
            'equipamento[atrasado]' => '0',
            'equipamento[patrimonio]' => '15455758',
            'equipamento[nSerie]' => 'E15455758',
            'equipamento[acessorios]' => 'Lorem Ipsum Dolor Sit Amet',
            'equipamento[obs]' => 'Esse item foi criado por um crawler',
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'equipamento[codigo]' => '3.99',
            'equipamento[nome]' => 'EEtset',
            'equipamento[categoria]' => $this->categoriaId,
            'equipamento[manutencao]' => '1',
            'equipamento[atrasado]' => '1',
            'equipamento[patrimonio]' => '915455758',
            'equipamento[nSerie]' => 'E15455758E',
            'equipamento[acessorios]' => 'ELorem Ipsum Dolor Sit Amet',
            'equipamento[obs]' => 'EEsse item foi criado por um crawler',
        );
    }

    protected function tearDown()
    {
        parent::tearDown();

        $categoria = $this->em->getRepository('App\Entity\Categoria')->find($this->categoriaId);

        $this->em->remove($categoria);
        $this->em->flush();

        $this->categoriaId = null;

        $this->em->close();
        $this->em = null;
    }

    protected function doAfterList($crawler)
    {
        $crawler = $this->client->click($crawler->selectLink('Cód.')->link());
        $crawler = $this->client->click($crawler->selectLink('Nome')->link());
        $crawler = $this->client->click($crawler->selectLink('Categoria')->link());
        $crawler = $this->client->click($crawler->selectLink('Manutenção')->link());
        $crawler = $this->client->click($crawler->selectLink('Devolução Atrasada?')->link());

        return $crawler;
    }
}
