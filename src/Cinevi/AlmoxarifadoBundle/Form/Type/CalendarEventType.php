<?php

namespace Cinevi\AlmoxarifadoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Cinevi\AdminBundle\Form\Transformer\EntityToIdObjectTransformer;
use Cinevi\AdminBundle\Form\Transformer\ArrayEntityToArrayIdObjectTransformer;

class CalendarEventType extends AbstractType
{
    private $em;
    private $authorizationChecker;

    public function __construct(EntityManager $em, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userArray = array();
        $projetoArray = array();
        $equipamentoArray = array();
        $categoriaArray = array();

        // Pega os usuários que o usuário atual pode ver
        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC')->where('u.professor != 1');
        foreach ($userQB->getQuery()->getResult() as $result) {
            if (true === $this->authorizationChecker->isGranted('edit', $result)) {
                $userArray[$result->getUsername()] = $result->getId();
            }
        }

        // Pega os projetos que o usuário atual pode ver
        $projetoQB = $this->em->getRepository('CineviRealizacaoBundle:Projeto')->createQueryBuilder('p');
        $projetoQB->orderBy('p.id', 'DESC');
        foreach ($projetoQB->getQuery()->getResult() as $result) {
            if (true === $this->authorizationChecker->isGranted('edit', $result)) {
                $projetoArray[$result->getRealizacao()->getTitulo()] = $result->getId();
            }
        }

        // Pega todas os equipamentos por categoria
        $categoriaQB = $this->em->getRepository('CineviAlmoxarifadoBundle:Categoria')->createQueryBuilder('c');
        $categoriaQB->orderBy('c.nome', 'ASC');
        foreach ($categoriaQB->getQuery()->getResult() as $categoria) {
            $equipamentoQB = $this->em->getRepository('CineviAlmoxarifadoBundle:Equipamento')->createQueryBuilder('e');
            $equipamentoQB->orderBy('e.nome', 'ASC')
                ->where('e.categoria = '.$categoria->getId())
                ->andWhere('e.manutencao != 1');
            foreach ($equipamentoQB->getQuery()->getResult() as $equipamento) {
                $equipamentosArray[$equipamento->getNome()] = $equipamento->getId();
            }
            $categoriaArray[$categoria->getNome()] = $equipamentosArray;
        }

        $builder
            ->add('user', ChoiceType::class, array(
                'label' => 'Responsável',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('projeto', ChoiceType::class, array(
                'label' => 'Projeto',
                'choices' => $projetoArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
            ->add('startDate', DateTimeType::class, array(
                'label' => 'Data de Retirada',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                ),
            ))
            ->add('endDate', DateTimeType::class, array(
                'label' => 'Data de Devolução',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                ),
            ))
            ->add('equipamentos', ChoiceType::class, array(
                'label' => 'Equipamento(s)',
                'choices' => $categoriaArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
                'choices_as_values' => true,
                'attr' => array(
                    'class' => 'select2-select',
                ),
            ))
        ;
        $builder->get('user')
            ->addModelTransformer(new EntityToIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
        $builder->get('projeto')
            ->addModelTransformer(new EntityToIdObjectTransformer($this->em, 'CineviRealizacaoBundle:Projeto'))
        ;
        $builder->get('equipamentos')
            ->addModelTransformer(new ArrayEntityToArrayIdObjectTransformer($this->em, 'CineviAlmoxarifadoBundle:Equipamento'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\AlmoxarifadoBundle\Entity\CalendarEvent',

        ));
    }
}
