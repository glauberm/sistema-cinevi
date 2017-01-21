<?php

namespace Cinevi\AlmoxarifadoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome', TextType::class, array(
                'label' => 'Nome',
                'attr' => array(
                    'class' => 'input-lg'
                )
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Salvar',
                'attr' => array(
                    'class' => 'btn btn-lg btn-warning',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\AlmoxarifadoBundle\Entity\Categoria',

        ));
    }
}
