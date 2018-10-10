<?php

namespace App\Form\Realizacao;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Validation\Realizacao\RealizacaoValidationGroupResolver;
use App\Entity\Realizacao;
use App\Entity\User;
use App\Entity\Modalidade;

class RealizacaoType extends AbstractType
{
    private $em;
    private $authorizationChecker;
    private $tokenStorage;
    private $groupResolver;

    public function __construct(EntityManagerInterface $em, AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $tokenStorage, RealizacaoValidationGroupResolver $groupResolver)
    {
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
        $this->groupResolver = $groupResolver;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class, array(
                'label' => 'Título',
                'attr' => array(
                    'class' => 'input-lg',
                ),
            ))
            ->add('sinopse', TextareaType::class, array(
                'label' => 'Sinopse',
            ))
            ->add('user', EntityType::class, array(
    		    'label' => 'Responsável',
    		    'class' => User::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getAuthorizedUserFieldQB($this->authorizationChecker, 'user');
                },
    		    'choice_label' => 'getUsername',
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione uma opção...',
                ),
    	    ))
            ->add('modalidade', EntityType::class, array(
    		    'label' => 'Modalidade',
    		    'class' => Modalidade::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getModalidadeFieldQB('user');
                },
    		    'choice_label' => 'getNome',
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione uma opção...',
                ),
    	    ))
            ->add('professor', EntityType::class, array(
    		    'label' => 'Professor Orientador',
    		    'class' => User::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getProfessorFieldQB('user');
                },
    		    'choice_label' => 'getUsername',
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione uma opção...',
                ),
    	    ))
            ->add('genero', ChoiceType::class, array(
                'label' => 'Gênero(s)',
                'choices' => array(
                    'Ficção' => 'Ficção',
                    'Documentário' => 'Documentário',
                    'Animação' => 'Animação',
                    'Experimental' => 'Experimental',
                    'Outro(s)' => 'Outro(s)',
                ),
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione opções...',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('captacao', ChoiceType::class, array(
                'label' => 'Captação',
                'choices' => array(
                    'Vídeo' => 'Vídeo',
                    'Película' => 'Película',
                    'Digital' => 'Digital',
                    'Outra' => 'Outra',
                ),
                'attr' => array(
                    'placeholder' => 'Selecione uma opção...',
                    'class' => 'select2-select',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('detalhesCaptacao', TextareaType::class, array(
                'label' => 'Detalhes da Captação',
                'required' => false,
            ))
            ->add('locacoes', TextareaType::class, array(
                'label' => 'Locações',
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Realizacao::class,
            'validation_groups' => $this->groupResolver,
        ));
    }
}
