<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => new NotBlank([ 'message' => 'Vous devez remplir ce champs.'])
            ])
            ->add('email', EmailType::class, [
                'constraints' => new NotBlank([ 'message' => 'Vous devez remplir ce champs.'])
            ])
            ->add('password', PasswordType::class, [
                'constraints' => new NotBlank([ 'message' => 'Vous devez remplir ce champs.'])
            ])
//            ->add('agreeTerms', CheckboxType::class, [
//                'mapped' => false,
//                'constraints' => [
//                    new IsTrue([
//                        'message' => 'Vous devez accepter les mentions légales.',
//                    ]),
//                ],
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // traduction
            'translation_domain' => 'forms'
        ]);
    }
}
