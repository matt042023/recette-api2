<?php

namespace App\DataFixtures;

use App\Entity\RecipeHasIngredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RecipeHasIngredientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; ++$i) {
            $recipeHasIngredient = new RecipeHasIngredient();

            // Generating a random quantity
            $recipeHasIngredient->setQuantity($faker->randomFloat(2, 0.1, 10)); // Random quantity between 0.1 and 10
            $recipeHasIngredient->setIsOptional($faker->boolean(30)); // 30% chance of being optional

            // Setting relations
            $recipe = $this->getReference('recipe_'.$faker->numberBetween(1, 19));
            $ingredient = $this->getReference('ingredient_'.$faker->numberBetween(1, 6));
            $ingredientGroup = $this->getReference('ingredient_group_'.$faker->numberBetween(1, 5));
            $unit = $this->getReference('unit_'.$faker->numberBetween(0, 8));

            $recipeHasIngredient->setRecipe($recipe);
            $recipeHasIngredient->setIngredient($ingredient);
            $recipeHasIngredient->setIngredientGroup($ingredientGroup);
            $recipeHasIngredient->setUnit($unit);

            $manager->persist($recipeHasIngredient);

            $this->addReference('recipeHasIngredient_'.$i, $recipeHasIngredient);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class,
            IngredientFixtures::class,
            IngredientGroupFixtures::class,
            UnitFixtures::class,
        ];
    }
}
