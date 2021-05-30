<?php

namespace App\Form;

use App\Entity\Model;
use App\Entity\Product;
use App\Entity\Wharehouse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class)
            ->add('price', NumberType::class, [
                'label' => 'Prix souhaité'
            ])
            ->add('productCondition', ChoiceType::class, [
                'choices' => Product::CONDITIONS
            ])
            ->add('model', EntityType::class, [
                'class' => Model::class,
                'choice_label' => 'name'
            ])
            ->add('wharehouse', EntityType::class, [
                'class' => Wharehouse::class,
                'choice_label' => 'city'
            ])
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
