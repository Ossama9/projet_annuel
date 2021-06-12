<?php

namespace App\Form;

use App\Entity\Model;
use App\Entity\Product;
use App\Entity\Wharehouse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class)
            ->add('price', NumberType::class, [
                'label' => 'Prix souhaité'
            ])
            ->add('productCondition', ChoiceType::class, [
                'choices' => array_flip(Product::CONDITIONS)
            ])
            ->add('model', EntityType::class, [
                'class' => Model::class,
                'choice_label' => 'name'
            ])
            ->add('pictures', FileType::class, [
                'label' => 'Insérez une image',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Les seuls formats acceptés sont jpg et png.',
                    ])
                ],
            ])
            ->add('feature', FeatureType::class)
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
