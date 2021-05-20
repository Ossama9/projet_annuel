<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', ChoiceType::class, [
                'choices' => [
                    'Apple' => 'apple',
                    'Samsung' => 'samsung'
                ]
            ])
            ->add('model')
            ->add('description')
            ->add('productCondition', ChoiceType::class, [
                'choices' => [
                    'État correct' => 0,
                    'Bon état' => 1,
                    'Très bon état' => 2,
                    'Comme neuf' => 3
                ]
            ])
            ->add('price')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'translation_domain' => 'forms'
        ]);
    }
}
