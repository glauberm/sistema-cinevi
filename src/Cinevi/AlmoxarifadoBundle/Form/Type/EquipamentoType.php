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
use Cinevi\AdminBundle\Form\Transformer\EntityToIdObjectTransformer;
use Cinevi\AdminBundle\Form\Transformer\ArrayEntityToArrayIdObjectTransformer;

class EquipamentoType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categoriaArray = array();
        $usersArray = array();

        $categoriaQB = $this->em->getRepository('CineviAlmoxarifadoBundle:Categoria')->createQueryBuilder('c');
        $categoriaQB->orderBy('c.nome', 'ASC');
        foreach ($categoriaQB->getQuery()->getResult() as $result) {
            $categoriaArray[$result->getNome()] = $result->getId();
        }

        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC');
        foreach ($userQB->getQuery()->getResult() as $result) {
            $usersArray[$result->getUsername()] = $result->getId();
        }

        $builder
            ->add('categoria', ChoiceType::class, array(
                'label' => 'Categoria',
                'choices' => $categoriaArray,
                'invalid_message' => 'Este valor não é válido.',
                'choices_as_values' => true,
                'attr' => array(
                    'placeholder' => 'Selecione uma opção...',
                    'class' => 'select2-select',
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
                'choices_as_values' => true,
            ))
            ->add('atrasado', ChoiceType::class, array(
                'label' => 'Devolução Atrasada?',
                'choices' => array(
                    'Não' => '0',
                    'Sim' => '1',
                ),
                'expanded' => true,
                'choices_as_values' => true,
            ))
            ->add('users', ChoiceType::class, array(
                'label' => 'Quais usuários podem reservar este item?',
                'choices' => $usersArray,
                'invalid_message' => 'Este não é um valor válido.',
                'required' => false,
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Todos os usuários',
                ),
            ))
        ;
        $builder->get('categoria')
            ->addModelTransformer(new EntityToIdObjectTransformer($this->em, 'CineviAlmoxarifadoBundle:Categoria'))
        ;
        $builder->get('users')
            ->addModelTransformer(new ArrayEntityToArrayIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\AlmoxarifadoBundle\Entity\Equipamento',

        ));
    }
}
