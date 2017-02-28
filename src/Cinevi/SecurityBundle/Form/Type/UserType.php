<?php

namespace Cinevi\SecurityBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserType extends AbstractType
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Nome de Usuário',
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
            ))
            ->add('matricula', IntegerType::class, array(
                'label' => 'Matrícula',
            ))
            ->add('telefone', IntegerType::class, array(
                'label' => 'Telefone',
            ))
        ;

        if($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
            $builder
                ->add('confirmado', ChoiceType::class, array(
                    'label' => 'Confirmado?',
                    'choices' => array(
                        'Não'   => '0',
                        'Sim'   => '1',
                    ),
                    'choices_as_values' => true,
                    'expanded' => true,
                ))
                ->add('enabled', ChoiceType::class, array(
                    'label' => 'Ativo?',
                    'choices' => array(
                        'Não' => '0',
                        'Sim' => '1',
                    ),
                    'choices_as_values' => true,
                    'expanded' => true,
                ))
                ->add('professor', ChoiceType::class, array(
                    'label' => 'Professor?',
                    'choices' => array(
                        'Não' => '0',
                        'Sim' => '1',
                    ),
                    'choices_as_values' => true,
                    'expanded' => true,
                ))
                ->add('roles', ChoiceType::class, array(
                    'label' => 'Permissões',
                    'choices' => array(
                        'Usuário'       => 'ROLE_USER',
                        'Funcionário'   => 'ROLE_FUNCIONARIO',
                        'Administrador' => 'ROLE_SUPER_ADMIN',
                    ),
                    'choices_as_values' => true,
                    'multiple' => true,
                    'expanded' => true,
                ))
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Cinevi\SecurityBundle\Entity\User',

        ));
    }
}
