<?php

namespace Cinevi\AlmoxarifadoBundle\Form\Type;

use Doctrine\ORM\EntityManager;
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
use Cinevi\AdminBundle\Form\Transformer\EntityToIdObjectTransformer;
use Cinevi\AlmoxarifadoBundle\Entity\CalendarEvent;

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
        $userArray = array();
        $projetoArray = array();

        // Pega os usuários que o usuário atual pode ver
        $userQB = $this->em->getRepository('CineviSecurityBundle:User')->createQueryBuilder('u');
        $userQB->orderBy('u.username', 'ASC');
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

        $builder
            ->add('user', ChoiceType::class, array(
                'label' => 'Responsável',
                'choices' => $userArray,
                'invalid_message' => 'Este não é um valor válido.',
                'choices_as_values' => true,
                'attr' => array(
                    'placeholder' => 'Selecione uma opção...',
                    'class' => 'select2-select',
                ),
            ))
            ->add('projeto', ChoiceType::class, array(
                'label' => 'Projeto',
                'choices' => $projetoArray,
                'invalid_message' => 'Este não é um valor válido.',
                'choices_as_values' => true,
                'attr' => array(
                    'placeholder' => 'Selecione uma opção...',
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
        ;

        // FORM MODIFIER
        $formModifier = function (FormInterface $form, \DateTime $startDate = null, \DateTime $endDate = null, $id = null) {
            $equipamentosArray = array();
            $equipamentosPorCategoriaArray = array();

            $equipamentoQB = $this->equipamentosValidos();

            if (!empty($startDate) && !empty($endDate)) {
                $equipamentoQB = $this->equipamentosPorData($equipamentoQB, $startDate, $endDate, $id);
            }

            foreach ($equipamentoQB->getQuery()->getResult() as $equipamento) {
                $equipamentosPorCategoriaArray[$equipamento->getCategoria()->getNome()]['['.$equipamento->getCodigo().'] '.$equipamento->getNome()] = $equipamento->getId();
            }

            $form
                ->add('equipamentos', EquipamentoExtensionType::class, array(
                    'label' => 'Reserváveis Disponíveis',
                    'choices' => $equipamentosPorCategoriaArray,
                    'invalid_message' => 'Este não é um valor válido.',
                    'multiple' => true,
                    'choices_as_values' => true,
                    'attr' => array(
                        'placeholder' => 'Selecione opções...',
                        'class' => 'select2-select',
                    ),
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

        $builder->get('user')
            ->addModelTransformer(new EntityToIdObjectTransformer($this->em, 'CineviSecurityBundle:User'))
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

    private function equipamentosValidos()
    {
        // Encontre seus equipamentos que não estejam em manutenção
        $equipamentoQB = $this->em->getRepository('CineviAlmoxarifadoBundle:Equipamento')->createQueryBuilder('e');
        $equipamentoQB->orderBy('e.codigo', 'ASC')
            ->where('e.manutencao != 1')
        ;

        // Para cada equipamento
        foreach ($equipamentoQB->getQuery()->getResult() as $equipamento) {
            // Veja se o campo users está vazio
            if (!$equipamento->getUsers()->isEmpty()) {
                foreach ($equipamento->getUsers() as $user) {
                    // Se não estiver, checa se o usuário está entre esses ou tem ROLE_DEPARTAMENTO
                    if ($user !== $this->tokenStorageInterface->getToken()->getUser() || !$this->authorizationChecker->isGranted('ROLE_DEPARTAMENTO')) {
                        // Se não tiver, exclui esse equipamento dos resultados
                        $equipamentoQB->andWhere('e.id != '.$result->getId());
                    }
                }
            }
        }

        return $equipamentoQB;
    }

    private function equipamentosPorData($equipamentoQB, \DateTime $fStartDate, \DateTime $fEndDate, $id = null)
    {
        $interval = new \DateInterval('P1D');
        $fEquipamentos = $equipamentoQB->getQuery()->getResult();

        if (!empty($id)) {
            $reservas = $this->em->createQueryBuilder();
            $reservas->select('cv')
                    ->from('CineviAlmoxarifadoBundle:CalendarEvent', 'cv')
                    ->where('cv.id != (:id)')
                    ->setParameter('id', $id);

            $reservas = $reservas->getQuery()->getResult();
        } else {
            $reservas = $this->em->getRepository('CineviAlmoxarifadoBundle:CalendarEvent')->findAll();
        }

        if (!empty($fEquipamentos)) {
            if($fStartDate == $fEndDate) {
                $cfEndDate = clone $fEndDate;
                $cfEndDate->add($interval);

                $fPeriod = new \DatePeriod($fStartDate, $interval, $cfEndDate);
            } else {
                $fPeriod = new \DatePeriod($fStartDate, $interval, $fEndDate);
            }

            foreach ($reservas as $reserva) {
                foreach ($reserva->getEquipamentos() as $rEquipamento) {
                    foreach ($fEquipamentos as $fEquipamento) {
                        if ($rEquipamento == $fEquipamento) {
                            $rStartDate = $reserva->getStartDate();
                            $rEndDate = $reserva->getEndDate();

                            if($rStartDate == $rEndDate) {
                                $crEndDate = clone $rEndDate;
                                $crEndDate->add($interval);

                                $rPeriod = new \DatePeriod($rStartDate, $interval, $crEndDate);
                            } else {
                                $rPeriod = new \DatePeriod($rStartDate, $interval, $rEndDate);
                            }

                            foreach ($rPeriod as $rDay) {
                                foreach ($fPeriod as $fDay) {

                                    if ($rDay == $fDay) {
                                        // Se bater, exclui esse equipamento dos resultados
                                        $equipamentoQB->andWhere('e.id != '.$rEquipamento->getId());

                                        break 3;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $equipamentoQB;
    }
}
