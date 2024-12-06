<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\IngredientGroup;
use App\Entity\RecipeHasIngredient;
use App\Entity\Unit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<RecipeHasIngredient>
 */
class RecipeHasIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', NumberType::class, [
                'label' => 'Quantité',
                'required' => true,
            ])
            ->add('isOptional', CheckboxType::class, [
                'mapped' => true,
                'required' => false,
                'label' => 'Optionnel',
            ])
            ->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner un ingrédient',
                'required' => true,
            ])
            ->add('ingredientGroup', EntityType::class, [
                'class' => IngredientGroup::class,
                'choice_label' => 'name',
                'label' => 'Groupe d\'ingrédients',
                'required' => false,
            ])
            ->add('unit', EntityType::class, [
                'class' => Unit::class,
                'choice_label' => 'singular',
                'label' => 'Unité',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeHasIngredient::class,
        ]);
    }
}
