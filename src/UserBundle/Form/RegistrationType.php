<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'security_registration';
    }
}