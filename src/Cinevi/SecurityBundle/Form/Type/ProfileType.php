<?php

namespace Cinevi\SecurityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProfileType extends AbstractType
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
            ->add('telefone', IntegerType::class, array(
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
        return 'fos_user_profile';
    }

    public function getName()
    {
        return 'cinevi_profile';
    }
}
