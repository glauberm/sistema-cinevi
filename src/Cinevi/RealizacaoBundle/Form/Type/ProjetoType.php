<?php

namespace Cinevi\RealizacaoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use FOS\RestBundle\Form\Transformer\EntityToIdObjectTransformer;

class ProjetoType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
	    $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC')->andWhere('u.professor != 1');

        $builder
            ->add('realizacao', RealizacaoType::class, array(
                'label' => null
            ))
            ->add('preProducao', DateType::class, array(
                'label'  => 'Pré-Produção',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                )
            ))
            ->add('dataProducao', DateType::class, array(
                'label'  => 'Produção',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                )
            ))
            ->add('posProducao', DateType::class, array(
                'label'  => 'Pós-Produção',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                )
            ))
            ->add('direcao', EntityType::class, array(
                'label' => 'Direção',
                'class' => 'CineviSecurityBundle:User',
                'query_builder' => $userQB,
                'choice_label' => 'getUsername',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                )
            ))
            ->add('producao', EntityType::class, array(
                'label' => 'Produção',
                'class' => 'CineviSecurityBundle:User',
                'query_builder' => $userQB,
                'choice_label' => 'getUsername',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                )
            ))
            ->add('fotografia', EntityType::class, array(
                'label' => 'Direção de Fotografia',
                'class' => 'CineviSecurityBundle:User',
                'query_builder' => $userQB,
                'choice_label' => 'getUsername',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                )
            ))
            ->add('disciplinaFotografia', ChoiceType::class, array(
                'label' => ' Já cursou a disciplina de Fotografia e Iluminação?',
                'choices' => array(
                    'Sim'   => '1',
                    'Não'   => '0',
                ),
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('som', EntityType::class, array(
                'label' => 'Direção de Som',
                'class' => 'CineviSecurityBundle:User',
                'query_builder' => $userQB,
                'choice_label' => 'getUsername',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                )
            ))
            ->add('disciplinaSom', ChoiceType::class, array(
                'label' => ' Já cursou a disciplina de Técnica de Som em Cinema e Audiovisual?',
                'choices' => array(
                    'Sim'   => '1',
                    'Não'   => '0',
                ),
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('arte', EntityType::class, array(
                'label' => 'Direção de Arte',
                'class' => 'CineviSecurityBundle:User',
                'query_builder' => $userQB,
                'choice_label' => 'getUsername',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                )
            ))
            ->add('disciplinaArte', ChoiceType::class, array(
                'label' => ' Já cursou a disciplina de Direção de Arte?',
                'choices' => array(
                    'Sim' => '1',
                    'Não' => '0',
                ),
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Salvar',
                'attr' => array(
                    'class' => 'btn btn-lg btn-warning',
                ),
            ))
        ;

        /*$userTransformer = new EntityToIdObjectTransformer($this->om, "CineviSecurityBundle:User");
        $builder->get('user')->addModelTransformer($userTransformer);*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\RealizacaoBundle\Entity\Projeto',
        ));
    }

}
