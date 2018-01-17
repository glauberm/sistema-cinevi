<?php

namespace App\Form\Realizacao;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Validation\Realizacao\CopiaFinalValidationGroupResolver;
use App\Entity\CopiaFinal;
use App\Entity\Projeto;

class CopiaFinalType extends AbstractType
{
    private $em;
    private $authorizationChecker;
    private $groupResolver;

    public function __construct(EntityManagerInterface $em, AuthorizationCheckerInterface $authorizationChecker, CopiaFinalValidationGroupResolver $groupResolver)
    {
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
        $this->groupResolver = $groupResolver;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('realizacao', RealizacaoType::class, array(
                'label' => null,
            ))
            ->add('projeto', EntityType::class, array(
                'label' => 'Projeto',
                'class' => Projeto::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getAuthorizedProjetoFieldQB($this->authorizationChecker, 'user');
                },
    		    'choice_label' => 'getTitulo',
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Outro',
                ),
                'required' => false,
            ))
            ->add('cromia', ChoiceType::class, array(
                'label' => 'Cromia',
                'choices' => array(
                    'P&B' => 'P&B',
                    'Cor' => 'Cor',
                    'Outra(s)' => 'Outra(s)',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('proporcao', ChoiceType::class, array(
                'label' => 'Proporção',
                'choices' => array(
                    'Padrão HD - 16:9' => 'Padrão HD - 16:9',
                    'Scope - 2,39:1' => 'Scope - 2,39:1',
                    'Flat - 1:1,85' => 'Flat - 1:1,85',
                    'Acadêmico' => '1,37:1',
                    'Outra' => 'Outra',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('formato', ChoiceType::class, array(
                'label' => 'Formato da Cópia Final',
                'choices' => array(
                    'Vídeo' => 'Vídeo',
                    'Película' => 'Película',
                    'Digital' => 'Digital',
                    'Outro' => 'Outro',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('duracao', IntegerType::class, array(
                'label' => 'Duração (em minutos)',
                'required' => false,
                'attr' => array(
                    'class' => 'input-number'
                )
            ))
            ->add('formatoDigitalNativo', ChoiceType::class, array(
                'label' => 'Formato Digital Nativo',
                'choices' => array(
                    'CinemaDNG' => 'CinemaDNG',
                    'Prores' => 'Prores',
                    'AVCHD' => 'AVCHD',
                    'WMV' => 'WMV',
                    'QTTF' => 'QTTF',
                    'F4V' => 'F4V',
                    'MXF' => 'MXF',
                    'AXF' => 'AXF',
                    'MOV' => 'MOV',
                    'DNX' => 'DNX',
                    'TIFF' => 'TIFF',
                    'Outro' => 'Outro',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('codec', ChoiceType::class, array(
                'label' => 'Codec',
                'choices' => array(
                    'Prores' => 'Prores',
                    'H.264' => 'H.264',
                    'MJPEG2000' => 'MJPEG2000',
                    'Outro' => 'Outro',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('container', ChoiceType::class, array(
                'label' => 'Container (Wrapper)',
                'choices' => array(
                    'DNG' => 'DNG',
                    'MOV' => 'MOV',
                    'MTS' => 'MTS',
                    'AVI' => 'AVI',
                    'WMV' => 'WMV',
                    'MP4' => 'MP4',
                    'MPEG-2' => 'MPEG-2',
                    'MPEG-4' => 'MPEG-4',
                    'Outro' => 'Outro',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('taxaBits', IntegerType::class, array(
                'label' => 'Taxa de Bits',
                'required' => false,
                'attr' => array(
                    'class' => 'input-number'
                )
            ))
            ->add('velocidade', ChoiceType::class, array(
                'label' => 'Velocidade',
                'choices' => array(
                    '24 fps' => '24 fps',
                    '29.97 fps' => '29.97 fps',
                    'Outra' => 'Outra',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('som', ChoiceType::class, array(
                'label' => 'Som',
                'choices' => array(
                    'Mono' => 'Mono',
                    'Estéreo' => 'Estéreo',
                    '5.1' => '5.1',
                    '6.1' => '6.1',
                    'Outro' => 'Outro',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('resolucaoAudioDigital', ChoiceType::class, array(
                'label' => 'Resolução do Audio Digital',
                'choices' => array(
                    '16 bits' => '16 bits',
                    '24 bits' => '24 bits',
                    '44.1 khz' => '44.1 khz',
                    '48 khz' => '48 khz',
                    'Outra' => 'Outra',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('suporteMatrizDigital', ChoiceType::class, array(
                'label' => 'Suporte da matriz digital',
                'choices' => array(
                    'HD' => 'HD',
                    'HD Externo' => 'HD Externo',
                    'DVD-R' => 'DVD-R',
                    'LTO' => 'LTO',
                    'Outro' => 'Outro',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('camera', ChoiceType::class, array(
                'label' => 'Câmera',
                'choices' => array(
                    'Canon 5D Mark II' => 'Canon 5D Mark II',
                    'Canon 5D Mark III' => 'Canon 5D Mark III',
                    'Canon 3Ti' => 'Canon 3Ti',
                    'SonyNEX-FS700K' => 'SonyNEX-FS700K',
                    'Outra' => 'Outra',
                ),
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('captacaoSom', TextareaType::class, array(
                'label' => 'Equipamento de Captação de Som',
                'required' => false,
            ))
            ->add('softwareEdicao', ChoiceType::class, array(
                'label' => 'Software(s) de edição',
                'choices' => array(
                    'Adobe Premiere' => 'Adobe Premiere',
                    'Sony Vegas' => 'Sony Vegas',
                    'FinalCut' => 'FinalCut',
                    'DaVinci Resolve' => 'DaVinci Resolve',
                    'Blender' => 'Blender',
                    'Outro(s)' => 'Outro(s)',
                ),
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('orcamento', MoneyType::class, array(
    		    'currency' => 'BRL',
                'scale' => 2,
                'grouping' => true,
                'attr' => array(
                    'class' => 'input-money',
                ),
                'required' => false,
    	    ))
            ->add('fontesFinanciamento', ChoiceType::class, array(
                'label' => 'Fonte(s) de Financiamento',
                'choices' => array(
                    'Recursos Próprios' => 'Recursos Próprios',
                    'Edital' => 'Edital',
                    'Financiamento Coletivo' => 'Financiamento Coletivo',
                    'Outro(s)' => 'Outro(s)',
                ),
                'multiple'=> true,
                'placeholder' => 'Selecione opções...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
                'required' => false,
            ))
            ->add('apoiadores', TextareaType::class, array(
                'label' => 'Apoiadores (empresas, instituições, órgãos)',
                'required' => false,
            ))
            ->add('dcp', ChoiceType::class, array(
                'label' => 'Foi feito DCP?',
                'choices' => array(
                    'Sim' => '1',
                    'Não' => '0',
                ),
                'placeholder' => 'Não sei',
                'required' => false,
                'expanded' => true,
            ))
            ->add('fichaTecnica', FichaTecnicaType::class, array(
                'label' => false,
            ))
            ->add('linkVideo', UrlType::class, array(
                'label' => 'Link para o vídeo no YouTube/Vimeo',
                'required' => false,
    	    ))
            ->add('senhaVideo', TextType::class, array(
                'label' => 'Senha para o vídeo',
                'required' => false,
    	    ))
        ;

        if($this->authorizationChecker->isGranted('ROLE_DEPARTAMENTO')) {
            $builder
                ->add('confirmado', ChoiceType::class, array(
                    'label' => 'Aprovação da cópia final confirmada?',
                    'choices' => array(
                        'Não'   => '0',
                        'Sim'   => '1',
                    ),
                    'expanded' => true,
                ))
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CopiaFinal::class,
            'validation_groups' => $this->groupResolver,
        ));
    }
}
