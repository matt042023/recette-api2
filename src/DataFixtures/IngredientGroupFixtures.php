<?php

namespace App\DataFixtures;

use App\Entity\IngredientGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class IngredientGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Liste d'exemples pré-définis
        $ingredientGroups = [
            'Fruits & Vegetables',
            'Dairy Products',
            'Dry Goods',
            'Meat & Poultry',
            'Seafood',
            'Spices & Condiments',
        ];

        foreach ($ingredientGroups as $index => $name) {
            $ingredientGroup = new IngredientGroup();
            $ingredientGroup->setName($name);
            $ingredientGroup->setPriority($faker->numberBetween(1, 5)); // Priorité aléatoire entre 1 et 5

            // Ajout de référence pour d'autres relations éventuelles
            $this->addReference('ingredient_group_'.$index, $ingredientGroup);

            $manager->persist($ingredientGroup);
        }

        // Ajout de groupes générés aléatoirement
        for ($i = 0; $i < 10; ++$i) {
            $ingredientGroup = new IngredientGroup();
            $ingredientGroup->setName($faker->words(2, true)); // Génère un nom aléatoire de 2 mots
            $ingredientGroup->setPriority($faker->numberBetween(1, 5)); // Priorité aléatoire

            $manager->persist($ingredientGroup);
        }

        $manager->flush();
    }
}
