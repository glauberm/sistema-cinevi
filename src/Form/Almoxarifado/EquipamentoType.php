<?php

namespace App\Form\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Equipamento;
use App\Entity\Categoria;
use App\Entity\User;

class EquipamentoType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoria', EntityType::class, array(
    		    'label' => 'Categoria',
    		    'class' => Categoria::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getCategoriaFieldQB('categoria');
                },
    		    'choice_label' => 'getNome',
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione uma opção...',
                )
    	    ))
            ->add('codigo', TextType::class, array(
                'label' => 'Cód.',
                'attr' => array(
                    'class' => 'input-lg'
                )
            ))
            ->add('nome', TextType::class, array(
                'label' => 'Nome',
                'attr' => array(
                    'class' => 'input-lg'
                )
            ))
            ->add('patrimonio', IntegerType::class, array(
                'label' => 'Nº de Patrimônio',
                'required' => false,
                'attr' => array(
                    'class' => 'input-number'
                )
            ))
            ->add('nSerie', TextType::class, array(
                'label' => 'Nº de Série',
                'required' => false,
            ))
            ->add('acessorios', TextareaType::class, array(
                'label' => 'Acessórios',
                'required' => false,
            ))
            ->add('obs', TextareaType::class, array(
                'label' => 'Observações',
                'required' => false,
            ))
            ->add('manutencao', ChoiceType::class, array(
                'label' => 'Em manutenção?',
                'choices' => array(
                    'Não' => '0',
                    'Sim' => '1',
                ),
                'expanded' => true,
            ))
            ->add('atrasado', ChoiceType::class, array(
                'label' => 'Devolução Atrasada?',
                'choices' => array(
                    'Não' => '0',
                    'Sim' => '1',
                ),
                'expanded' => true,
            ))
            ->add('users', EntityType::class, array(
    		    'label' => 'Quais usuários podem reservar este item?',
    		    'class' => User::class,
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getUserFieldQB('user');
                },
    		    'choice_label' => 'getUsername',
                'required' => false,
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Todos os usuários',
                ),
    	    ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Equipamento::class,
        ));
    }
}
