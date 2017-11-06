<?php

namespace Cinevi\RealizacaoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Cinevi\AdminBundle\Form\Transformer\ArrayEntityToArrayIdObjectTransformer;
use Cinevi\RealizacaoBundle\Validation\RealizacaoValidationGroupResolver;

class ProjetoType extends AbstractType
{
    private $em;
    private $tokenStorage;
    private $groupResolver;

    public function __construct(EntityManager $em, TokenStorageInterface $tokenStorage, RealizacaoValidationGroupResolver $groupResolver)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
        $this->groupResolver = $groupResolver;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userArray = array();

        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC');
        foreach ($userQB->getQuery()->getResult() as $result) {
            $userArray[$result->getUsername()] = $result->getId();
        }

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
            ->add('direcao', ChoiceType::class, array(
                'label' => 'Direção',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'placeholder' => 'Selecione opções...',
                    'class' => 'select2-select',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('producao', ChoiceType::class, array(
                'label' => 'Produção',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'placeholder' => 'Selecione opções...',
                    'class' => 'select2-select',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('fotografia', ChoiceType::class, array(
                'label' => 'Direção de Fotografia',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'placeholder' => 'Selecione opções...',
                    'class' => 'select2-select',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('disciplinaFotografia', ChoiceType::class, array(
                'label' => ' Já cursou(aram) a disciplina de Fotografia e Iluminação?',
                'choices' => array(
                    'Sim' => '1',
                ),
                'choices_as_values' => true,
                'expanded' => true,
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor(),
                'placeholder' => 'Não informado'
            ))
            ->add('som', ChoiceType::class, array(
                'label' => 'Direção de Som',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'multiple' => true,
                'choices_as_values' => true,
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
                'choices_as_values' => true,
                'expanded' => true,
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor(),
                'placeholder' => 'Não informado'
            ))
            ->add('arte', ChoiceType::class, array(
                'label' => 'Direção de Arte',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'placeholder' => 'Selecione opções...',
                    'class' => 'select2-select',
                ),
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor()
            ))
            ->add('disciplinaArte', ChoiceType::class, array(
                'label' => ' Já cursou(aram) a disciplina de Design Visual?',
                'choices' => array(
                    'Sim' => '1',
                ),
                'choices_as_values' => true,
                'expanded' => true,
                'required' => !$this->tokenStorage->getToken()->getUser()->getProfessor(),
                'placeholder' => 'Não informado'
            ))
        ;

        $builder->get('direcao')
            ->addModelTransformer(new ArrayEntityToArrayIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
        $builder->get('producao')
            ->addModelTransformer(new ArrayEntityToArrayIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
        $builder->get('fotografia')
            ->addModelTransformer(new ArrayEntityToArrayIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
        $builder->get('som')
            ->addModelTransformer(new ArrayEntityToArrayIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
        $builder->get('arte')
            ->addModelTransformer(new ArrayEntityToArrayIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\RealizacaoBundle\Entity\Projeto',
            'validation_groups' => $this->groupResolver,
        ));
    }
}
