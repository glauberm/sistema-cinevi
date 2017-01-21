<?php

namespace Cinevi\AlmoxarifadoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
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
    private $authorizationChecker;

    public function __construct(EntityManager $em, AuthorizationCheckerInterface $authorizationChecker)
    {
	    $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC');

        foreach ($userQB->getQuery()->getResult() as $result) {
            if (false === $this->authorizationChecker->isGranted('view', $result)) {
                $userQB->andWhere('u.id != '.$result->getId());
            }
        }

        $professorQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('p');
        $professorQB->orderBy('p.username', 'ASC')->andWhere('p.professor = 1');;

        $builder
            ->add('nome', TextType::class, array(
                'label' => 'Nome',
                'attr' => array(
                    'class' => 'input-lg'
                )
            ))
            ->add('user', EntityType::class, array(
                'label' => 'Responsável',
                'class' => 'CineviSecurityBundle:User',
                'query_builder' => $userQB,
                'choice_label' => 'getUsername',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'data-placeholder' => 'Selecione uma opção...',
                    'class' => 'chosen-select',
                )
            ))
            ->add('modalidade', ChoiceType::class, array(
                'label' => 'Modalidade',
                'choices' => array(
                    'Disciplina Obrigatória'   => 'Disciplina Obrigatória',
                    'Disciplina Não-Obrigatória'   => 'Disciplina Não-Obrigatória',
                    'Realização'   => 'Realização',
                    'Livre Iniciativa'   => 'Livre Iniciativa',
                    'Outra'   => 'Outra',
                ),
                'choices_as_values' => true,
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'data-placeholder' => 'Selecione uma opção...',
                    'class' => 'chosen-select',
                )
            ))
            ->add('professor', EntityType::class, array(
                'label' => 'Professor(a)',
                'class' => 'CineviSecurityBundle:User',
                'query_builder' => $professorQB,
                'choice_label' => 'getUsername',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'data-placeholder' => 'Selecione uma opção...',
                    'class' => 'chosen-select',
                )
            ))
            ->add('captacao', ChoiceType::class, array(
                'label' => 'Captação',
                'choices' => array(
                    'Vídeo'   => 'Vídeo',
                    'Película'   => 'Película',
                    'Digital'   => 'Digital',
                ),
                'choices_as_values' => true,
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'data-placeholder' => 'Selecione uma opção...',
                    'class' => 'chosen-select',
                )
            ))
            ->add('detalhesCaptacao', TextareaType::class, array(
                'label' => 'Detalhes da Captação',
                'required' => false,
            ))
            ->add('genero', TextType::class, array(
                'label' => 'Gênero',
            ))
            ->add('locacao', TextType::class, array(
                'label' => 'Locação',
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
            ->add('direcao', DirecaoType::class, array(
                'label'  => false,
            ))
            ->add('producao', ProducaoType::class, array(
                'label'  => false,
            ))
            ->add('fotografia', FotografiaType::class, array(
                'label'  => false,
            ))
            ->add('som', SomType::class, array(
                'label'  => false,
            ))
            ->add('arte', ArteType::class, array(
                'label'  => false,
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
            'data_class' => 'Cinevi\AlmoxarifadoBundle\Entity\Projeto',
        ));
    }

}
