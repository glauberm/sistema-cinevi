<?php

namespace Cinevi\ConfigBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reservasFechadas', ChoiceType::class, array(
                'label' => 'Apenas professores podem realizar reservas?',
                'choices' => array(
                    'Não' => '0',
                    'Sim' => '1',
                ),
                'invalid_message' => 'Este não é um valor válido.',
                'expanded' => true,
                'choices_as_values' => true,
            ))
            ->add('mensagemCopiaFinal', TextareaType::class, array(
                'label' => 'Mensagem para Cópias Finais ainda não confirmadas',
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\ConfigBundle\Entity\Config',
        ));
    }
}
