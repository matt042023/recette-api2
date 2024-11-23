<?php

namespace App\DataFixtures;

use App\Entity\Step;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class StepFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; ++$i) {
            $step = new Step();

            // Remplir les attributs de Step
            $step->setContent($faker->paragraph(5)); // Contenu de l'étape (5 paragraphes)
            $step->setPriority($faker->numberBetween(1, 5)); // Priorité entre 1 et 5
            $step->setCreatedAt(new \DateTimeImmutable()); // Date de création aléatoire
            $step->setUpdatedAt(new \DateTimeImmutable()); // Date de mise à jour aléatoire

            // Ajouter une recette associée (relation Recipe)
            $recipe = $this->getReference('recipe_'.$faker->numberBetween(0, 19));
            $step->setRecipe($recipe);

            $manager->persist($step);

            // Ajouter une référence pour réutiliser l'entité dans d'autres fixtures
            $this->addReference('step_'.$i, $step);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class, // Dépendance à la fixture de Recipe
        ];
    }
}
