<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Liste d'ingrédients courants pour des données réalistes
        $ingredients = [
            ['name' => 'Tomato', 'description' => 'A juicy red fruit often mistaken for a vegetable.'],
            ['name' => 'Milk', 'description' => 'A staple dairy product derived from cows.'],
            ['name' => 'Flour', 'description' => 'A powder obtained by grinding grains, often used in baking.'],
            ['name' => 'Sugar', 'description' => 'A sweet crystalline substance obtained from sugarcane or sugar beet.'],
            ['name' => 'Olive Oil', 'description' => 'A healthy oil extracted from olives, commonly used in cooking.'],
            ['name' => 'Almonds', 'description' => 'A crunchy and nutritious nut, rich in healthy fats.'],
            ['name' => 'Eggs', 'description' => 'A versatile ingredient sourced from chickens, used in various recipes.'],
        ];

        foreach ($ingredients as $index => $ingredientData) {
            $ingredient = new Ingredient();
            $ingredient->setName($ingredientData['name']);
            $ingredient->setDescription($ingredientData['description']);
            $ingredient->setVegan($faker->boolean(50)); // 50% chance of being vegan
            $ingredient->setDairyFree($faker->boolean(50)); // 50% chance of being dairy-free
            $ingredient->setGlutenFree($faker->boolean(50)); // 50% chance of being gluten-free
            $ingredient->setCreatedAt(new \DateTimeImmutable());
            $ingredient->setUpdatedAt(new \DateTimeImmutable());

            // Ajout d'une référence pour des relations éventuelles
            $this->addReference('ingredient_'.$index, $ingredient);

            $manager->persist($ingredient);
        }

        // Ajout d'ingrédients générés aléatoirement
        for ($i = 1; $i < 20; ++$i) {
            $ingredient = new Ingredient();
            $ingredient->setName($faker->word());
            $ingredient->setDescription($faker->paragraph(3));
            $ingredient->setVegan($faker->boolean(50));
            $ingredient->setDairyFree($faker->boolean(50));
            $ingredient->setGlutenFree($faker->boolean(50));

            $manager->persist($ingredient);

            $this->addReference('ingredient_1'.$i, $ingredient);
        }

        $manager->flush();
    }
}
