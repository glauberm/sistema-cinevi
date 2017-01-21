<?php

namespace Cinevi\AlmoxarifadoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="almoxarifado_copias_finais")
 */
class CopiaFinal
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     **/
    protected $titulo;

    Gênero:Choices

    Realização:Choices

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\SecurityBundle\Entity\User", cascade={"merge"})
     **/
    protected $professor;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\FichaTecnica", cascade={"all"})
     **/
    protected $divulgacao;

    /**
     * @ORM\Column(type="text")
     **/
    protected $sinopse;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\FichaTecnica", cascade={"all"})
     **/
    protected $informacoesTecnica;

    /**
     * @ORM\ManyToOne(targetEntity="Cinevi\AlmoxarifadoBundle\Entity\FichaTecnica", cascade={"all"})
     **/
    protected $fichaTecnica;

    Fotos Still:Collection

    Cartaz:FileType LiipImagineBundle

    Press-release:FileType .pdf .docx .doc .txt .rtf .odt .odf



    Cromia:Choices

    Proporção:Choices

    Captação:Choices

    Formato:Choices

    Formato Digital Nativo:Choices

    Codec Utilizado:Choices

    Container (wrapper):Choices

    Taxa de Bits:string

    Velocidade:Choices

    Som:Choices

    Resolução Áudio Digital:Choices

    Foi feito DCP:Boolean

    Suporte da matriz digital:Choices

    Câmera(s): Choices

    Equipamento(s) de som: :string

    Softwares de edição utilizado: Choices

    Locações principais (cidade, bairro, rua): Textarea

    Orçamento total (em R$):MoneyType

    Fontes de Financiamento:Collection

    Principais apoiadores (empresas, instituições, órgãos):Textarea

    Duração (em minutos):Integer

    *Ficha Técnica*
        Direção
        Assistente(s) de Direção
        Roteiro
        Argumento
        Direção de Fotografia
        Câmera
        Assistente de Fotografia (e/ou Câmera)
        Still
        Sound Designer
        Edição de Som
        Técnico de Som
        Música
        Eletricista
        Maquinista
        Elenco:String:not-required

        Outras informações dos créditos
        Participações em festivais e mostras
        Prêmios:Textarea:not-required
        Logger
        Assistentes de Montagem
        Montagem
        Assistente(s) de Som
        Figurino
        Assistente de Figurino
        Direção de Arte
        Assistente(s) de Arte
        Produção
        Assistente(s) de Produção
        Platô
        Continuidade

        Currículo do diretor e do produtor:BreveCurriculo

}
