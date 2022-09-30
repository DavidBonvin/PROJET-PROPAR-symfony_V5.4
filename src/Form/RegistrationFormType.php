<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Mime\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uuid')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('roles', CollectionType::class, [
                'entry_type'   => ChoiceType::class,

                'entry_options'  => [
                    'choices'  => [
                        'EXPERT' => 'ROLE_EXPERT',
                        'APPRENTI'     => 'ROLE_APPRENTI',
                        'SENIOR'    => 'ROLE_SENIOR',

                    ],
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent etre identique.',
                'options' => ['attr' => ['class' => 'Votre mot de passe']],
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr'  => [
                        'placeholder' => 'Merci de saisir votre mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr'  => [
                        'placeholder' => 'Merci de confirmer votre mot de passe'
                    ]
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
