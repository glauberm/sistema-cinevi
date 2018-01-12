<?php

namespace RealizacaoBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EquipeType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('funcao', EntityType::class, array(
                'label' => 'Função',
                'class' => 'RealizacaoBundle:Funcao',
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getFuncaoFieldQB('user');
                },
    		    'choice_label' => 'getNome',
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione uma opção...',
                ),
            ))
            ->add('users', EntityType::class, array(
                'label' => 'Equipe',
                'class' => 'UserBundle:User',
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getUserFieldQB('user');
                },
    		    'choice_label' => 'getUsername',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione opções...',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RealizacaoBundle\Entity\Equipe',
        ));
    }

}
