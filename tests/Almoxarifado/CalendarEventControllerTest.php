<?php

namespace App\Tests\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Tests\Admin\AbstractCrudControllerTest;
use App\Entity\User;
use App\Entity\Realizacao;
use App\Entity\Projeto;
use App\Entity\Modalidade;
use App\Entity\Categoria;
use App\Entity\Equipamento;

/**
 * @TODO: Actually update entity in email tests.
 * @TODO: Test repository functions.
 */
class CalendarEventControllerTest extends AbstractCrudControllerTest
{
    protected $indexRoute = 's/reservas';
    protected $itemEditFilter = 'dd:contains("13/06/2021")';
    protected $itemEditLink = '13/06/2021';
    protected $itemRemoveLink = "12\/06\/2021";
    protected $itemRemoveFilter = '[value="12/06/2021"]';
    private $em;
    private $router;
    private $twig;
    private $userId;
    private $professorId;
    private $modalidadeId;
    private $projetoId;
    private $categoriaId;
    private $equipamentoId;
    private $repositoryName = 'App\Entity\CalendarEvent';
    private $templateDir = 'almoxarifado/calendar_event';

    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
        $this->router = static::$kernel->getContainer()
            ->get('router')
        ;
        $this->twig = static::$kernel->getContainer()
            ->get('twig')
        ;

        $userAtual = $this->em
            ->getRepository(User::class)
            ->findOneBy([ 'username' => $this->username ])
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
        $user->setAutor($userAtual);
        $user->setCreatedIn(new \DateTime());

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
        $professor->setAutor($userAtual);
        $professor->setCreatedIn(new \DateTime());

        $modalidade = new Modalidade();
        $modalidade->setNome('ModalidadeX');
        $modalidade->setAutor($userAtual);
        $modalidade->setCreatedIn(new \DateTime());

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
        $projeto->setAutor($userAtual);
        $projeto->setCreatedIn(new \DateTime());

        $categoria = new Categoria();
        $categoria->setNome('CategoriaX');
        $categoria->setAutor($userAtual);
        $categoria->setCreatedIn(new \DateTime());

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
        $equipamento->setAutor($userAtual);
        $equipamento->setCreatedIn(new \DateTime());

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
            'calendar_event[startDate]' => '13/06/2021',
            'calendar_event[endDate]' => '19/06/2021',
            'calendar_event[equipamentos]' => array($this->equipamentoId),
        );
    }

    protected function getEditArrayForm()
    {
        return array(
            'calendar_event[user]' => $this->userId,
            'calendar_event[projeto]' => $this->projetoId,
            'calendar_event[startDate]' => '12/06/2021',
            'calendar_event[endDate]' => '20/06/2021',
            'calendar_event[equipamentos]' => array($this->equipamentoId),
        );
    }

    protected function doAfterList($crawler)
    {
        $crawler = $this->client->click($crawler->selectLink('Cód.')->link());
        $crawler = $this->client->click($crawler->selectLink('Retirada')->link());
        $crawler = $this->client->click($crawler->selectLink('Devolução')->link());

        return $crawler;
    }

    protected function doAfterAdd($crawler)
    {
        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');

        // exit(var_dump($this->client->getResponse()->getContent()));

        $this->assertEquals(3, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();

        $obj = $this->em
            ->getRepository($this->repositoryName)
            ->findOneBy(array( 'user' => $this->userId ))
        ;

        $subject = 'Nova Reserva: '.$obj->getTitle();
        $path = $this->router->generate('almoxarifado_reserva_show', array(
            'params' => $obj->getId(),
        ), UrlGeneratorInterface::ABSOLUTE_URL);

        $message = $collectedMessages[0];
        $this->assertInstanceOf('Swift_Message', $message);
        $template = $this->templateDir.'/email';
        $to = 'almoxarifadocinemauff@gmail.com';
        $this->checkSendMail($this->twig, $obj, $path, $subject, $to, $template, $message);

        $message = $collectedMessages[1];
        $this->assertInstanceOf('Swift_Message', $message);
        $template = $this->templateDir.'/email_user';
        $to = $obj->getUser()->getEmail();
        $this->checkSendMail($this->twig, $obj, $path, $subject, $to, $template, $message);

        $message = $collectedMessages[2];
        $this->assertInstanceOf('Swift_Message', $message);
        $template = $this->templateDir.'/email_professor';
        $to = $obj->getProjeto()->getRealizacao()->getProfessor()->getEmail();
        $this->checkSendMail($this->twig, $obj, $path, $subject, $to, $template, $message);

        return $crawler;
    }

    protected function doAfterEdit($crawler)
    {
        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');

        $this->assertEquals(3, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();

        $obj = $this->em
            ->getRepository($this->repositoryName)
            ->findOneBy(array( 'user' => $this->userId ))
        ;

        $subject = 'Edição de Reserva: '.$obj->getTitle();
        $path = $this->router->generate('almoxarifado_reserva_show', array(
            'params' => $obj->getId(),
        ), UrlGeneratorInterface::ABSOLUTE_URL);

        $message = $collectedMessages[0];
        $this->assertInstanceOf('Swift_Message', $message);
        $template = $this->templateDir.'/email_edicao';
        $to = 'almoxarifadocinemauff@gmail.com';
        $this->checkSendMail($this->twig, $obj, $path, $subject, $to, $template, $message);

        $message = $collectedMessages[1];
        $this->assertInstanceOf('Swift_Message', $message);
        $template = $this->templateDir.'/email_edicao_user';
        $to = $obj->getUser()->getEmail();
        $this->checkSendMail($this->twig, $obj, $path, $subject, $to, $template, $message);

        $message = $collectedMessages[2];
        $this->assertInstanceOf('Swift_Message', $message);
        $template = $this->templateDir.'/email_edicao_professor';
        $to = $obj->getProjeto()->getRealizacao()->getProfessor()->getEmail();
        $this->checkSendMail($this->twig, $obj, $path, $subject, $to, $template, $message);

        return $crawler;
    }

    protected function tearDown()
    {
        parent::tearDown();

        $user = $this->em->getRepository('App\Entity\User')->find($this->userId);
        $professor = $this->em->getRepository('App\Entity\User')->find($this->professorId);
        $modalidade = $this->em->getRepository('App\Entity\Modalidade')->find($this->modalidadeId);
        $projeto = $this->em->getRepository('App\Entity\Projeto')->find($this->projetoId);
        $categoria = $this->em->getRepository('App\Entity\Categoria')->find($this->categoriaId);
        $equipamento = $this->em->getRepository('App\Entity\Equipamento')->find($this->equipamentoId);

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
