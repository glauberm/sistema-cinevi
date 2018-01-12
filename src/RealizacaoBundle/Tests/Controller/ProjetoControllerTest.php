<?php

namespace RealizacaoBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use AdminBundle\Tests\Controller\AbstractCrudControllerTest;
use UserBundle\Entity\User;
use RealizacaoBundle\Entity\Modalidade;

class ProjetoControllerTest extends AbstractCrudControllerTest
{
    protected $indexRoute = 's/projetos';
    protected $itemEditFilter = 'a:contains("TesteP")';
    protected $itemEditLink = 'TesteP';
    protected $itemRemoveLink = 'PEtset';
    protected $itemRemoveFilter = '[value="PEtset"]';
    private $em;
    private $userId;
    private $professorId;
    private $modalidadeId;

    protected function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $user = new User();
        $user->setUsername('UserX');
        $user->setEmail('glaubernm@gmail.com');
        $user->setPlainPassword('12345678');
        $user->setMatricula('12345678');
        $user->setTelefone('12345678');
        $user->setEnabled(true);
        $user->setConfirmado(true);
        $user->setProfessor(false);
        $user->setRoles(array());

        $professor = new User();
        $professor->setUsername('UserY');
        $professor->setEmail('glaubernm@hotmail.com');
        $professor->setPlainPassword('12345678');
        $professor->setMatricula('92345678');
        $professor->setTelefone('92345678');
        $professor->setEnabled(true);
        $professor->setConfirmado(true);
        $professor->setProfessor(true);
        $professor->setRoles(array('ROLE_SUPER_ADMIN'));

        $modalidade = new Modalidade();
        $modalidade->setNome('ModalidadeX');

        $this->em->persist($user);
        $this->em->persist($professor);
        $this->em->persist($modalidade);
        $this->em->flush();

        $this->userId = $user->getId();
        $this->professorId = $professor->getId();
        $this->modalidadeId = $modalidade->getId();
    }

    protected function getAddArrayForm()
    {
        return array(
            'projeto[realizacao][user]' => $this->userId,
            'projeto[realizacao][titulo]' => 'TesteP',
            'projeto[realizacao][sinopse]' => 'Lorem Ipsum Dolor Sit Amet.',
            'projeto[realizacao][modalidade]' => $this->modalidadeId,
            'projeto[realizacao][professor]' => $this->professorId,
            'projeto[realizacao][genero]' => array('Ficção'),
            'projeto[realizacao][captacao]' => 'Vídeo',
            'projeto[realizacao][detalhesCaptacao]' => 'Lorem Ipsum Dolor Sit Amet.',
            'projeto[realizacao][locacoes]' => 'Lorem Ipsum Dolor Sit Amet.',
            'projeto[preProducao]' => '08/08/2008',
            'projeto[dataProducao]' => '08/08/2008',
            'projeto[posProducao]' => '08/08/2008',
            'projeto[direcao]' => array($this->userId),
            'projeto[producao]' => array($this->userId),
            'projeto[fotografia]' => array($this->userId),
            'projeto[disciplinaFotografia]' => '1',
            'projeto[som]' => array($this->userId),
            'projeto[disciplinaSom]' => '1',
            'projeto[arte]' => array($this->userId),
            'projeto[disciplinaArte]' => '1',
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'projeto[realizacao][titulo]' => 'PEtset',
            'projeto[realizacao][sinopse]' => '9Lorem Ipsum Dolor Sit Amet.',
            'projeto[realizacao][modalidade]' => $this->modalidadeId,
            'projeto[realizacao][professor]' => $this->professorId,
            'projeto[realizacao][genero]' => array('Ficção','Documentário'),
            'projeto[realizacao][captacao]' => 'Película',
            'projeto[realizacao][detalhesCaptacao]' => '9Lorem Ipsum Dolor Sit Amet.',
            'projeto[realizacao][locacoes]' => '9Lorem Ipsum Dolor Sit Amet.',
            'projeto[preProducao]' => '09/08/2008',
            'projeto[dataProducao]' => '09/08/2008',
            'projeto[posProducao]' => '09/08/2008',
            'projeto[direcao]' => array($this->userId),
            'projeto[producao]' => array($this->userId),
            'projeto[fotografia]' => array($this->userId),
            'projeto[disciplinaFotografia]' => '1',
            'projeto[som]' => array($this->userId),
            'projeto[disciplinaSom]' => '1',
            'projeto[arte]' => array($this->userId),
            'projeto[disciplinaArte]' => '1',
        );
    }

    protected function doAfterList($crawler)
    {
        $crawler = $this->client->click($crawler->selectLink('Título')->link());
        $crawler = $this->client->click($crawler->selectLink('Responsável')->link());
        $crawler = $this->client->click($crawler->selectLink('Modalidade')->link());

        return $crawler;
    }

    protected function tearDown()
    {
        parent::tearDown();

        $user = $this->em->getRepository('UserBundle:User')->find($this->userId);
        $professor = $this->em->getRepository('UserBundle:User')->find($this->professorId);
        $modalidade = $this->em->getRepository('RealizacaoBundle:Modalidade')->find($this->modalidadeId);

        $this->em->remove($user);
        $this->em->remove($professor);
        $this->em->remove($modalidade);
        $this->em->flush();

        $this->userId = null;
        $this->professorId = null;
        $this->modalidadeId = null;

        $this->em->close();
        $this->em = null;
    }
}
