<?php

namespace App\Form\User;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Validation\User\UserValidationGroupResolver;
use App\Entity\User;

class UserType extends AbstractType
{
    private $authorizationChecker;
    private $groupResolver;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, UserValidationGroupResolver $groupResolver)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->groupResolver = $groupResolver;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Nome Completo',
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
            ))
            ->add('matricula', IntegerType::class, array(
                'label' => 'Matrícula/SIAPE',
                'attr' => array(
                    'class' => 'input-number'
                )
            ))
            ->add('telefone', TextType::class, array(
                'label' => 'Telefone',
                'attr' => array(
                    'class' => 'input-tel',
                )
            ))
            ->add('breveCurriculo', TextareaType::class, array(
                'label' => 'Breve Currículo',
                'required' => false,
            ))
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                array($this, 'onPreSetData')
            )
        ;

        if($this->authorizationChecker->isGranted('ROLE_DEPARTAMENTO')) {
            $builder
                ->add('enabled', ChoiceType::class, array(
                    'label' => 'Ativo?',
                    'choices' => array(
                        'Não' => '0',
                        'Sim' => '1',
                    ),
                    'expanded' => true,
                ))
                ->add('confirmado', ChoiceType::class, array(
                    'label' => 'Confirmado?',
                    'choices' => array(
                        'Não'   => '0',
                        'Sim'   => '1',
                    ),
                    'expanded' => true,
                ))
                ->add('professor', ChoiceType::class, array(
                    'label' => 'Professor?',
                    'choices' => array(
                        'Não' => '0',
                        'Sim' => '1',
                    ),
                    'expanded' => true,
                ))
            ;
        }

        if($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
            $builder
                ->add('roles', ChoiceType::class, array(
                    'label' => 'Permissões Especiais',
                    'choices' => array(
                        'Departamento' => 'ROLE_DEPARTAMENTO',
                        'Almoxarifado' => 'ROLE_ALMOXARIFADO',
                        'Administrador' => 'ROLE_SUPER_ADMIN',
                    ),
                    'multiple' => true,
                    'expanded' => true,
                    'required' => false,
                ))
            ;
        }
    }

    public function onPreSetData(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();

        if (!$user)
            return;

        if (!$user->getId()) {
            $form
                ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                    'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.new_password'),
                    'second_options' => array('label' => 'form.new_password_confirmation'),
                    'invalid_message' => 'fos_user.password.mismatch',
                )
            );
            $event->setData($user);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'validation_groups' => $this->groupResolver,
        ));
    }
}
