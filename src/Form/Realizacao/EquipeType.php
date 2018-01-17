<?php

namespace App\Form\Realizacao;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Equipe;
use App\Entity\Funcao;
use App\Entity\User;

class EquipeType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('funcao', EntityType::class, array(
                'label' => 'Função',
                'class' => Funcao::class,
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
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Equipe::class,
        ));
    }
}
