<?php

namespace Cinevi\RealizacaoBundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use Cinevi\AdminBundle\Tests\Controller\RestfulCrudControllerTest;
use Cinevi\SecurityBundle\Entity\User;
use Cinevi\RealizacaoBundle\Entity\Realizacao;
use Cinevi\RealizacaoBundle\Entity\Projeto;
use Cinevi\RealizacaoBundle\Entity\Funcao;
use Cinevi\RealizacaoBundle\Entity\Modalidade;

class CopiaFinalControllerTest extends RestfulCrudControllerTest
{
    protected $indexRoute = 's/copias-finais';
    protected $itemEditFilter = 'a:contains("TesteP")';
    protected $itemEditLink = 'TesteP';
    protected $itemRemoveLink = 'PEtset';
    protected $itemRemoveFilter = '[value="PEtset"]';
    private $em;
    private $userId;
    private $professorId;
    private $modalidadeId;
    private $projetoId;
    private $funcaoId;

    protected function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $user = new User();
        $user->setUsername('UserZ');
        $user->setEmail('glaubernm@gmail.com');
        $user->setPlainPassword('12345678');
        $user->setMatricula('812345678');
        $user->setTelefone('812345678');
        $user->setEnabled(true);
        $user->setConfirmado(true);
        $user->setProfessor(false);
        $user->setRoles(array());

        $professor = new User();
        $professor->setUsername('UserK');
        $professor->setEmail('glaubernm@hotmail.com');
        $professor->setPlainPassword('12345678');
        $professor->setMatricula('52345678');
        $professor->setTelefone('52345678');
        $professor->setEnabled(true);
        $professor->setConfirmado(true);
        $professor->setProfessor(true);
        $professor->setRoles(array('ROLE_DEPARTAMENTO'));

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

        $funcao = new Funcao();
        $funcao->setNome('FunçãoX');

        $this->em->persist($user);
        $this->em->persist($professor);
        $this->em->persist($modalidade);
        $this->em->persist($projeto);
        $this->em->persist($funcao);
        $this->em->flush();

