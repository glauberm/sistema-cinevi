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
use Cinevi\AdminBundle\Form\Transformer\ArrayEntityToArrayIdObjectTransformer;
use Cinevi\AlmoxarifadoBundle\Form\Type\EquipamentoExtensionType;
use Cinevi\AlmoxarifadoBundle\Entity\CalendarEvent;

class CalendarEventType extends AbstractType
{
    private $em;
    private $authorizationChecker;
    private $tokenStorageInterface;

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
        $formModifier = function (FormInterface $form, \DateTime $startDate = null, \DateTime $endDate = null, $id = null)
        {
            $categoriaArray = array();
            $equipamentosArray = array();

            $equipamentoQB = $this->equipamentosValidos();

            if(!empty($startDate) && !empty($endDate)) {
                $equipamentoQB = $this->equipamentosPorData($form, $equipamentoQB, $startDate, $endDate, $id);
            }

            $categoriaQB = $this->em->getRepository('CineviAlmoxarifadoBundle:Categoria')->createQueryBuilder('c');
            $categoriaQB->orderBy('c.nome', 'ASC');

            foreach ($categoriaQB->getQuery()->getResult() as $categoria) {
                $equipamentoQB
                    ->andWhere('e.categoria = '.$categoria->getId())
                ;

                foreach ($equipamentoQB->getQuery()->getResult() as $equipamento) {
                    $equipamentosArray[$equipamento->getNome()] = $equipamento->getId();
                }

                $categoriaArray[$categoria->getNome()] = $equipamentosArray;
            }

            $form
                ->add('equipamentos', EquipamentoExtensionType::class, array(
                    'label' => 'Equipamento(s)',
                    'choices' => $categoriaArray,
                    'invalid_message' => 'Este não é um valor válido.',
                    'multiple' => true,
                    'choices_as_values' => true,
                    'attr' => array(
                        'placeholder' => 'Selecione opções...',
                        'class' => 'select2-select',
                    )
                ))
            ;
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier)
            {
                $form = $event->getForm();
                $data = $event->getData();

                $formModifier($form, $data->getStartDate(), $data->getEndDate(), $event->getData()->getId());
            }
        );

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) use ($formModifier)
            {
                $startDate = $event->getForm()->get('startDate')->getData();
                $endDate = $event->getForm()->get('endDate')->getData();

                $formModifier($event->getForm(), $startDate, $endDate, $event->getData()->getId());
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
        $equipamentoQB->orderBy('e.nome', 'ASC')
            ->where('e.manutencao != 1')
        ;

        // Para cada equipamento
        foreach ($equipamentoQB->getQuery()->getResult() as $equipamento) {
            // Veja se o campo users está vazio
            if(!$equipamento->getUsers()->isEmpty()) {
                foreach($equipamento->getUsers() as $user) {
                    // Se não estiver, checa se o usuário está entre esses ou tem ROLE_DEPARTAMENTO
                    if($user !== $this->tokenStorageInterface->getToken()->getUser() || !$this->authorizationChecker->isGranted('ROLE_DEPARTAMENTO')) {
                        // Se não tiver, exclui esse equipamento dos resultados
                        $equipamentoQB->andWhere('e.id != '.$result->getId());
                    }
                }
            }
        }

        return $equipamentoQB;
    }

    private function equipamentosPorData($form, $equipamentoQB, \DateTime $fStartDate, \DateTime $fEndDate, $id = null)
    {
        $interval = \DateInterval::createFromDateString('1 day');
        $fEquipamentos = $equipamentoQB->getQuery()->getResult();

        if(!empty($id)) {
            $reservas = $this->em->createQuery('SELECT cv FROM '.CalendarEvent::class.' cv WHERE cv.id != '.$id)->getResult();
        } else {
            $reservas = $this->em->getRepository('CineviAlmoxarifadoBundle:CalendarEvent')->findAll();
        }

        if(!empty($fEquipamentos)) {
            $fPeriod = new \DatePeriod($fStartDate, $interval, $fEndDate);

            foreach( $reservas as $reserva ) {
                foreach( $reserva->getEquipamentos() as $rEquipamento ) {
                    foreach( $fEquipamentos as $fEquipamento ) {
                        if( $rEquipamento == $fEquipamento ) {

                            $rStartDate = $reserva->getStartDate();
                            $rEndDate = $reserva->getEndDate();
                            $rPeriod = new \DatePeriod($rStartDate, $interval, $rEndDate);

                            foreach ( $rPeriod as $rDay ) {
                                foreach ( $fPeriod as $fDay ) {
                                    if($rDay == $fDay) {
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
