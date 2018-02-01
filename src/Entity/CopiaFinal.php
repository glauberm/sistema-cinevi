<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CopiaFinalRepository")
 * @ORM\Table(name="realizacao_copias_finais")
 */
class CopiaFinal extends Base
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Realizacao", cascade={"all"}, inversedBy="copiaFinal")
     **/
    protected $realizacao;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Projeto", cascade={"merge"}, inversedBy="copiaFinal")
     * @ORM\JoinColumn(name="modalidade_id", referencedColumnName="id", onDelete="SET NULL")
     **/
    protected $projeto;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $cromia;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $proporcao;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $formato;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $formatoDigitalNativo;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $codec;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $container;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $taxaBits;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $velocidade;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $som;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $resolucaoAudioDigital;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     **/
    protected $dcp;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $suporteMatrizDigital;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $camera;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $captacaoSom;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     **/
    protected $softwareEdicao;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     **/
    protected $orcamento;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     **/
    protected $fontesFinanciamento;

    /**
     * @ORM\Column(type="text", nullable=true)
     **/
    protected $apoiadores;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $duracao;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $linkVideo;

    /**
     * @ORM\Column(type="string", nullable=true)
     **/
    protected $senhaVideo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FichaTecnica", cascade={"all"})
     **/
    protected $fichaTecnica;

    /**
     * @ORM\Column(type="boolean")
     **/
    protected $confirmado = 0;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CopiaFinalHistorico", cascade={"persist", "remove"})
     **/
    protected $historicos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->historicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cromia
     *
     * @param string $cromia
     * @return CopiaFinal
     */
    public function setCromia($cromia)
    {
        $this->cromia = $cromia;

        return $this;
    }

    /**
     * Get cromia
     *
     * @return string
     */
    public function getCromia()
    {
        return $this->cromia;
    }

    /**
     * Set proporcao
     *
     * @param string $proporcao
     * @return CopiaFinal
     */
    public function setProporcao($proporcao)
    {
        $this->proporcao = $proporcao;

        return $this;
    }

    /**
     * Get proporcao
     *
     * @return string
     */
    public function getProporcao()
    {
        return $this->proporcao;
    }

    /**
     * Set formato
     *
     * @param string $formato
     * @return CopiaFinal
     */
    public function setFormato($formato)
    {
        $this->formato = $formato;

        return $this;
    }

    /**
     * Get formato
     *
     * @return string
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * Set formatoDigitalNativo
     *
     * @param string $formatoDigitalNativo
     * @return CopiaFinal
     */
    public function setFormatoDigitalNativo($formatoDigitalNativo)
    {
        $this->formatoDigitalNativo = $formatoDigitalNativo;

        return $this;
    }

    /**
     * Get formatoDigitalNativo
     *
     * @return string
     */
    public function getFormatoDigitalNativo()
    {
        return $this->formatoDigitalNativo;
    }

    /**
     * Set codec
     *
     * @param string $codec
     * @return CopiaFinal
     */
    public function setCodec($codec)
    {
        $this->codec = $codec;

        return $this;
    }

    /**
     * Get codec
     *
     * @return string
     */
    public function getCodec()
    {
        return $this->codec;
    }

    /**
     * Set container
     *
     * @param string $container
     * @return CopiaFinal
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get container
     *
     * @return string
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set taxaBits
     *
     * @param string $taxaBits
     * @return CopiaFinal
     */
    public function setTaxaBits($taxaBits)
    {
        $this->taxaBits = $taxaBits;

        return $this;
    }

    /**
     * Get taxaBits
     *
     * @return string
     */
    public function getTaxaBits()
    {
        return $this->taxaBits;
    }

    /**
     * Set velocidade
     *
     * @param string $velocidade
     * @return CopiaFinal
     */
    public function setVelocidade($velocidade)
    {
        $this->velocidade = $velocidade;

        return $this;
    }

    /**
     * Get velocidade
     *
     * @return string
     */
    public function getVelocidade()
    {
        return $this->velocidade;
    }

    /**
     * Set som
     *
     * @param string $som
     * @return CopiaFinal
     */
    public function setSom($som)
    {
        $this->som = $som;

        return $this;
    }

    /**
     * Get som
     *
     * @return string
     */
    public function getSom()
    {
        return $this->som;
    }

    /**
     * Set resolucaoAudioDigital
     *
     * @param string $resolucaoAudioDigital
     * @return CopiaFinal
     */
    public function setResolucaoAudioDigital($resolucaoAudioDigital)
    {
        $this->resolucaoAudioDigital = $resolucaoAudioDigital;

        return $this;
    }

    /**
     * Get resolucaoAudioDigital
     *
     * @return string
     */
    public function getResolucaoAudioDigital()
    {
        return $this->resolucaoAudioDigital;
    }

    /**
     * Set dcp
     *
     * @param boolean $dcp
     * @return CopiaFinal
     */
    public function setDcp($dcp)
    {
        $this->dcp = $dcp;

        return $this;
    }

    /**
     * Get dcp
     *
     * @return boolean
     */
    public function getDcp()
    {
        return $this->dcp;
    }

    /**
     * Set suporteMatrizDigital
     *
     * @param string $suporteMatrizDigital
     * @return CopiaFinal
     */
    public function setSuporteMatrizDigital($suporteMatrizDigital)
    {
        $this->suporteMatrizDigital = $suporteMatrizDigital;

        return $this;
    }

    /**
     * Get suporteMatrizDigital
     *
     * @return string
     */
    public function getSuporteMatrizDigital()
    {
        return $this->suporteMatrizDigital;
    }

    /**
     * Set camera
     *
     * @param string $camera
     * @return CopiaFinal
     */
    public function setCamera($camera)
    {
        $this->camera = $camera;

        return $this;
    }

    /**
     * Get camera
     *
     * @return string
     */
    public function getCamera()
    {
        return $this->camera;
    }

    /**
     * Set captacaoSom
     *
     * @param string $captacaoSom
     * @return CopiaFinal
     */
    public function setCaptacaoSom($captacaoSom)
    {
        $this->captacaoSom = $captacaoSom;

        return $this;
    }

    /**
     * Get captacaoSom
     *
     * @return string
     */
    public function getCaptacaoSom()
    {
        return $this->captacaoSom;
    }

    /**
     * Set softwareEdicao
     *
     * @param array $softwareEdicao
     * @return CopiaFinal
     */
    public function setSoftwareEdicao($softwareEdicao)
    {
        $this->softwareEdicao = $softwareEdicao;

        return $this;
    }

    /**
     * Get softwareEdicao
     *
     * @return array
     */
    public function getSoftwareEdicao()
    {
        return $this->softwareEdicao;
    }

    /**
     * Set orcamento
     *
     * @param string $orcamento
     * @return CopiaFinal
     */
    public function setOrcamento($orcamento)
    {
        $this->orcamento = $orcamento;

        return $this;
    }

    /**
     * Get orcamento
     *
     * @return string
     */
    public function getOrcamento()
    {
        return $this->orcamento;
    }

    /**
     * Set fontesFinanciamento
     *
     * @param array $fontesFinanciamento
     * @return CopiaFinal
     */
    public function setFontesFinanciamento($fontesFinanciamento)
    {
        $this->fontesFinanciamento = $fontesFinanciamento;

        return $this;
    }

    /**
     * Get fontesFinanciamento
     *
     * @return array
     */
    public function getFontesFinanciamento()
    {
        return $this->fontesFinanciamento;
    }

    /**
     * Set apoiadores
     *
     * @param string $apoiadores
     * @return CopiaFinal
     */
    public function setApoiadores($apoiadores)
    {
        $this->apoiadores = $apoiadores;

        return $this;
    }

    /**
     * Get apoiadores
     *
     * @return string
     */
    public function getApoiadores()
    {
        return $this->apoiadores;
    }

    /**
     * Set duracao
     *
     * @param string $duracao
     * @return CopiaFinal
     */
    public function setDuracao($duracao)
    {
        $this->duracao = $duracao;

        return $this;
    }

    /**
     * Get duracao
     *
     * @return string
     */
    public function getDuracao()
    {
        return $this->duracao;
    }

    /**
     * Set realizacao
     *
     * @param \App\Entity\Realizacao $realizacao
     * @return CopiaFinal
     */
    public function setRealizacao(\App\Entity\Realizacao $realizacao = null)
    {
        $this->realizacao = $realizacao;

        return $this;
    }

    /**
     * Get realizacao
     *
     * @return \App\Entity\Realizacao
     */
    public function getRealizacao()
    {
        return $this->realizacao;
    }

    /**
     * Set fichaTecnica
     *
     * @param \App\Entity\FichaTecnica $fichaTecnica
     * @return CopiaFinal
     */
    public function setFichaTecnica(\App\Entity\FichaTecnica $fichaTecnica = null)
    {
        $this->fichaTecnica = $fichaTecnica;

        return $this;
    }

    /**
     * Get fichaTecnica
     *
     * @return \App\Entity\FichaTecnica
     */
    public function getFichaTecnica()
    {
        return $this->fichaTecnica;
    }

    /**
     * Set projeto
     *
     * @param \App\Entity\Projeto $projeto
     * @return CopiaFinal
     */
    public function setProjeto(\App\Entity\Projeto $projeto = null)
    {
        $this->projeto = $projeto;

        return $this;
    }

    /**
     * Get projeto
     *
     * @return \App\Entity\Projeto
     */
    public function getProjeto()
    {
        return $this->projeto;
    }

    /**
     * Set confirmado
     *
     * @param boolean $confirmado
     * @return CopiaFinal
     */
    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;

        return $this;
    }

    /**
     * Get confirmado
     *
     * @return boolean
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }

    /**
     * Set linkVideo
     *
     * @param string $linkVideo
     * @return CopiaFinal
     */
    public function setLinkVideo($linkVideo)
    {
        $this->linkVideo = $linkVideo;

        return $this;
    }

    /**
     * Get linkVideo
     *
     * @return string
     */
    public function getLinkVideo()
    {
        return $this->linkVideo;
    }

    /**
     * Set senhaVideo
     *
     * @param string $senhaVideo
     * @return CopiaFinal
     */
    public function setSenhaVideo($senhaVideo)
    {
        $this->senhaVideo = $senhaVideo;

        return $this;
    }

    /**
     * Get senhaVideo
     *
     * @return string
     */
    public function getSenhaVideo()
    {
        return $this->senhaVideo;
    }

    /**
     * Add historicos
     *
     * @param \App\Entity\CopiaFinalHistorico $historicos
     * @return CopiaFinal
     */
    public function addHistorico(\App\Entity\CopiaFinalHistorico $historicos)
    {
        $this->historicos[] = $historicos;

        return $this;
    }

    /**
     * Remove historicos
     *
     * @param \App\Entity\CopiaFinalHistorico $historicos
     */
    public function removeHistorico(\App\Entity\CopiaFinalHistorico $historicos)
    {
        $this->historicos->removeElement($historicos);
    }

    /**
     * Get historicos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistoricos()
    {
        return $this->historicos;
    }
}
