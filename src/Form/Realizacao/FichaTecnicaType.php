<?php

namespace App\Form\Realizacao;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FichaTecnicaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipes', CollectionType::class, array(
                'label' => false,
                'entry_type' => EquipeType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => array('data_class' => 'App\Entity\Equipe'),
            ))
            ->add('elenco', TextareaType::class, array(
                'label' => 'Elenco',
                'required' => false,
            ))
            ->add('outrasInformacoes', TextareaType::class, array(
                'label' => 'Outras Informações dos Créditos',
                'required' => false,
            ))
            ->add('festivais', TextareaType::class, array(
                'label' => 'Participações em festivais e mostras',
                'required' => false,
            ))
            ->add('premios', TextareaType::class, array(
                'label' => 'Prêmios',
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\FichaTecnica',
        ));
    }
}
