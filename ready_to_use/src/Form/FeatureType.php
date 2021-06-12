<?php

namespace App\Form;

use App\Entity\Feature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('battery')
            ->add('camera')
            ->add('graphicCard')
            ->add('hardDisk')
            ->add('osVersion')
            ->add('processor')
            ->add('ram')
            ->add('screenSize')
            ->add('tactile')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Feature::class,
            'translation_domain' => 'forms'
        ]);
    }
}
