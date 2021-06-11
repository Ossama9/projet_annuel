<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Model;
use App\Repository\BrandRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("brand", EntityType::class, [
                "class" => Brand::class,
                "choice_label" => "name",
            ])

            ->add("max_price", RangeType::class, [
                "attr" => [
                    "min" => 0,
                    "max" => 1500,
                ]
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Rechercher"
            ])
        ;

        $formModifier = function (FormInterface $form, Brand $brand){
            $models = $brand->getModels();

            $form->add("model", EntityType::class, [
                "class" => Model::class,
                "choice_label" => "name",
                "choices" => $models
            ]);
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
            $data = $event->getData();

            if(isset($data)){
                $brand = $data->get("brand_id");
                $formModifier($event->getForm(), $brand);
            }
        });

        $builder->get("brand")->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $brand = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $brand);
            }
        );
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "max_price" => 1000
        ]);
    }
}