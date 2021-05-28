<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserVerification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserVerificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En attente' => 0,
                    'Vérifié' => 1,
                    'Refusé' => 2
                ]
            ])
            ->add('requestDate')
            ->add('requestingUser', UserType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserVerification::class,
            'translation_domain' => 'forms'
        ]);
    }
}
