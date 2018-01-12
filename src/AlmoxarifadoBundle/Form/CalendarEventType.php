<?php

namespace AlmoxarifadoBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CalendarEventType extends AbstractType
{
    private $em;
    private $authorizationChecker;
    private $tokenStorageInterface;
    private $id;

    public function __construct(EntityManager $em, AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $tokenStorageInterface)
    {
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, array(
                'label' => 'Responsável',
                'class' => 'UserBundle:User',
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getAuthorizedUserFieldQB($this->authorizationChecker, 'user');
                },
    		    'choice_label' => 'getUsername',
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione uma opção...',
                ),
            ))
            ->add('projeto', EntityType::class, array(
                'label' => 'Projeto',
                'class' => 'RealizacaoBundle:Projeto',
    		    'query_builder' => function (EntityRepository $er) {
                    return $er->getAuthorizedProjetoFieldQB($this->authorizationChecker, 'user');
                },
    		    'choice_label' => 'getTitulo',
                'attr' => array(
                    'class' => 'select2-select',
                    'placeholder' => 'Selecione uma opção...',
                )
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
        ;

        $formModifier = function (FormInterface $form, \DateTime $startDate = null, \DateTime $endDate = null, $id = null) {

            $equipamentoQB = $this->em
                ->getRepository('AlmoxarifadoBundle:Equipamento')
                ->getAuthorizedEquipamentoFieldQB($this->tokenStorageInterface, $this->authorizationChecker, 'equipamento')
            ;

            if (!empty($startDate) && !empty($endDate)) {
                $reservas = $this->getReservas($startDate, $endDate, $id);
                $equipamentoQB = $this->validateEquipamentos($startDate, $endDate, $equipamentoQB, $reservas);
            }

            $form
                ->add('equipamentos', EntityType::class, array(
                    'label' => 'Reserváveis Disponíveis',
                    'class' => 'AlmoxarifadoBundle:Equipamento',
        		    'query_builder' => $equipamentoQB,
        		    'choice_label' => 'getCodigoAndNome',
                    'group_by' => 'getCategoriaByNome',
                    'multiple' => true,
                    'attr' => array(
                        'class' => 'select2-select',
                        'placeholder' => 'Selecione opções...',
                    )
                ))
            ;
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $form = $event->getForm();
                $data = $event->getData();
                $this->id = $event->getData()->getId();

                $formModifier($form, $data->getStartDate(), $data->getEndDate(), $this->id);
            }
        );

        $builder->get('endDate')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $form = $event->getForm()->getParent();
                $startDate = $form->get('startDate')->getData();
                $endDate = $form->get('endDate')->getData();

                $formModifier($form, $startDate, $endDate, $this->id);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AlmoxarifadoBundle\Entity\CalendarEvent',
        ));
    }

    private function getReservas($startDate, $endDate, $id)
    {
        $reservas = $this->em->getRepository('AlmoxarifadoBundle:CalendarEvent');

        if(empty($id)) {
            return $reservas->findAllBetweenDates($startDate, $endDate)
                ->getQuery()->getResult()
            ;
        } else {
            return $reservas->findAllBetweenDatesButId($startDate, $endDate, $id)
                ->getQuery()->getResult()
            ;
        }
    }

    private function validateEquipamentos($startDate, $endDate, $equipamentoQB, $reservas)
    {
        $fEquipamentos = $equipamentoQB->getQuery()->getResult();

        if (!empty($fEquipamentos)) {
            foreach( $reservas as $reserva ) {
                foreach( $reserva->getEquipamentos() as $rEquipamento ) {
                    foreach( $fEquipamentos as $fEquipamento ) {
                        if ($rEquipamento == $fEquipamento) {
                            $equipamentoQB->andWhere('equipamento.id != '.$fEquipamento->getId());

                            break;
                        }
                    }
                }
            }
        }

        return $equipamentoQB;
    }
}
