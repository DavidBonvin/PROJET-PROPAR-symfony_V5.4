<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Operation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationOperationTerminerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCommande')
            ->add('date')
            ->add('statut', TextType::class, [
                'data' => 'Terminer',
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'email',
                'required' => false
            ])
            ->add('operation', EntityType::class, [
                'class' => Operation::class,
                'choice_label' => 'type_operation',
                'required' => false
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
