<?php

namespace Cinevi\RealizacaoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Cinevi\AdminBundle\Form\Transformer\ArrayEntityToArrayIdObjectTransformer;

class ProjetoType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userArray = array();

        // Pega todos os usuários
        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC')->andWhere('u.professor != 1');
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
            ))
            ->add('dataProducao', DateType::class, array(
                'label' => 'Produção',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                ),
            ))
            ->add('posProducao', DateType::class, array(
                'label' => 'Pós-Produção',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                ),
            ))
            ->add('direcao', ChoiceType::class, array(
                'label' => 'Direção',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('producao', ChoiceType::class, array(
                'label' => 'Produção',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('fotografia', ChoiceType::class, array(
                'label' => 'Direção de Fotografia',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('disciplinaFotografia', ChoiceType::class, array(
                'label' => ' Já cursou(aram) a disciplina de Fotografia e Iluminação?',
                'choices' => array(
                    'Sim' => '1',
                ),
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('som', ChoiceType::class, array(
                'label' => 'Direção de Som',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('disciplinaSom', ChoiceType::class, array(
                'label' => ' Já cursou(aram) a disciplina de Técnica de Som em Cinema e Audiovisual?',
                'choices' => array(
                    'Sim' => '1',
                ),
                'choices_as_values' => true,
                'expanded' => true,
            ))
            ->add('arte', ChoiceType::class, array(
                'label' => 'Direção de Arte',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('disciplinaArte', ChoiceType::class, array(
                'label' => ' Já cursou(aram) a disciplina de Direção de Arte?',
                'choices' => array(
                    'Sim' => '1',
                ),
                'choices_as_values' => true,
                'expanded' => true,
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
        ));
    }
}
