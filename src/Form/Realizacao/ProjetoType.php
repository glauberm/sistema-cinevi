<?php

namespace App\Form\Realizacao;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Validation\Realizacao\RealizacaoValidationGroupResolver;
use App\Entity\Projeto;
use App\Entity\User;

class ProjetoType extends AbstractType
{
    private $em;
    private $tokenStorage;
    private $groupResolver;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage, RealizacaoValidationGroupResolver $groupResolver)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->groupResolver = $groupResolver;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('realizacao', RealizacaoType::class, array(
                'label' => null,
            ))
            ->add('preProducao', DateType::class, array(
                'label' => 'Pré-Produção',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('dataProducao', DateType::class, array(
                'label' => 'Produção',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('posProducao', DateType::class, array(
                'label' => 'Pós-Produção',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('direcao', EntityType::class, array(
    		    'label' => 'Direção',
    		    'class' => User::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getUserFieldQB('user');
                },
    		    'choice_label' => 'getUsername',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione opções...',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
    	    ))
            ->add('producao', EntityType::class, array(
                'label' => 'Produção',
                'class' => User::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getUserFieldQB('user');
                },
    		    'choice_label' => 'getUsername',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione opções...',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('fotografia', EntityType::class, array(
                'label' => 'Direção de Fotografia',
                'class' => User::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getUserFieldQB('user');
                },
    		    'choice_label' => 'getUsername',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione opções...',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('disciplinaFotografia', ChoiceType::class, array(
                'label' => ' Já cursou(aram) a disciplina de Fotografia e Iluminação?',
                'choices' => array(
                    'Sim' => '1',
                ),
                'expanded' => true,
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor(),
                'placeholder' => 'Não informado'
            ))
            ->add('som', EntityType::class, array(
                'label' => 'Direção de Som',
                'class' => User::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getUserFieldQB('user');
                },
    		    'choice_label' => 'getUsername',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione opções...',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('disciplinaSom', ChoiceType::class, array(
                'label' => ' Já cursou(aram) a disciplina de Técnica de Som em Cinema e Audiovisual?',
                'choices' => array(
                    'Sim' => '1',
                ),
                'expanded' => true,
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor(),
                'placeholder' => 'Não informado'
            ))
            ->add('arte', EntityType::class, array(
                'label' => 'Direção de Arte',
                'class' => User::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getUserFieldQB('user');
                },
    		    'choice_label' => 'getUsername',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione opções...',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('disciplinaArte', ChoiceType::class, array(
                'label' => ' Já cursou(aram) a disciplina de Design Visual?',
                'choices' => array(
                    'Sim' => '1',
                ),
                'expanded' => true,
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor(),
                'placeholder' => 'Não informado'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Projeto::class,
            'validation_groups' => $this->groupResolver,
        ));
    }
}
