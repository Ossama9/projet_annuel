<?php


namespace App\Form;


use App\Entity\Brand;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("brand", EntityType::class, [
                "class" => Brand::class,
                "choice_label" => "name"
            ])
            ->add("model", EntityType::class, [
                "model" => Model::class,
                "choice_label" => "name"
            ])
            ->add("max_price", RangeType::class, [
                "attr" => [
                    "min" => 0,
                    "max" => 1000
                ]
            ]);
    }

}