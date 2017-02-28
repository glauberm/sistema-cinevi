<?php

namespace Cinevi\AlmoxarifadoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CalendarEventType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
	    $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $equipamentoQB = $this->em->getRepository('CineviAlmoxarifadoBundle:Equipamento')->createQueryBuilder('e');
        $equipamentoQB->orderBy('e.nome', 'ASC');

        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC')->andWhere('u.professor != 1');

        foreach ($userQB->getQuery()->getResult() as $result) {
            if (false === $this->authorizationChecker->isGranted('view', $result)) {
                $userQB->andWhere('u.id != '.$result->getId());
            }
        }

        $projetoQB = $this->em->getRepository('CineviAlmoxarifadoBundle:Projeto')->createQueryBuilder('p');
        $projetoQB->orderBy('p.nome', 'ASC');

        $builder
            ->add('user', EntityType::class, array(
                'label' => 'Responsável',
                'class' => 'CineviSecurityBundle:User',
                'query_builder' => $userQB,
                'choice_label' => 'getUsername',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
                'attr' => array(
                    'class' => 'select2-select',
                )
            ))
            ->add('equipamentos', EntityType::class, array(
                'label' => 'Equipamento',
                'class' => 'CineviAlmoxarifadoBundle:Equipamento',
                'query_builder' => $equipamentoQB,
                'choice_label' => 'getNome',
                'invalid_message' => 'Valor(es) inválido(s).',
                'placeholder' => 'Selecione uma opção...',
                'multiple' => true,
                'attr' => array(
                    'class' => 'select2-select',
                )
            ))
            ->add('projeto', EntityType::class, array(
                'label' => 'Projeto',
                'class' => 'CineviAlmoxarifadoBundle:Projeto',
                'query_builder' => $projetoQB,
                'choice_label' => 'getNome',
                'invalid_message' => 'Este não é um valor válido.',
                'placeholder' => 'Selecione uma opção...',
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\AlmoxarifadoBundle\Entity\CalendarEvent',

        ));
    }

}
