<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Category;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SearchRestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', EntityType::class,[
                'required'   => false,
                'empty_data' => null,
                'label' => "Ville",
                'class' => City::class,
                'choice_label' => function (City $city) {
                    return $city->getName();
                }
            ])
            ->add('category', EntityType::class,[
                'required'   => false,
                'empty_data' => null,
                'label' => "Catégorie",
                'class' => Category::class,
                'choice_label' => function (Category $category) {
                    return $category->getName();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
