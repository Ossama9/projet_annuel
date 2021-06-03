<?php

namespace App\Form;

use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('quantity')
        ->add('productCondition', ChoiceType::class, [
            'label' => 'Product condition',
            'choices' => array_flip(Product::CONDITIONS),
            'mapped' => false,
            'required' => true
        ])
        ->add('add', SubmitType::class, [
            'label' => 'Add to cart'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
            'translation_domain' => 'forms'
        ]);
    }
}