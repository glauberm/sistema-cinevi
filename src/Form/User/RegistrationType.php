<?php

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use FOS\UserBundle\Form\Type\RegistrationFormType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricula', IntegerType::class, array(
                'label' => 'Matrícula/SIAPE',
                'attr' => array(
                    'class' => 'input-number'
                )
            ))
            ->add('telefone', TextType::class, array(
                'label' => 'Telefone',
                'attr' => array(
                    'class' => 'input-tel',
                )
            ))
            ->add('breveCurriculo', TextareaType::class, array(
                'label' => 'Breve Currículo',
                'required' => false,
            ))
        ;
    }

    public function getParent()
    {
        return RegistrationFormType::class;
    }
}
