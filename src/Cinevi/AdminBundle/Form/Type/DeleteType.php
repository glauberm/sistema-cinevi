<?php

namespace Cinevi\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('remover', SubmitType::class, array(
                'label' => 'Remover',
                'attr' => array(
                    'class' => 'btn btn-danger',
                ),
            ))
        ;
    }
}
