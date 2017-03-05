<?php

namespace Cinevi\RealizacaoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Cinevi\AdminBundle\Form\Transformer\EntityToIdObjectTransformer;
use Cinevi\AdminBundle\Form\Transformer\ArrayEntityToArrayIdObjectTransformer;

class EquipeType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $funcaoArray = array();
        $userArray = array();

        // Pega todas as funções
        $funcaoQB = $this->em->getRepository('CineviRealizacaoBundle:Funcao')->createQueryBuilder('f');
        $funcaoQB->orderBy('f.nome', 'ASC');
        foreach ($funcaoQB->getQuery()->getResult() as $result) {
            $funcaoArray[$result->getNome()] = $result->getId();
        }

        // Pega todos os usuários não-professores
        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC')->andWhere('u.professor != 1');
        foreach ($userQB->getQuery()->getResult() as $result) {
            $userArray[$result->getUsername()] = $result->getId();
        }

        $builder
            ->add('funcao', ChoiceType::class, array(
                'label' => 'Função',
                'choices' => $funcaoArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('users', ChoiceType::class, array(
                'label' => 'Equipe',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
        ;
        $builder->get('funcao')
            ->addModelTransformer(new EntityToIdObjectTransformer($this->em, 'CineviRealizacaoBundle:Funcao'))
        ;
        $builder->get('users')
            ->addModelTransformer(new ArrayEntityToArrayIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\RealizacaoBundle\Entity\Equipe',
        ));
    }

}
