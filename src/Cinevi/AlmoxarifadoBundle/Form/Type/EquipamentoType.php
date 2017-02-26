<?php

namespace Cinevi\AlmoxarifadoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EquipamentoType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categoriaQB = $this->em->getRepository('CineviAlmoxarifadoBundle:Categoria')->createQueryBuilder('c');
        $categoriaQB->orderBy('c.nome', 'ASC');

        $builder
            ->add('nome', TextType::class, array(
                'label' => 'Nome',
                'attr' => array(
                    'class' => 'input-lg'
                )
            ))
            ->add('patrimonio', IntegerType::class, array(
                'label' => 'Nº de Patrimônio',
                'required' => false,
            ))
            ->add('categoria', EntityType::class, array(
                'label' => 'Categoria(s)',
                'class' => 'CineviAlmoxarifadoBundle:Categoria',
                'query_builder' => $categoriaQB,
                'choice_label' => 'getNome',
                'invalid_message' => 'Este valor não é válido.',
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                )
            ))
            ->add('manutencao', ChoiceType::class, array(
                'label' => 'Em manutenção?',
                'choices' => array(
                    'Não' => '0',
                    'Sim' => '1',
                ),
                'expanded' => true,
                'choices_as_values' => true,
                'placeholder' => 'Selecione uma opção...',
            ))
            ->add('uso', ChoiceType::class, array(
                'label' => 'Falta de Uso?',
                'choices' => array(
                    'Não' => '0',
                    'Sim' => '1',
                ),
                'expanded' => true,
                'choices_as_values' => true,
                'placeholder' => 'Selecione uma opção...',
            ))
            ->add('consumivel', ChoiceType::class, array(
                'label' => 'Consumível?',
                'choices' => array(
                    'Não' => '0',
                    'Sim' => '1',
                ),
                'expanded' => true,
                'choices_as_values' => true,
                'placeholder' => 'Selecione uma opção...',
            ))
            ->add('obs', TextareaType::class, array(
                'label' => 'Observações',
                'required' => false,
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
            'data_class' => 'Cinevi\AlmoxarifadoBundle\Entity\Equipamento',

        ));
    }
}
