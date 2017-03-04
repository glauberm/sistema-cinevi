<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;
use Cinevi\AlmoxarifadoBundle\Entity\User;

class ProjetoControllerTest extends RestfulCrudControllerTest
{
    // List
    protected $indexRoute = 'projetos';
    // Edit
    protected $itemEditFilter = 'a:contains("TesteP")';
    protected $itemEditLink = 'TesteP';
    // Remove
    protected $itemRemoveLink = 'PEtset';
    protected $itemRemoveFilter = '[value="PEtset"]';
    // Entities
    private $em;
    private $userId;

    protected function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $user = new User();
        $user->setNome('UserX');

        $this->em->persist($user);
        $this->em->flush();

        $this->userId = $user->getId();
    }

    protected function getAddArrayForm()
    {
        return array(
            'projeto[realizacao][titulo]' => 'TesteP',
            'projeto[realizacao][user]' => 'TesteP',
            'projeto[user]' => $this->userId,
            'projeto[manutencao]' => '0',
            'projeto[especificacao]' => 'EspecificacaoE',
            'projeto[fabricante]' => 'FabricanteE',
            'projeto[modelo]' => 'ModeloE',
            'projeto[patrimonio]' => '15455758',
            'projeto[nSerie]' => 'E15455758',
            'projeto[acessorios]' => 'Lorem Ipsum Dolor Sit Amet',
            'projeto[obs]' => 'Esse item foi criado por um crawler',
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'projeto[codigo]' => '3.99',
            'projeto[nome]' => 'EEtset',
            'projeto[user]' => $this->userId,
            'projeto[manutencao]' => '0',
            'projeto[especificacao]' => 'EEspecificacaoE',
            'projeto[fabricante]' => 'EFabricanteE',
            'projeto[modelo]' => 'EModeloE',
            'projeto[patrimonio]' => '915455758',
            'projeto[nSerie]' => 'E15455758E',
            'projeto[acessorios]' => 'ELorem Ipsum Dolor Sit Amet',
            'projeto[obs]' => 'EEsse item foi criado por um crawler',
        );
    }

    protected function tearDown()
    {
        parent::tearDown();

        $user = $this->em->getRepository('CineviSecurityBundle:User')->find($this->userId);

        $this->em->remove($user);
        $this->em->flush();

        $this->userId = null;

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}
