<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;
use Cinevi\AlmoxarifadoBundle\Entity\Categoria;

class EquipamentoControllerTest extends RestfulCrudControllerTest
{
    // List
    protected $indexRoute = 'equipamentos';
    // Edit
    protected $itemEditFilter = 'a:contains("TesteE")';
    protected $itemEditLink = 'TesteE';
    // Remove
    protected $itemRemoveLink = 'EEtset';
    protected $itemRemoveFilter = '[value="EEtset"]';
    // Entities
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
            'equipamento[manutencao]' => '0'
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'equipamento[codigo]' => '3.99',
            'equipamento[nome]' => 'EEtset',
            'equipamento[categoria]' => $this->categoriaId,
            'equipamento[manutencao]' => '0'
        );
    }

    protected function tearDown()
    {
        parent::tearDown();

        $categoria = $this->em->getRepository('CineviAlmoxarifadoBundle:Categoria')->find($this->categoriaId);

        $this->em->remove($categoria);
        $this->em->flush();

        $this->categoriaId = null;

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}
