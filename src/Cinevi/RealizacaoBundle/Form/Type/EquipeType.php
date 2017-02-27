<?php

namespace Cinevi\RealizacaoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        $funcaoQB = $this->em->getRepository('CineviRealizacaoBundle:Funcao')->createQueryBuilder('f');
        $funcaoQB->orderBy('f.nome', 'ASC');

        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC')->andWhere('u.professor != 1');

        $builder
            ->add('funcao', EntityType::class, array(
                'label' => 'Função',
                'class' => 'CineviRealizacaoBundle:Funcao',
                'query_builder' => $funcaoQB,
                'choice_label' => 'getNome',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('users', EntityType::class, array(
                'label' => 'Equipe',
                'class' => 'CineviSecurityBundle:User',
                'query_builder' => $userQB,
                'choice_label' => 'getUsername',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\RealizacaoBundle\Entity\Equipe',
        ));
    }

}
