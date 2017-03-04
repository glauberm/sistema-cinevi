<?php

namespace Cinevi\RealizacaoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Cinevi\AdminBundle\Form\Transformer\EntityToIdObjectTransformer;

class RealizacaoType extends AbstractType
{
    private $em;
    private $authorizationChecker;

    public function __construct(EntityManager $em, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userArray = array();
        $professorArray = array();

        // Pega os usuários que o usuário atual pode ver
        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC')->andWhere('u.professor != 1');
        foreach ($userQB->getQuery()->getResult() as $result) {
            if (true === $this->authorizationChecker->isGranted('view', $result)) {
                $userArray[$result->getId()] = $result->getUsername();
            }
        }

        // Pega todos os professores
        $professorQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('p');
        $professorQB->orderBy('p.username', 'ASC')->andWhere('p.professor = 1');
        foreach ($professorQB->getQuery()->getResult() as $result) {
            $professorArray[$result->getId()] = $result->getUsername();
        }

        $builder
            ->add('user', ChoiceType::class, array(
                'label' => 'Responsável',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
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
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('professor', ChoiceType::class, array(
                'label' => 'Professor(a) Orientador(a)',
                'choices' => $professorArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
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
                'placeholder' => 'Selecione opções...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
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
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('detalhesCaptacao', TextareaType::class, array(
                'label' => 'Detalhes da Captação',
                'required' => false,
            ))
            ->add('locacoes', TextareaType::class, array(
                'label' => 'Locações',
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
        ));
    }
}
