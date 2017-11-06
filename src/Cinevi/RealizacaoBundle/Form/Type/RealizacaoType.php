<?php

namespace Cinevi\RealizacaoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Cinevi\AdminBundle\Form\Transformer\EntityToIdObjectTransformer;
use Cinevi\RealizacaoBundle\Validation\RealizacaoValidationGroupResolver;

class RealizacaoType extends AbstractType
{
    private $em;
    private $authorizationChecker;
    private $tokenStorage;
    private $groupResolver;

    public function __construct(EntityManager $em, AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $tokenStorage, RealizacaoValidationGroupResolver $groupResolver)
    {
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
        $this->groupResolver = $groupResolver;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userArray = array();
        $professorArray = array();

        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC');
        foreach ($userQB->getQuery()->getResult() as $result) {
            if (true === $this->authorizationChecker->isGranted('edit', $result)) {
                $userArray[$result->getUsername()] = $result->getId();
            }
        }

        $professorQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('p');
        $professorQB->orderBy('p.username', 'ASC')->where('p.professor = 1');
        foreach ($professorQB->getQuery()->getResult() as $result) {
            $professorArray[$result->getUsername()] = $result->getId();
        }

        $builder
            ->add('user', ChoiceType::class, array(
                'label' => 'Responsável',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'choices_as_values' => true,
                'attr' => array(
                    'placeholder' => 'Selecione uma opção...',
                    'class' => 'select2-select',
                )
            ))
            ->add('titulo', TextType::class, array(
                'label' => 'Título',
                'attr' => array(
                    'class' => 'input-lg',
                ),
            ))
            ->add('sinopse', TextareaType::class, array(
                'label' => 'Sinopse',
                'attr' => array(
                    'maxLength' => 255,
                ),
            ))
            ->add('modalidade', ChoiceType::class, array(
                'label' => 'Modalidade',
                'choices' => array(
                    'Livre Iniciativa' => 'Livre Iniciativa',
                    'Filme de Realização' => 'Filme de Realização',
                    'Disciplina Obrigatória' => 'Disciplina Obrigatória',
                    'Disciplina Não-Obrigatória' => 'Disciplina Não-Obrigatória',
                    'Edital' => 'Edital',
                    'Outra' => 'Outra',
                ),
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione uma opção...',
                ),
            ))
            ->add('professor', ChoiceType::class, array(
                'label' => 'Professor(a) Orientador(a)',
                'choices' => $professorArray,
                'invalid_message' => 'Este não é um valor válido.',
                'choices_as_values' => true,
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
                'choices_as_values' => true,
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
                'choices_as_values' => true,
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

        $builder->get('user')
            ->addModelTransformer(new EntityToIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
        $builder->get('professor')
            ->addModelTransformer(new EntityToIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\RealizacaoBundle\Entity\Realizacao',
            'validation_groups' => $this->groupResolver,
        ));
    }
}
