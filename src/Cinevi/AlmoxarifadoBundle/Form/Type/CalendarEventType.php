<?php

namespace Cinevi\AlmoxarifadoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

        // Pega os usuários que o usuário atual pode ver
        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC');
        foreach ($userQB->getQuery()->getResult() as $result) {
            if (true === $this->authorizationChecker->isGranted('view', $result)) {
                $userArray[$result->getUsername()] = $result->getId();
            }
        }

        // Pega todos os equipamentos
        $equipamentoQB = $this->em->getRepository('CineviAlmoxarifadoBundle:Equipamento')->createQueryBuilder('e');
        $equipamentoQB->orderBy('e.nome', 'ASC');
        foreach ($equipamentoQB->getQuery()->getResult() as $result) {
            $equipamentoArray[$result->getNome()] = $result->getId();
        }

        // Pega os projetos que o usuário atual pode ver
        $projetoQB = $this->em->getRepository('CineviRealizacaoBundle:Projeto')->createQueryBuilder('p');
        $projetoQB->orderBy('p.id', 'DESC');
        foreach ($projetoQB->getQuery()->getResult() as $result) {
            if (true === $this->authorizationChecker->isGranted('view', $result)) {
                $projetoArray[$result->getRealizacao()->getTitulo()] = $result->getId();
            }
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
                )
            ))
            ->add('equipamentos', ChoiceType::class, array(
                'label' => 'Equipamento(s)',
                'choices' => $equipamentoArray,
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione opções...',
                'multiple' => true,
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
                )
            ))
            ->add('startDate', DateTimeType::class, array(
                'label'  => 'Data de Início',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                )
            ))
            ->add('endDate', DateTimeType::class, array(
                'label'  => 'Data de Fim',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'datepicker',
                )
            ))
        ;
        $builder->get('user')
            ->addModelTransformer(new EntityToIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
        ;
        $builder->get('equipamentos')
            ->addModelTransformer(new ArrayEntityToArrayIdObjectTransformer($this->em, 'CineviRealizacaoBundle:Equipamento'))
        ;
        $builder->get('projeto')
            ->addModelTransformer(new EntityToIdObjectTransformer($this->em, 'CineviRealizacaoBundle:Projeto'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\AlmoxarifadoBundle\Entity\CalendarEvent',

        ));
    }

}
