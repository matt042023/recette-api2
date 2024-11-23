<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; ++$i) {
            $recipe = new Recipe();

            // Remplir les attributs de Recipe
            $recipe->setName($faker->sentence(3)); // Nom de la recette (3 mots)
            $recipe->setDescription($faker->paragraph(5)); // Description de 5 paragraphes
            $recipe->setDraft($faker->boolean()); // Statut brouillon
            $recipe->setCooking($faker->optional()->numberBetween(5, 120)); // Temps de cuisson (5 à 120 minutes)
            $recipe->setBreak($faker->optional()->numberBetween(0, 60)); // Temps de repos
            $recipe->setPreparation($faker->optional()->numberBetween(10, 90)); // Temps de préparation
            $recipe->setCreatedAt(new \DateTimeImmutable()); // Date de création aléatoire
            $recipe->setUpdatedAt(new \DateTimeImmutable()); // Date de mise à jour aléatoire

            $manager->persist($recipe);
            $this->addReference('recipe_'.$i, $recipe);
        }

        $manager->flush();
    }
}
