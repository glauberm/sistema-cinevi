<?php

namespace Cinevi\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reservasFechadas', ChoiceType::class, array(
                'label' => 'Apenas professores podem reservar equipamentos/espaços?',
                'choices' => array(
                    'Sim' => '1',
                    'Não' => '0'
                ),
                'invalid_message' => 'Este não é um valor válido.',
                'expanded' => true,
                'choices_as_values' => true,
            ))
        ;
    }
}
