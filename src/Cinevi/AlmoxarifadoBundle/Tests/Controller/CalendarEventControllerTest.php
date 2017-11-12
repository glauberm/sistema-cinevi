<?php

namespace Cinevi\AlmoxarifadoBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;
use Cinevi\SecurityBundle\Entity\User;
use Cinevi\RealizacaoBundle\Entity\Realizacao;
use Cinevi\RealizacaoBundle\Entity\Projeto;
use Cinevi\RealizacaoBundle\Entity\Modalidade;
use Cinevi\AlmoxarifadoBundle\Entity\Categoria;
use Cinevi\AlmoxarifadoBundle\Entity\Equipamento;

class CalendarEventControllerTest extends RestfulCrudControllerTest
{
    protected $indexRoute = 's/reservas';
    protected $itemEditFilter = 'a:contains("13/06/2018")';
    protected $itemEditLink = '13/06/2018';
    protected $itemRemoveLink = "12\/06\/2018";
    protected $itemRemoveFilter = '[value="12/06/2018"]';
    private $em;
    private $userId;
    private $professorId;
    private $modalidadeId;
    private $projetoId;
    private $categoriaId;
    private $equipamentoId;

    protected function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $user = new User();
        $user->setUsername('UserP');
        $user->setEmail('glaubernm@gmail.com');
        $user->setPlainPassword('12345678');
        $user->setMatricula('12745678');
        $user->setTelefone('12745678');
        $user->setEnabled(true);
        $user->setConfirmado(true);
        $user->setProfessor(false);
        $user->setRoles(array());

        $professor = new User();
        $professor->setUsername('UserF');
        $professor->setEmail('glaubernm@hotmail.com');
        $professor->setPlainPassword('12345678');
        $professor->setMatricula('92045678');
        $professor->setTelefone('92045678');
        $professor->setEnabled(true);
        $professor->setConfirmado(true);
        $professor->setProfessor(true);
        $professor->setRoles(array());

        $modalidade = new Modalidade();
        $modalidade->setNome('ModalidadeX');

        $realizacao = new Realizacao();
        $realizacao->setUser($user);
        $realizacao->setTitulo('RealizacaoX');
        $realizacao->setSinopse('Lorem Ipsum Dolor Sit Amet.');
        $realizacao->setModalidade($modalidade);
        $realizacao->setProfessor($professor);
        $realizacao->setGenero(array('Ficção'));
        $realizacao->setCaptacao('Vídeo');
        $realizacao->setDetalhesCaptacao('Lorem Ipsum Dolor Sit Amet.');
        $realizacao->setLocacoes('Lorem Ipsum Dolor Sit Amet.');
        $projeto = new Projeto();
        $projeto->setRealizacao($realizacao);
        $projeto->setPreProducao(new \DateTime('2008-08-08'));
        $projeto->setDataProducao(new \DateTime('2008-08-08'));
        $projeto->setPosProducao(new \DateTime('2008-08-08'));
        $projeto->addDirecao($user);
        $projeto->addProducao($user);
        $projeto->addFotografium($user);
        $projeto->setDisciplinaFotografia('1');
        $projeto->addSom($user);
        $projeto->setDisciplinaSom('1');
        $projeto->addArte($user);
        $projeto->setDisciplinaArte('1');

        $categoria = new Categoria();
        $categoria->setNome('CategoriaX');

        $equipamento = new Equipamento();
        $equipamento->setCodigo('2.99');
        $equipamento->setNome('TesteE');
        $equipamento->setCategoria($categoria);
        $equipamento->setManutencao('0');
        $equipamento->setAtrasado('0');
        $equipamento->setPatrimonio('15455758');
        $equipamento->setNSerie('E15455758');
        $equipamento->setAcessorios('Lorem Ipsum Dolor Sit Amet');
        $equipamento->setObs('Esse item foi criado por um crawler');

        $this->em->persist($user);
        $this->em->persist($professor);
        $this->em->persist($modalidade);
        $this->em->persist($projeto);
        $this->em->persist($categoria);
        $this->em->persist($equipamento);
        $this->em->flush();

        $this->userId = $user->getId();
        $this->professorId = $professor->getId();
        $this->modalidadeId = $modalidade->getId();
        $this->projetoId = $projeto->getId();
        $this->categoriaId = $categoria->getId();
        $this->equipamentoId = $equipamento->getId();
    }

    protected function getAddArrayForm()
    {
        return array(
            'calendar_event[user]' => $this->userId,
            'calendar_event[projeto]' => $this->projetoId,
            'calendar_event[startDate]' => '13/06/2018',
            'calendar_event[endDate]' => '19/06/2018',
            'calendar_event[equipamentos]' => array($this->equipamentoId),
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'calendar_event[user]' => $this->userId,
            'calendar_event[projeto]' => $this->projetoId,
            'calendar_event[startDate]' => '12/06/2018',
            'calendar_event[endDate]' => '20/06/2018',
            'calendar_event[equipamentos]' => array($this->equipamentoId),
        );
    }

    protected function tearDown()
    {
        parent::tearDown();

        $user = $this->em->getRepository('CineviSecurityBundle:User')->find($this->userId);
        $professor = $this->em->getRepository('CineviSecurityBundle:User')->find($this->professorId);
        $modalidade = $this->em->getRepository('CineviRealizacaoBundle:Modalidade')->find($this->modalidadeId);
        $projeto = $this->em->getRepository('CineviRealizacaoBundle:Projeto')->find($this->projetoId);
        $categoria = $this->em->getRepository('CineviAlmoxarifadoBundle:Categoria')->find($this->categoriaId);
        $equipamento = $this->em->getRepository('CineviAlmoxarifadoBundle:Equipamento')->find($this->equipamentoId);

        $this->em->remove($user);
        $this->em->remove($professor);
        $this->em->remove($modalidade);
        $this->em->remove($projeto);
        $this->em->remove($categoria);
        $this->em->remove($equipamento);
        $this->em->flush();

        $this->userId = null;
        $this->professorId = null;
        $this->modalidadeId = null;
        $this->projetoId = null;
        $this->categoriaId = null;
        $this->equipamentoId = null;

        $this->em->close();
        $this->em = null;
    }
}
