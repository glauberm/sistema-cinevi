<?php

namespace Cinevi\AlmoxarifadoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FotografiaType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC');

        $builder
            ->add('users', EntityType::class, array(
                'label' => 'Equipe',
                'class' => 'CineviSecurityBundle:User',
                'query_builder' => $userQB,
                'choice_label' => 'getUsername',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
                'multiple' => true,
                'attr' => array(
                    'data-placeholder' => 'Selecione opções...',
                    'class' => 'chosen-select',
                )
            ))
            ->add('breveCurriculo', TextareaType::class, array(
                'label' => 'Breve Currículo',
                'required' => false,
            ))
            ->add('disciplina', ChoiceType::class, array(
                'label' => ' Já cursou a disciplina de Fotografia e Iluminação?',
                'choices' => array(
                    'Sim'   => '1',
                    'Não'   => '0',
                ),
                'choices_as_values' => true,
                'expanded' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\AlmoxarifadoBundle\Entity\Fotografia',
        ));
    }

}