        $this->userId = $user->getId();
        $this->professorId = $professor->getId();
        $this->modalidadeId = $modalidade->getId();
        $this->projetoId = $projeto->getId();
        $this->funcaoId = $funcao->getId();
    }

    protected function doAdd($crawler, $addLink, $addButton, $addArrayForm)
    {
        $crawler = $this->client->click($crawler->selectLink($addLink)->link());

        $form = $crawler->selectButton($addButton)->form($addArrayForm);

        $values = $form->getPhpValues();

        $values['copia_final']['fichaTecnica']['equipes'][0]['funcao'] = $this->funcaoId;
        $values['copia_final']['fichaTecnica']['equipes'][0]['users'] = array($this->userId);
        $values['copia_final']['fichaTecnica']['equipes'][1]['funcao'] = $this->funcaoId;
        $values['copia_final']['fichaTecnica']['equipes'][1]['users'] = array($this->userId);

        $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

        // $this->client->submit($form);

        return $this->client->followRedirect();
    }

    protected function getAddArrayForm()
    {
        return array(
            'copia_final[realizacao][user]' => $this->userId,
            'copia_final[realizacao][titulo]' => 'TesteP',
            'copia_final[realizacao][sinopse]' => 'Lorem Ipsum Dolor Sit Amet.',
            'copia_final[realizacao][modalidade]' => 'Livre Iniciativa',
            'copia_final[realizacao][professor]' => $this->professorId,
            'copia_final[realizacao][modalidade]' => $this->modalidadeId,
            'copia_final[realizacao][genero]' => array('Ficção'),
            'copia_final[realizacao][captacao]' => 'Vídeo',
            'copia_final[realizacao][detalhesCaptacao]' => 'Lorem Ipsum Dolor Sit Amet.',
            'copia_final[realizacao][locacoes]' => 'Lorem Ipsum Dolor Sit Amet.',
            'copia_final[projeto]' => $this->projetoId,
            'copia_final[linkVideo]' => 'https://youtu.be/QBSuSPNOkaI',
            'copia_final[senhaVideo]' => '12345678',
            'copia_final[cromia]' => 'P&B',
            'copia_final[proporcao]' => 'Padrão HD - 16:9',
            'copia_final[formato]' => 'Vídeo',
            'copia_final[duracao]' => 120,
            'copia_final[formatoDigitalNativo]' => 'Prores',
            'copia_final[codec]' => 'H.264',
            'copia_final[container]' => 'DNG',
            'copia_final[taxaBits]' => 64,
            'copia_final[velocidade]' => '24 fps',
            'copia_final[som]' => 'Mono',
            'copia_final[resolucaoAudioDigital]' => '24 bits',
            'copia_final[suporteMatrizDigital]' => 'DVD-R',
            'copia_final[camera]' => 'Canon 5D Mark II',
            'copia_final[captacaoSom]' => 'Lorem, Ipsum e Dolor.',
            'copia_final[softwareEdicao]' => array('Adobe Premiere', 'Sony Vegas'),
            'copia_final[orcamento]' => '3999,99',
            'copia_final[fontesFinanciamento]' => array('Recursos Próprios', 'Edital'),
            'copia_final[apoiadores]' => 'Lorem, Ipsum e Dolor.',
            'copia_final[dcp]' => '1',
            'copia_final[fichaTecnica][elenco]' => 'Lorem, Ipsum e Dolor.',
            'copia_final[fichaTecnica][outrasInformacoes]' => 'Lorem, Ipsum e Dolor.',
            'copia_final[fichaTecnica][festivais]' => 'Lorem, Ipsum e Dolor.',
            'copia_final[fichaTecnica][premios]' => 'Lorem, Ipsum e Dolor.',
            'copia_final[confirmado]' => '0',
        );
    }

    protected function doEdit($crawler, $itemEditFilter, $itemEditLink, $editLink, $editButton, $editArrayForm)
    {
        $this->assertGreaterThan(0, $crawler->filter($itemEditFilter)->count(), 'Faltando elemento '.$itemEditFilter);

        $crawler = $this->client->click($crawler->selectLink($itemEditLink)->link());

        $crawler = $this->client->click($crawler->selectLink($editLink)->link());

        $this->assertEquals(2, $crawler->filter('#equipes > .to-many-item')->count());

        $form = $crawler->selectButton($editButton)->form($editArrayForm);

        $values = $form->getPhpValues();

        unset($values['copia_final']['fichaTecnica']['equipes'][0]);

        $this->client->request($form->getMethod(), $form->getUri(), $values, $form->getPhpFiles());

        return $this->client->followRedirect();
    }

    protected function getEditArrayForm()
    {
        return array(
            'copia_final[realizacao][titulo]' => 'PEtset',
            'copia_final[realizacao][sinopse]' => '9Lorem Ipsum Dolor Sit Amet.',
            'copia_final[realizacao][modalidade]' => 'Filme de Realização',
            'copia_final[realizacao][professor]' => $this->professorId,
            'copia_final[realizacao][modalidade]' => $this->modalidadeId,
            'copia_final[realizacao][genero]' => array('Ficção','Documentário'),
            'copia_final[realizacao][captacao]' => 'Película',
            'copia_final[realizacao][detalhesCaptacao]' => '9Lorem Ipsum Dolor Sit Amet.',
            'copia_final[realizacao][locacoes]' => '9Lorem Ipsum Dolor Sit Amet.',
            'copia_final[linkVideo]' => 'https://www.youtube.com/watch?v=sZxL8l1tsXI',
            'copia_final[senhaVideo]' => '87654321',
            'copia_final[projeto]' => $this->projetoId,
            'copia_final[cromia]' => 'P&B',
            'copia_final[proporcao]' => 'Scope - 2,39:1',
            'copia_final[formato]' => 'Película',
            'copia_final[duracao]' => 90,
            'copia_final[formatoDigitalNativo]' => 'AVCHD',
            'copia_final[codec]' => 'Prores',
            'copia_final[container]' => 'MOV',
            'copia_final[taxaBits]' => 32,
            'copia_final[velocidade]' => '29.97 fps',
            'copia_final[som]' => 'Estéreo',
            'copia_final[resolucaoAudioDigital]' => '16 bits',
            'copia_final[suporteMatrizDigital]' => 'HD Externo',
            'copia_final[camera]' => 'Canon 5D Mark III',
            'copia_final[captacaoSom]' => '9Lorem, Ipsum e Dolor.',
            'copia_final[softwareEdicao]' => array('Adobe Premiere'),
            'copia_final[orcamento]' => '4999,99',
            'copia_final[fontesFinanciamento]' => array('Recursos Próprios'),
            'copia_final[apoiadores]' => '9Lorem, Ipsum e Dolor.',
            'copia_final[dcp]' => '0',
            'copia_final[fichaTecnica][elenco]' => '9Lorem, Ipsum e Dolor.',
            'copia_final[fichaTecnica][outrasInformacoes]' => '9Lorem, Ipsum e Dolor.',
            'copia_final[fichaTecnica][festivais]' => '9Lorem, Ipsum e Dolor.',
            'copia_final[fichaTecnica][premios]' => '9Lorem, Ipsum e Dolor.',
            'copia_final[confirmado]' => '1',
        );
    }

    protected function doRemove($crawler, $editLink, $itemRemoveLink, $itemRemoveFilter, $removeButton)
    {
        $crawler = $this->client->click($crawler->selectLink($itemRemoveLink)->link());

        $crawler = $this->client->click($crawler->selectLink($editLink)->link());

        $this->assertEquals(1, $crawler->filter('#equipes > .to-many-item')->count());

        $this->assertGreaterThan(0, $crawler->filter($itemRemoveFilter)->count(), 'Faltando elemento '.$itemRemoveFilter);

        $this->client->submit($crawler->selectButton($removeButton)->form());

        $crawler = $this->client->followRedirect();

        $this->assertNotRegExp('/'.$itemRemoveLink.'/', $this->client->getResponse()->getContent());

        return $crawler;
    }

    protected function tearDown()
    {
        parent::tearDown();

        $user = $this->em->getRepository('CineviSecurityBundle:User')->find($this->userId);
        $professor = $this->em->getRepository('CineviSecurityBundle:User')->find($this->professorId);
        $modalidade = $this->em->getRepository('CineviRealizacaoBundle:Modalidade')->find($this->modalidadeId);
        $projeto = $this->em->getRepository('CineviRealizacaoBundle:Projeto')->find($this->projetoId);
        $funcao = $this->em->getRepository('CineviRealizacaoBundle:Funcao')->find($this->funcaoId);

        $this->em->remove($user);
        $this->em->remove($professor);
        $this->em->remove($modalidade);
        $this->em->remove($projeto);
        $this->em->remove($funcao);
        $this->em->flush();

        $this->userId = null;
        $this->professorId = null;
        $this->modalidadeId = null;
        $this->projetoId = null;
        $this->funcaoId = null;

        $this->em->close();
        $this->em = null;
    }
}
