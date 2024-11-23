<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
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

            // Ajouter des Tags
            for ($j = 0; $j < $faker->numberBetween(1, 5); ++$j) {
                $tag = $this->getReference('tag_'.$faker->numberBetween(1, 19));
                $recipe->addTag($tag);
            }

            // Ajouter des Sources
            for ($k = 0; $k < $faker->numberBetween(1, 3); ++$k) {
                $source = $this->getReference('source_'.$faker->numberBetween(1, 9));
                $recipe->addSource($source);
            }

            // Ajouter des Steps
            for ($l = 0; $l < $faker->numberBetween(1, 5); ++$l) {
                $step = $this->getReference('step_'.$faker->numberBetween(1, 19));
                $recipe->addStep($step);
            }

            $manager->persist($recipe);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TagFixtures::class,
            SourceFixtures::class,
            StepFixtures::class,
        ];
    }
}
